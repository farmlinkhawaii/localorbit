<script type="text/javascript" charset="utf-8">
$(function()
	{
		// Call stylesheet init so that all stylesheet changing functions
		// will work.
		$.stylesheetInit();

		// This code loops through the stylesheets when you click the link with
		// an ID of "toggler" below.
		$('#toggler').bind(
			'click',
			function(e)
			{
				$.stylesheetToggle();
				return false;
			}
		);

		// When one of the styleswitch links is clicked then switch the stylesheet to
		// the one matching the value of that links rel attribute.
		$('.styleswitch').bind(
			'click',
			function(e)
			{
				$.stylesheetSwitch(this.getAttribute('rel'));
				return false;
			}
		);
	}
);
</script>

<p class="navbar-text pull-left">
	<small>Style Switcher (Temporary):</small>
</p>
<ul class="nav pull-left">
	<li><a href="#" rel="styles1" class="styleswitch"><small>1</small></a></li>
	<li><a href="#" rel="styles2" class="styleswitch"><small>2</small></a></li>
	<li><a href="#" rel="styles3" class="styleswitch"><small>3</small></a></li>
</ul>
<ul class="nav pull-right">
	<li class="divider-vertical"></li>
	<li>
		<a href="<?=$core->config['app_page']?>#!dashboard-home" onclick="core.go(this.href);" class="main">
			<? if(lo3::is_admin() || lo3::is_market() || lo3::is_seller()): ?>
				<?=$core->i18n['nav1:dashboard']?>
			<? else: ?>
				Your Account
			<? endif; ?>
		</a>
	</li>
	<li class="divider-vertical"></li>
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-shopping-cart icon-white"></i> Your Cart</a>
		<div class="dropdown-menu span4 yourCart">
			<?
		$cart = core::model('lo_order')->get_cart();
		$cart->load_items();
		$item_hash = $cart->items->to_hash('prod_id');
		foreach ($item_hash as $prod_id => $item) {
			$prod = core::model('products')->load($item[0]['prod_id']);
			//print_r($prod->__data);
			?>
				<div class="row">
					<span class="span1 product-image">
						<? if(intval($prod['pimg_id']) > 0){?>
						<img class="img-polaroid catalog" src="/img/products/cache/<?=$prod['pimg_id']?>.<?=$prod['width']?>.<?=$prod['height']?>.100.75.<?=$prod['extension']?>" />
						<?}else{?>
						<img class="img-polaroid catalog_placeholder" src="<?=image('product_placeholder_small')?>" />
						<?}?>
					</span>
					<span class="span3">
						<div class="productName"><?=$item[0]['product_name']?></div>
						<div>Quantity: <?=$item[0]['qty_ordered']?> <?=(($item[0]['qty_ordered']>1)?$item[0]['unit_plural']:$item[0]['unit'])?></div>
					</span>
				</div>
			<?
/*
rray ( [1844] => Array ( [0] => Array (
lo_liid] => 6796 [lo_oid] => 3520 [lo_foid] => 0 [seller_mage_customer_id] => [seller_name] => DuRussel Farms [sku] => [product_name] => Baking Potatoes - #1 [qty_ordered] => 1
[qty_adjusted] => 0 [qty_delivered] => 0 [unit] => Bag [unit_price] => 9.6000 [row_total] => 9.6000 [unit_plural] => Bags
 [row_adjusted_total] => 9.6000 [adjusted_description] => [prod_id] => 1844 [addr_id] => [dd_id] => 34 [due_time] => 1356321600
 [deliv_time] => [seller_org_id] => 1067 [lodeliv_id] => 2186 [last_status_date] => 1355775456 [lbps_id] => 1 [ldstat_id] => 1
 [lsps_id] => 1 [category_ids] => 2,227,232,272,477 [final_cat_id] => 477 [producedat_address_id] => 1118 [producedat_org_id] => 1067
 [producedat_address] => 4800 Esch Rd [producedat_city] => Manchester [producedat_region_id] => 33 [producedat_postal_code] => 48158
 [producedat_telephone] => (734) 428-8900 [producedat_fax] => [producedat_delivery_instructions] => [producedat_longitude] => [producedat_latitude] =>
 [has_valid_inventory] => 1 [has_valid_delivs] => 1 [has_valid_prices] => 1 ) ) )
*/
		}
		?>
			<div class="row">
				<span class="span4">
					<a class="btn btn-block btn-warning" href="#!catalog-checkout">
						<span class="viewCart pull-left">View Cart</span>
						&nbsp;
						<span class="pull-right">Subtotal: <?=core_format::price($cart['grand_total'])?></span>
					</a>
				</span>
			</a>
		</div>
	</li>
	<li class="divider-vertical"></li>
	<li><a href="https://localorbit.zendesk.com/forums">Help</a></li>
	<li class="divider-vertical"></li>
	<li><a href="<?=$core->config['app_page']?>#!auth-logout" onclick="core.go(this.href);"><?=$core->i18n['nav1:logout']?></a></li>
</ul>
<p class="navbar-text pull-right">
	<?=$core->i18n['greeting']?> <?=$core->session['first_name']?>
</p>
<? core::replace('nav1top');?>
<li><a href="<?=$core->config['app_page']?>#!catalog-shop" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:shop']?></a></li>
<li><a href="#">News</a></li>
<li><a href="<?=$core->config['app_page']?>#!market-info" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:marketinfo']?></a></li>
<? core::replace('mainnav');?>