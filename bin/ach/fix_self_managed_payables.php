#!/usr/bin/php
<?php
define('__CORE_ERROR_OUTPUT__','exit');
include(dirname(__FILE__).'/../../www/app/core/core.php');
core::init();
core::load_library('crypto');


array_shift($argv);
$domain_id = 0;
$do_fix = false;
while(count($argv) > 0)
{
	$param = array_shift($argv);
	if(is_numeric){
		$domain_id = $param;
	}
	if($param == 'do-fix')
	{
		$do_fix = true;
	}
}



$actually_do_fix = $argv[1] == 'do-fix';

$sql = "
		select p.payable_id,p.payable_amount,p.to_org_id,o1.name,lfo.lo_foid,
		d.hub_covers_fees,lo.payment_method,
		lo.fee_percen_lo,lo.fee_percen_hub,
		p2.payable_amount as seller_amount,
		p2.payable_id as seller_payable_id
		from v_payables p
		inner join organizations o1 on p.to_org_id=o1.org_id
		inner join lo_fulfillment_order lfo on lfo.lo_foid=p.parent_obj_id
		inner join lo_order_line_item loi on (lfo.lo_foid=loi.lo_foid)
		inner join lo_order lo on (lo.lo_oid=loi.lo_oid)
		inner join domains d on lfo.domain_id=d.domain_id
		left join v_payables p2 on (p2.parent_obj_id=p.parent_obj_id and p2.payable_type='seller order' and p2.from_org_id<>1)
		where p.amount_due > 0
		and   p.payable_type='seller order'
		and   p.from_org_id=1
";

$sql .= 'group by lfo.lo_foid';

$orgs = array();
$results = new core_collection($sql);
foreach($results as $result)
{
	$sql = '
		select sum(row_adjusted_total) as item_total
		from lo_order_line_item
		where lo_foid='.$result['lo_foid'];
	$total = mysql_query($sql);
	$total = mysql_fetch_assoc($total);
	$total = $total['item_total'];
	
	$key = $result['to_org_id'].'-'.$result['name'];
	if(!array_key_exists($result['to_org_id'],$orgs))
	{
		$orgs[$result['to_org_id']] = array(
			'name'=>$result['name'],
			'fee_1'=>0,
			'fee_2'=>0,
			'total_amount_1'=>0,
			'total_amount_2'=>0,
			'adjusted_total_amount_1'=>0,
			'adjusted_total_amount_2'=>0,
			'orders'=>array(),
		);
	}
	
	# figure out the right fee
	$fee1 = 0;
	$fee2 = 0;
	if(is_numeric($result['seller_payable_id']))
	{
		# the money is from lo to the market, and there's a second one from the market to the seller
		$fee1 = floatval($result['fee_percen_lo']) + floatval($result['fee_percen_hub']);
		$fee2 = floatval($result['fee_percen_lo']) + (($result['hub_covers_fees'] == 1)?$result['fee_percen_hub']:0);
		
		if($result['payment_method'] == 'paypal')
		{
			$fee1 += floatval($result['paypal_processing_fee']);
			$fee2 += floatval($result['paypal_processing_fee']);
		}
	}
	else
	{
		# the money is directly from lo to the seller
		$fee1 = floatval($result['fee_percen_lo']) + (($result['hub_covers_fees'] == 1)?$result['fee_percen_hub']:0);
		if($result['payment_method'] == 'paypal')
		{
			$fee1 += floatval($result['paypal_processing_fee']);
		}
	}
	$orgs[$result['to_org_id']]['fee_1'] = $fee1;
	$orgs[$result['to_org_id']]['fee_2'] = $fee2;
	

	$orgs[$result['to_org_id']]['total_amount_1']           += floatval($result['payable_amount']);
	$orgs[$result['to_org_id']]['total_amount_2']       += floatval($result['seller_amount']);
	$orgs[$result['to_org_id']]['adjusted_total_amount_1']     += round(($total * ((100 - $fee1) / 100)),2);
	$orgs[$result['to_org_id']]['adjusted_total_amount_2'] += round(($total * ((100 - $fee2) / 100)),2);
	$orgs[$result['to_org_id']]['orders'][] = array(
		'lo_foid'=>$result['lo_foid'],
		'original_amount_1'=>$result['payable_amount'],
		'original_amount_2'=>$result['seller_amount'],
		'new_amount_1'=>round(($total * ((100 - $fee1) / 100)),2),
		'new_amount_2'=>round(($total * ((100 - $fee2) / 100)),2),
		'payable_id_1'=>$result['payable_id'],
		'payable_id_2'=>$result['seller_payable_id'],
	);

}


foreach($orgs as $org)
{
	# format the numbers for comparison
	$org['total_amount_1'] = round(floatval($org['total_amount_1']),2);
	$org['total_amount_2'] = round(floatval($org['total_amount_2']),2);
	$org['adjusted_total_amount_1'] = round(floatval($org['adjusted_total_amount_1']),2);
	$org['adjusted_total_amount_2'] = round(floatval($org['adjusted_total_amount_2']),2);
	
	# determine whether or not we need to adjust
	$check1 = false;
	$check1 = ($org['total_amount_1'] != $org['adjusted_total_amount_1']);
	
	$check2 = false;
	$check2 = ($org['fee2'] > 0 && $org['total_amount_2'] != $org['adjusted_total_amount_2']);
	
	# if we do, start echo'ing
	if($check1 || $check2)
	{
		echo("need to adjust ".$org['name']." / ".$org['fee_1']." / ".$org['fee_2']."\n");
		
		# loop through the orders and figure out which payables actually need adjustment
		foreach($org['orders'] as $order)
		{
			$order['original_amount_1'] = round(floatval($order['original_amount_1']),2);
			$order['original_amount_2'] = round(floatval($order['original_amount_2']),2);
			$order['new_amount_1'] = round(floatval($order['new_amount_1']),2);
			$order['new_amount_2'] = round(floatval($order['new_amount_2']),2);
			
			
			if($order['original_amount_1'] != $order['new_amount_1'])
			{
				echo("\tadjust payable ".$order['payable_id_1']." for foid ".$order['lo_foid']." from ".$order['original_amount_1']." to ".$order['new_amount_1']."\n");
				$sql = 'update payables set amount='.$order['new_amount_1'].' where payable_id= '.$order['payable_id_1'];
				#echo($sql."\n");
				if($do_fix)
				{
					mysql_query($sql);
				}
			}
			
			
			if($org['fee2'] > 0 && $order['original_amount_2'] != $order['new_amount_2'])
			{
				echo("\tadjust payable ".$order['payable_id_2']." from ".$order['original_amount_2']." to ".$order['new_amount_2']."\n");
				$sql = 'update payables set amount='.$order['new_amount_2'].' where payable_id= '.$order['payable_id_2'];
				#echo($sql."\n");
				if($do_fix)
				{
					mysql_query($sql);
				}
			}
		}
	}
	else
	{
		echo("this org is ok: ".$org['name']."\n");
	}
}
exit();

/*

foreach($orgs as $org)
{
	if($org['to_mm_amount'] != $org['adjusted_amount'])
	{
		echo("need to fix orders for ".$org['name'].". New total: ".$org['adjusted_amount'].":\n");
		foreach($org['orders'] as $order)
		{
			$order = explode(':',$order);
			echo("\tpayable for ".$order[0]." currently ".$order[2].", should be ".$order[3].",\n");
			$sql = 'update payables set amount='.$order[3].' 
			where payable_type_id=2
			and from_org_id=1
			and parent_obj_id='.$order[0];
			
			if($do_fix)
			{
				mysql_query($sql);
			}
			#print_r($order);
		}
	}
}
*/
#print_r($orgs);



exit("complete!\n");

?>