<div class="row"><div class="span6"><h2>
<?
global $core;
$lodeliv_id = $core->view[0];
$all_addrs = $core->view[1];

$deliv = core::model('lo_order_deliveries')->load($lodeliv_id);
$addresses = array();

if(intval($deliv['deliv_address_id'])==0 || intval($deliv['pickup_address_id'])==0)
{
	foreach ($all_addrs as $addr) {
		$addresses[$addr['address_id']] = $addr['formatted_address'];
	}
}
else
{
	$addresses[$deliv['pickup_address_id']] =  $deliv['pickup_address'].', '.$deliv['pickup_city'].', '.$deliv['pickup_code'].', '.$deliv['pickup_postal_code'];
}
//print_r($options);
//echo $core->config['domain']['feature_force_items_to_soonest_delivery'];
# the header changes due to this setting
# because if this is OFF, Then the user must
# choose the delivery day that they want
if($core->config['domain']['feature_force_items_to_soonest_delivery'] == 1)
{
	# get the delivery information for this group
	#echo('the deliv we\'re trying to load is: '.$lodeliv_id.'<br />');
	#echo('<pre>');
	#print_r($deliv->__data);
	#echo('</pre>');
	//print_r($deliv);
	if ($deliv['pickup_address_id']) {
?>
	Pickup: <?=core_format::date($deliv['pickup_start_time'],'short-weekday')?> between <?=date('g:i a',$deliv['pickup_start_time'])?>-<?=date('g:i a',$deliv['pickup_end_time'])?>
<?
	} else {
?>
	Delivery: <?=core_format::date($deliv['delivery_start_time'],'short-weekday')?> between <?=date('g:i a',$deliv['delivery_start_time'])?>-<?=date('g:i a',$deliv['delivery_end_time'])?>
<?
	}

	//echo('<h1>'.$core->i18n['field:checkout_delivery'].core_format::date($deliv['pickup_start_time'],'short').'</h1>');
}
else
{
		if ($deliv['pickup_address_id']) {
?>
	Pickup: <?=core_format::date($deliv['pickup_start_time'],'short-weekday')?> between <?=date('g:i a',$deliv['pickup_start_time'])?>-<?=date('g:i a',$deliv['pickup_end_time'])?>
<?
	} else {
?>
	Delivery: <?=core_format::date($deliv['delivery_start_time'],'short-weekday')?> between <?=date('g:i a',$deliv['delivery_start_time'])?>-<?=date('g:i a',$deliv['delivery_end_time'])?>
<?
	}
	//print_r($deliv);
	# print a generic header than will be updated by JS
	# when the user picks a delivery day
	//echo($core->i18n['field:checkout_pickup']);
}
?>
</h2>
<?
if(count($addresses) > 1) {
	?>
<select name="delivgroup-<?=$deliv['dd_id_group']?>">
	<?
	foreach($addresses as $id=>$address)
{
	/*
	$label = $address.' on '.core_format::date($options[$i]['start_time'],'short');
	$label .= ' between '.core_format::date($options[$i]['start_time'],'time').' and '.core_format::date($options[$i]['end_time'],'time');
	if(floatval($options[$i]['amount']) > 0)
	{
		$label .= ', '.(($options[$i]['fee_calc_type_id']==1)?'':'$').''.floatval($options[$i]['amount']).''.(($options[$i]['fee_calc_type_id']==1)?'%':'').' delivery fee';
	}
*/
	//echo(($i==0)?'Please choose one...<br />':'<hr />');
/*
	echo(core_ui::radiodiv(
		'delivgroup-'.$options[$i]['uniqid'],
		$options[$i]['address'],
		($i==0),
		'delivgroup-'.$lodeliv_id,
		false,
		'core.checkout.requestUpdatedFees();'
	));
*/
	?>
	<option value="<?=$id?>"><?=$address?></option>
	<?
	#print_r($options[$i]);
}
?>
<!-- <select name="delivgroup-<?=$lodeliv_id?>"> -->
<?

?>
</select>
<?
}
else
{
	list($id, $address) = each($addresses);

?>
<input name="delivgroup-<?=$deliv['dd_id_group']?>" type="hidden" value="<?=$id?>"/>
<?=$address?>
<?
}
?>
</div></div>