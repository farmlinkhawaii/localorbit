<?php
global $core;

core::log(print_r($core->data,true));

$invoices = core::model('v_invoices')
	->collection()
	->filter('invoice_id','in',explode(',',$core->data['checked_invoices']))
	->sort('concat_ws(\'-\',to_org_id,from_org_id)');
$invoices->add_formatter('payable_info');
$invoices->add_formatter('payment_link_formatter');
$invoices->add_formatter('payment_direction_formatter');	

$cur_group = '';
$group_total = 0;
core::js('core.payments.invoiceGroups={};');


$button_label = (lo3::is_market() || lo3::is_admin())?'save payments':'make payment';


foreach($invoices as $invoice)
{
	core::log('building UI for invoice '.$invoice['invoice_id']);
	if($invoice['to_org_id'].'_'.$invoice['from_org_id'] != $cur_group)
	{
		if($cur_group != '')
		{
			core::js('core.payments.invoiceGroups[\''.$cur_group.'\']='.$group_total.';');
			echo('</table><br />&nbsp;<br /><hr /><br />&nbsp;<br />');
		}
				
		$cur_group = $invoice['to_org_id'].'_'.$invoice['from_org_id'];
		$group_total = 0;
		$inv_counter = 0;
		
		$label = 'Amount Received';
		
		if($invoice['from_org_id'] == $core->session['org_id'])
		{
			$label = 'Amount to Pay';
		}
		
		?>
		<h3>From <?=$invoice['from_org_name']?> to <?=$invoice['to_org_name']?></h3>
		<?=core_form::value('Amount Due','',array('id'=>'payment_amount_due_'.$cur_group))?>
		<?=core_form::input_text($label ,'payment_amount_'.$cur_group,0,array('onkeyup'=>'core.payments.applyMoneyToInvoices(this.value,\''.$cur_group.'\',this);'))?>
		
			<?
			# if this is NOT from local orbit, we need to let the user select 
			# which account the money is coming from
			
			if($invoice['from_org_id'] != 1)
			{
				$methods = core::model('organization_payment_methods')
						->collection()
						->add_formatter('organization_payment_methods__formatter_dropdown')
						->filter('org_id',$invoice['from_org_id']);
						
				echo(core_form::input_select('Account','payment_group_'.$cur_group.'__opm_id',null,$methods,array(
					'select_style'=>'width: 320px;',
					'text_column'=>'dropdown_text',
					'value_column'=>'opm_id',
				)));
			?>
			
			<?}?>
			<?=core_form::input_textarea('Memo:','payment_admin_note__'.$cur_group)?>

		<?=core_form::input_hidden('payment_method_'.$cur_group,3)?>
	
		<table class="dt span12">
			<?=core_form::column_widths('22%','32%','14%','14%','15%')?>
			<tr class="dt">
				<th class="dt">Description</th>
				<th class="dt">Payment Info</th>
				<th class="dt dt_sortable dt_sort_asc">Date</th>
				<th class="dt">Amount</th>
				<th class="dt">Applied Amount</th>
			</tr>
		<?
		
	}
	$group_total += $invoice['amount_due'];
?>

			<tr class="dt">
				<td class="dt">
					<b>I-<?=$invoice['invoice_id']?></b><br /><?=$invoice['description_html']?>
				</td>
				<td class="dt"><?=$invoice['direction_info']?></td>
				<td class="dt"><?=core_format::date($invoice['due_date'],'short')?></td></td>
				<td class="dt"><?=core_format::price($invoice['amount_due'])?></td>
				<td class="dt">
					<input type="hidden" name="payment_pay_group_<?=$cur_group?>__<?=$inv_counter?>" value="payment_pay_<?=$invoice['invoice_id']?>" />
					<input type="hidden" name="payment_pay_group_due_<?=$cur_group?>__<?=$inv_counter?>" value="<?=$invoice['amount_due']?>" />
					<input type="text" name="payment_pay_group_id_<?=$invoice['invoice_id']?>" style="width: 120px;" />
				</td>
			</tr>
<?php
	$inv_counter++;
}



if($cur_group != '')
{
	core::js('core.payments.invoiceGroups[\''.$cur_group.'\']='.$group_total.';');
	echo('</table>');
}
?>

<div class="pull-right">
	<input type="button" onclick="$('#payments_pay_area,#all_all_payments').toggle();" class="btn btn-warning" value="cancel" />
		
	<input type="button" class="btn btn-info" value="<?=$button_label?>" onclick="core.payments.saveInvoicePayments('payment');" />
</div>
<?
core::log('building payments UI complete. ready to send back to client');
core::replace('payments_pay_area');
core::js("document.paymentsForm.invoice_list.value='".$core->data['checked_invoices']."';");

core::js("core.payments.initInvoiceGroups('payment');");
?>