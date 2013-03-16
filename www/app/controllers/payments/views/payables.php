<?php
$payments_owed = core::model('v_invoices')
	->add_custom_field('DATEDIFF(CURRENT_TIMESTAMP,due_date) as age')
	->collection()
	->filter('from_org_id' , $core->session['org_id'])
	->filter('amount_due', '>', 0);


function payable_age_formatter($data)
{
	if($data['age'] <= 0)
	{
		$data['age'] = 'Current';
	}
	else
	{
		$data['age'] = '<span class="text-error">'.$data['age'].'</span>';
	}
	return $data;
}

$payments_owed->add_formatter('payable_info');
$payments_owed->add_formatter('payment_link_formatter');
$payments_owed->add_formatter('payment_direction_formatter');
$payments_owed->add_formatter('payable_age_formatter');
if(lo3::is_market() || lo3::is_admin())
	$payments_owed->add_formatter('lfo_accordion');
	
$payments_table = new core_datatable('payables','payments/payables',$payments_owed);
$payments_table = payments__add_standard_filters($payments_table,'payments');
$payments_table->add(new core_datacolumn('invoice_id','Reference',true,'20%',			'{description_html}','{description}','{description}'));
$payments_table->add(new core_datacolumn('from_org_name','Description',false,'40%','{direction_info}','{from_org_name}','{from_org_name}'));
$payments_table->add(new core_datacolumn('creation_date','Invoice Date',true,'10%','{creation_date}','{creation_date}','{creation_date}'));
$payments_table->add(new core_datacolumn('due_date','Due Date',true,'10%','{due_date}','{due_date}','{due_date}'));
$payments_table->add(new core_datacolumn('DATEDIFF(due_date,CURRENT_TIMESTAMP)','Overdue',true,'10%',			'{age}','{age}','{age}'));
$payments_table->add(new core_datacolumn('amount_due','Amount Due',true,'10%',			'{amount_due}','{amount_due}','{amount_due}'));
$payments_table->add(new core_datacolumn('payment_id',array(core_ui::check_all('payments'),'',''),false,'4%',core_ui::check_all('payments','invoice_id'),' ',' '));


$payments_table->columns[2]->autoformat='date-long-wrapped';
$payments_table->columns[3]->autoformat='date-short';

#$payments_table->columns[3]->autoformat='price';
$payments_table->sort_direction='desc';

?>

<div class="tabarea tab-pane" id="paymentstabs-a<?=$core->view[0]?>">
	<div id="all_all_payments">
		<?
		$payments_table->render();
		?>
		<div class="pull-right" id="create_payment_button">
			<input type="button" onclick="core.payments.<?=((lo3::is_admin())?'enterInvoices':'makePayments')?>('payments');" class="btn btn-info" value="Make Payment" />
		</div>
	</div>
	
	<br />&nbsp;<br />
	<div id="payments_pay_area" style="display: none;">
		
	</div>
	<? 
	#$this->payments__pay_payment();
	
	?>
</div>
