<?
echo core_ui::date_picker_blur_setup();
function misc_lots_formatting($data)
{
	#echo('formatted: '.($data['expires_on'].'/' == '/').'<br />');
	if($data['good_from'].'/' == '/')
		$data['good_from'] = 'NA';
	if($data['expires_on'].'/' == '/')
		$data['expires_on'] = 'NA';
	#echo('/'.$data['good_from'].'/');
	return $data;
}

$lots = core::model('product_inventory')->add_formatter('misc_lots_formatting')->collection()->filter('prod_id',$core->data['prod_id']);

#$lots->add_formatter('misc_lots_formatting');
$lots->rewind();
$lots->next();
$lot = $lots->current();
$style = '';

# only show the simple view if there is only one lot, AND that lot only has
# one field set (the qty)
if($lots->__num_rows == 1 && $lot['good_from'] == 0 && $lot['expires_on'] == 0 && $lot['lot_id'] == '')
{

?>
<div id="inventory_basic">
	<?=core_form::input_text('Simple Inventory Quantity','qty',floatval($lot['qty']))?>

	<br />
	<a href="Javascript:product.switchToAdvancedInventory();">&raquo; Switch to advanced inventory mode.</a>
	<br /><?=$core->i18n['note:inventorymode']?>
	<input type="hidden" name="basic_inv_id" value="<?=$lot['inv_id']?>" />
</div>
<input type="hidden" name="inventory_mode" value="basic" />
<?
	$style = ' style="display:none;"';
	$lots->rewind();
}
else
{
	echo(core_form::input_hidden('inventory_mode','advanced'));
}
?>
<div id="inventory_advanced"<?=$style?>>
	<?
	$inv = new core_datatable('inventory','products/inventory_form?prod_id='.$core->data['prod_id'],$lots);
	$inv->add(new core_datacolumn('lot_id','Lot #',true,'11%','<a href="Javascript:product.editLot(\'{inv_id}\',\'{lot_id}\',\'{good_from}\',\'{expires_on}\',\'{qty}\');">{lot_id}</a>'));
	$inv->add(new core_datacolumn('good_from','Good from',true,'30%','<a href="Javascript:product.editLot(\'{inv_id}\',\'{lot_id}\',\'{good_from}\',\'{expires_on}\',\'{qty}\');">{good_from}</a>'));
	$inv->add(new core_datacolumn('expires_on','Expires on',true,'30%','<a href="Javascript:product.editLot(\'{inv_id}\',\'{lot_id}\',\'{good_from}\',\'{expires_on}\',\'{qty}\');">{expires_on}</a>'));
	$inv->add(new core_datacolumn('qty','Qty',true,'25%','<a href="Javascript:product.editLot(\'{inv_id}\',\'{lot_id}\',\'{good_from}\',\'{expires_on}\',\'{qty}\');">{qty}</a>'));
	$inv->add(new core_datacolumn('lot_id',core_ui::check_all('inventory'),false,'4%',core_ui::check_all('inventory','inv_id')));

	$inv->size = (-1);
	$inv->display_filter_resizer = false;
	$inv->display_exporter_pager = false;
	$inv->render();
	?>
	<!--
	<br />
	<?=$core->i18n['note:inventoryadvanced']?>
	-->
	<div class="buttonset" id="addLotButton">
		<div style="float:left;">
			<?=core_ui::checkdiv('sell_oldest_first','Sell from oldest lot first',true)?>	
		</div>
		<div style="float:right;">
			<input type="button" class="btn" value="Add New Lot" onclick="product.editLot(0);" />
			<input type="button" class="btn btn-danger" value="Remove Checked" onclick="product.removeCheckedLots(this.form);" />
		</div>
	</div>
	<br />
	<fieldset id="editLot" style="display: none;">
		<legend>Lot Info</legend>
		<table class="form">
			<tr>
				<td class="label">Lot #</td>
				<td class="value"><input type="text" name="lot_id" value="" /></td>
			</tr>
			<tr>
				<td class="label">Good from</td>
				<td class="value"><?=core_ui::date_picker('good_from','')?></td>
			</tr>
			<tr>
				<td class="label">Expires On</td>
				<td class="value"><?=core_ui::date_picker('expires_on','')?></td>
			</tr>
			<tr>
				<td class="label">Qty</td>
				<td class="value"><input type="text" name="lot_qty" value="" /></td>
			</tr>
		</table>
		<input type="hidden" name="inv_id" value="" />
		<div class="buttonset">
			<input type="button" class="button_secondary" value="save this lot" onclick="product.saveLot();" />
			<input type="button" class="button_secondary" value="cancel" onclick="product.cancelLotChanges();" />
		</div>
	</fieldset>
</div>
