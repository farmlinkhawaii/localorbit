<?php
$invoices = core::model('v_invoices')->collection()->filter('to_org_id' , $core->session['org_id']);
$invoices->add_formatter('payable_info');
$invoices_table = new core_datatable('invoices','payments/invoices',$invoices);
$invoices_table->add(new core_datacolumn('creation_date','Date',true,'19%','{creation_date}','{creation_date}','{creation_date}'));
$invoices_table->add(new core_datacolumn('from_domain_name','Hub',true,'19%','{from_domain_name}','{from_domain_name}','{from_domain_name}'));
$invoices_table->add(new core_datacolumn('from_org_name','Organization',true,'19%','{from_org_name}','{from_org_name}','{from_org_name}'));
$invoices_table->add(new core_datacolumn('description_html','Description',true,'19%',			'{description_html}','{description}','{description}'));
$invoices_table->add(new core_datacolumn('amount','Amount',true,'19%',							'{amount}','{amount}','{amount}'));
$invoices_table->add(new core_datacolumn('amount_due','Amount Due',true,'19%',			'{amount_due}','{amount_due}','{amount_due}'));
$invoices_table->columns[0]->autoformat='date-short';
$invoices_table->columns[4]->autoformat='price';
$invoices_table->columns[5]->autoformat='price';

$invoices_table->add_filter(new core_datatable_filter('from_domain_id'));
$invoices_table->filter_html .= core_datatable_filter::make_select(
	'invoices',
	'from_domain_id',
	$items->filter_states['invoices__filter__from_domain_id'],
	new core_collection('select distinct from_domain_id, from_domain_name from v_invoices where to_org_id = ' . $core->session['org_id']),
	'from_domain_id',
	'from_domain_name',
	'Show from all domain',
	'width: 270px;'
);

$org_sql = 'select distinct from_org_id, from_org_name from v_invoices where to_org_id = ' . $core->session['org_id'];

$domain_id = $invoices_table->filter_states['invoices__filter__from_domain_id'];
if(is_numeric($domain_id) && $domain_id > 0)
{
   $org_sql .= ' and from_domain_id='.$invoices_table->filter_states['invoices__filter__from_domain_id'];
}

$invoices_table->add_filter(new core_datatable_filter('from_org_id'));
$invoices_table->filter_html .= core_datatable_filter::make_select(
	'invoices',
	'from_org_id',
	$items->filter_states['invoices__filter__from_org_id'],
	new core_collection($org_sql),
	'from_org_id',
	'from_org_name',
	'Show from all buyers',
	'width: 270px;'
);

?>
<div class="tabarea" id="paymentstabs-a<?=$core->view[0]?>">
	<?
$invoices_table->render();
	?>
	<!--
	<table class="dt">
		<?=core_form::column_widths('12%','12%','12%','12%','12%','12%','12%','12%')?>
		<tr>
			<td colspan="8" class="dt_filter_resizer">
				<div class="dt_filter">
					<select>
						<option> Filter by Hub: All Hubs</option>
					</select>
					<select class="dt">
						<option>Org: All</option>
					</select>
					<select class="dt">
						<option>Status: Unpaid</option>
					</select>
				</div>
				<div class="dt_resizer">
					<select class="dt">
						<option>Show 10 rows</option>
					</select>
				</div>
			</td>
		</tr>
		<tr class="dt">
			<th class="dt dt_sortable dt_sort_asc">Invoice #</th>
			<th class="dt">Invoice Date</th>
			<th class="dt">Due Date</th>
			<th class="dt">Last Sent Date</th>
			<th class="dt">Hub</th>
			<th class="dt">Organization</th>
			<th class="dt">Amount</th>
			<th class="dt">Amount Due</th>
		</tr>
		<tr class="dt">
			<td class="dt">INV-230823</td>
			<td class="dt">May 1, 2012</td>
			<td class="dt">May 5, 2012</td>
			<td class="dt">May 2, 2012</td>
			<td class="dt">Detroit Western Market</td>
			<td class="dt">Buyer A</td>
			<td class="dt">$300.00</td>
			<td class="dt">$200.00</td>
		</tr>
		<tr class="dt1">
			<td class="dt">INV-230823</td>
			<td class="dt">May 6, 2012</td>
			<td class="dt">May 15, 2012</td>
			<td class="dt">May 8, 2012</td>
			<td class="dt">Detroit Western Market</td>
			<td class="dt">Buyer A</td>
			<td class="dt">$220.00</td>
			<td class="dt">$220.00</td>
		</tr>
		<tr>
			<td colspan="8" class="dt_exporter_pager">
				<div class="dt_exporter">
					Save as: Quickbooks | CSV | PDF
				</div>
				<div class="dt_pager">
					<select class="dt">
						<option>Page 1 of 1</option>
					</select>
				</div>
			</td>
		</tr>
	</table>
-->
	<div class="buttonset" id="create_payment_form_toggler">
		<input type="button" onclick="$('#create_payment_form_here,#create_payment_form_toggler').toggle();" class="button_primary" value="Record Payments" />
	</div>
	<br />&nbsp;<br />
	<? $this->invoices__record_payment()?>

</div>