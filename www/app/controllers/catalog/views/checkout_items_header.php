<?
global $core;
$lodeliv_id = $core->view[0];

# the header changes due to this setting
# because if this is OFF, Then the user must
# choose the delivery day that they want
if($core->config['domain']['feature_force_items_to_soonest_delivery'] == 1)
{
	# get the delivery information for this group
	#echo('the deliv we\'re trying to load is: '.$lodeliv_id.'<br />');
	$deliv = core::model('lo_order_deliveries')->load($lodeliv_id);
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
	# print a generic header than will be updated by JS
	# when the user picks a delivery day
	echo('<h1>'.$core->i18n['field:checkout_pickup'].'</h1>');
}
?>