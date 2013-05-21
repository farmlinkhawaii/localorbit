<?php
$v_payables = core::model('v_payables')->collection();
$v_payables->add_formatter('format_payable_info');
if(!lo3::is_admin())
{
	$v_payables->filter('from_org_id','=',$core->session['org_id']);
}
$payables = new core_datatable('payables','payments/review_orders',$v_payables);
payments__add_standard_filters($payables,'payables');
$payables->add(new core_datacolumn('creation_date','Ref #',false,'14%',			'{ref_nbr_html}','{ref_nbr_html}','{ref_nbr_html}'));
$payables->add(new core_datacolumn('po_number','PO #',false,'10%',			'{po_number}','{po_number}','{po_number}'));
$payables->add(new core_datacolumn('creation_date','Description',false,'23%','{description_html}','{description_html}','{description_html}'));
$payables->add(new core_datacolumn('creation_date','Order Date',true,'10%','{creation_date}','{creation_date}','{creation_date}'));
$payables->add(new core_datacolumn('delivery_end_time','Deliver Date',true,'10%','{delivery_end_time_html}','{delivery_end_time_html}','{delivery_end_time_html}'));
$payables->add(new core_datacolumn('due_date','Payment Due',true,'12%','{payment_due}','{payment_due}','{payment_due}'));
$payables->add(new core_datacolumn('amount','Amount',true,'8%','{amount}','{amount}','{amount}'));
#$payables->add(new core_datacolumn('status','Payment Status',true,'12%','{payment_status}','{payment_status}','{payment_status}'));
$payables->add(new core_datacolumn('payable_id',array(core_ui::check_all('payables'),'',''),false,'4%',core_ui::check_all('payables','payable_id'),' ',' '));

$payables->columns[3]->autoformat='date-short';
//$payables->columns[4]->autoformat='date-short';
$payables->columns[6]->autoformat='price';
?>

<div class="tab-pane tabarea" id="paymentstabs-a<?=($core->view[0]+1)?>">
	<div id="payables_list">
		<?
		$payables->render();
		?>
		<div class="pull-right" id="create_payment_button">
			<?php if(lo3::is_admin() || lo3::is_market()){?>
			<input type="button" onclick="core.payments.sendInvoices();" class="btn btn-info" value="Send Invoices" />
			<?}?>
			<input type="button" onclick="core.payments.makePayments();" class="btn btn-info" value="Make Payment" />
		</div>
	</div>
	<div id="payables_actions" style="display: none;">
		
	</div>
</div>

