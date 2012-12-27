<?php
# load up this orgnization's payment method settings
global $org,$core;
$org = core::model('organizations')->load($core->session['org_id']);

# figure out how many payment methods they have
$paymethods = 0;
$paymethods += intval($org['payment_allow_authorize']);
$paymethods += intval($org['payment_allow_paypal']);
$paymethods += intval($org['payment_allow_purchaseorder']);
$paymethods += intval($org['payment_allow_ach']);

# if they've got more than one, show a radio selector
if($paymethods > 1)
{
	$this->payment_selector();
}
else
{
	#otherwise, create a hidden option to store the payment method
	if(intval($org['payment_allow_authorize']) == 1)
		$method = 'authorize';
	if(intval($org['payment_allow_paypal']) == 1)
		$method = 'paypal';
	if(intval($org['payment_allow_purchaseorder']) == 1)
		$method = 'purchaseorder';
	echo('<input type="hidden" name="payment_method" value="'.$method.'" />');
}

# print all the payment forms. Each view function 
# will determine whether or not it needs to actually be rendered.
$this->payment_authorize($paymethods);
$this->payment_paypal($paymethods);
$this->payment_purchaseorder($paymethods);
$this->payment_ach($paymethods);
?>
<br />
<div id="placeorder_button" class="buttonset"<?=(($paymethods > 1)?' style="display:none;"':'')?>>
	<input type="button" onclick="location.href='#!catalog-shop';" value="back to cart" class="button_secondary button_back_to_cart" />
	<input type="button" value="place order" class="button_primary button_place_order" onclick="core.checkout.process();" />
</div>
<div id="loading_progress" style="display: none;">
	<img src="<?=image('loading-progress')?>" />
</div>
