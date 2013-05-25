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
		select distinct p.payable_id,p.payable_amount,
		p.to_org_id,p.to_org_name,
		p.from_org_id,p.from_org_name,
		
		lfo.lo_foid,d.seller_payer,
		d.hub_covers_fees,lo.payment_method,
		lo.fee_percen_lo,lo.fee_percen_hub
		from v_payables p
		inner join lo_fulfillment_order lfo on lfo.lo_foid=p.parent_obj_id
		inner join lo_order_line_item loi on (lfo.lo_foid=loi.lo_foid)
		inner join lo_order lo on (lo.lo_oid=loi.lo_oid)
		inner join domains d on lfo.domain_id=d.domain_id
		inner join lo_order_item_status_changes loisc on (loi.lo_liid=loisc.lo_liid and loisc.ldstat_id=4)
	
		where p.amount_due > 0
		and   p.payable_type='seller order'
		and  loisc.creation_date > '2013-05-15 00:00:00'
";

$sql .= 'order by to_org_id,from_org_id';


#echo($sql);
$orders = array();
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
	
	$fee = floatval($result['fee_percen_lo']);
	if($result['payment_method'] == 'paypal')
	{
		$fee += floatval($result['paypal_processing_fee']);
	}
	
	if($result['seller_payer'] == 'lo')
	{
		# the LO is in charge of paying sellers 
		$fee += floatval($result['fee_percen_hub']);
	}
	else
	{
		if($result['from_org_id'] == 1)
		{
			# if this is the payment from the lo to the market,
			# then don't subtract any more fees. Send the market fee over with it.
		}
		else
		{
			# otherwise, it's from the market to the seller
			# subtract the hub fees, but only if 	
			$fee = floatval($result['fee_percen_lo']) + (($result['hub_covers_fees'] == 1)?$result['fee_percen_hub']:0);
		}
	}
	
	$new_amount = round(floatval($total * ((100 - $fee) / 100)),2);
	$old_amount = round(floatval($result['payable_amount']),2);
	
	if($new_amount != $old_amount)
	{
		echo($result['to_org_name'].": need to adjust ".$result['lo_foid']." from ".$old_amount." to ".$new_amount."\n");
		$sql = 'update payables set amount='.$new_amount.' where payable_id='.$result['payable_id'];
		if($do_fix)
		{
			echo($sql."\n");
			mysql_query($sql);
		}
	}
}



exit("complete\n");

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