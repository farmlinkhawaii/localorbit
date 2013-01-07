<?
# basics
global $core;

core::head('Checkout','go mike');
lo3::require_permission();
core::clear_response('replace','left');
core::clear_response('replace','center');
core::replace('left','&nbsp;&nbsp;');
core_ui::load_library('js','checkout.js');
core_ui::fullWidth();
$this->paypal_rules()->js();
$this->authorize_rules()->js();
$this->purchaseorder_rules()->js();

$all_addrs = core::model('addresses')
	->collection()
	->add_formatter('address_formatter')
	->filter('org_id',$core->session['org_id'])
	->filter('is_deleted',0);

# load up the order and arrange it for rendering
$cart = core::model('lo_order')->get_cart();
$cart->load_items(true);
$cart->load_codes_fees();
$cart->discount_codes = $cart->discount_codes->to_array();
#print_r($cart->discount_codes);
if(count($cart->discount_codes) == 0)
{
	$cart->discount_codes = array(array('code'=>''));
}
# if there are no items in the cart, send the user back to the shopping page
if(count($cart->items->to_array()) == 0)
{
	core::js('location.href="#!catalog-shop";');
	core_ui::notification('You have no items in your cart');
	core::deinit();
}
else if ($cart['grand_total'] < $core->config['domain']['order_minimum'])
{
	core::js('location.href="#!catalog-shop";');
	core_ui::notification(str_replace('{1}', core_format::price($core->config['domain']['order_minimum']), $core->session['i18n']['error:customer:minimum_error']));
	core::deinit();
}
$cart->items_by_delivery = array();
$options = $this->determine_options($delivery_opt_key,$cart->delivery_options,$all_addrs);
core::replace('full_width');

# rearrange the items so that they're grouped by delivery options.
$cart->arrange_by_next_delivery();
?>

<form id="checkoutForm" name="checkoutForm" class="checkout" method="post" action="app/catalog/order_confirmation">
<div class="row">
	<div class="span6">
		<div class="row">
			<span class="span3">
				<h1>Your Order</h1>
			</span>
			<span class="span1">
				Quantity
			</span>
			<span class="span1">
				Unit Price
			</span>
			<span class="span1">
				Subtotal
			</span>
			<hr class="span6"/>
		</div>
	<?php
	foreach($cart->items_by_delivery as $delivery_opt_key=>$items){
		echo $delivery_opt_key;
	$this->checkout_items_header($items[0]['lodeliv_id'], $all_addrs);
	?>
		<div class="row">
			<hr class="span6"/>
		</div>
	<?
	$items_by_seller = array();
	foreach ($items as $item) {
		if (!array_key_exists($item['seller_name'], $items_by_seller)){
			$items_by_seller[$item['seller_name']] = array();
		}
		$items_by_seller[$item['seller_name']][] = $item;
	}
	foreach ($items_by_seller as $seller_name => $items) {
		?>
		<div class="row">
			<div class="span6"><?=$seller_name?></div>
		</div>
			<?
			foreach ($items as $item) {
			?>
		<div class="row">
			<div class="span3"><strong><?=$item['product_name']?></strong></div>
			<div class="span1"><?=$item['qty_ordered']?></div>
			<div class="span1"><?=core_format::price($item['unit_price'])?></div>
			<div class="span1"><?=core_format::price($item['row_total'])?></div>
		</div>
			<?
			}
			?>
		<div class="row">
			<hr class="span6"/>
		</div>
		<?
	}
}
	?>
		<div class="row">
			<div class="span3">
				<a class="btn" href="#!catalog-shop">Modify Your Cart</a>
			 </div>
			 <div class="span3">
			 	<?
	$this->checkout_totals($cart);
	?>
			 </div>
		</div>
	</div>
	<span class="span6">
		<div class="row">
			<div class="span6"><h1>Billing</h1></div>
			<div class="span3">Have a discount code? Enter it here.</div>
			<div class="span3 form-inline">
				<input class="input-small"  type="text" id="discount_code" name="discount_code" value="<?=$cart->discount_codes[0]['code']?>" />
				<input class="btn" type="button" value="Apply" onclick="core.checkout.requestUpdatedFees();" />
			</div>
			<hr class="span6"/>
			<?
				$this->checkout_payment_info();
			?>
		</div>
	</span>
</div>
<div class="row">
	<hr class="span12"/>
	<div class="span4">
		<input type="button" value="Confirm Order" class="btn" onclick="core.checkout.process();" />
	</div>
</div>
<?
/*
?>

<form name="checkoutForm" class="checkout" method="post" action="app/catalog/order_confirmation">
	<table>
		<col width="670" /><col width="3" /><col width="300" />
		<tr>
			<td>
				<?php
				foreach($cart->items_by_delivery as $delivery_opt_key=>$items){
				?>
				<table>
					<col width="400" /><col width="10" /><col width="260" />
					<tr>
						<td>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<h1>Location</h1>
						</td>
					</tr>
					<tr>
						<td>
							<?php $this->checkout_items($items); ?>
						</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td class="delivery_area">
							<?php
							?>
						</td>
					</tr>
				</table>
				<div class="dashed_divider">&nbsp;</div>
				<?}?>
				Enter your discount code here: <input type="text" id="discount_code" name="discount_code" value="<?=$cart->discount_codes[0]['code']?>" />
				<input type="button" class="button_secondary" value="apply code" onclick="core.checkout.requestUpdatedFees();" />
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td style="vertical-align: top;">
				<?php
				$this->checkout_totals($cart);
				$this->checkout_payment_info();
				?>
			</td>
		</tr>
	</table>
</form>
-->
<?
*/
# this is used to dynamically update the fees and such.
core::js('window.setTimeout("core.checkout.requestUpdatedFees();",1000);');
?>
</form>