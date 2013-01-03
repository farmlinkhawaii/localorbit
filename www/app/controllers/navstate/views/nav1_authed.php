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
	
	<? if(lo3::is_admin() || lo3::is_market() || lo3::is_seller()): ?>	
		<li>
			<a href="<?=$core->config['app_page']?>#!dashboard-home" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:dashboard']?></a>
		</li>
	<? else: ?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="">Your Account</a>
			<ul class="dropdown-menu">
				<?if($core->session['is_active'] == 1 && $core->session['org_is_active'] == 1){?>
				<li><a href="#!orders-purchase_history" onclick="core.go(this.href);">Purchase History</a></li>
					<? if(!lo3::is_seller()){?>
					<li><a href="#!products-request" onclick="core.go(this.href);">Suggest A New Product</a></li>
					<?}?>
				<?}?>
				<li><a href="#!users-edit--entity_id-<?=$core->session['user_id']?>-me-1" onclick="core.go(this.href);">Update Profile</a></li>
				<li><a href="#!organizations-edit--org_id-<?=$core->session['org_id']?>-me-1" onclick="core.go(this.href);">Update Organization</a></li>
				<?if(lo3::is_customer() && !lo3::is_seller()){?>
				<li><a href="#!reports-edit" onclick="core.go(this.href);">Reports</a></li>
				<?}?>
				<li><a href="#!users-change_password" onclick="core.go(this.href);">Change Your Password</a></li>					
				<li><a href="#!payments-demo" onclick="core.go(this.href);">Payments Portal</a></li>					
			</ul>
		</li>
	<? endif; ?>
	
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
		}
		?>
			<div class="row">
				<span class="span4">
					<a class="btn btn-block btn-warning" href="#!catalog-your_cart">
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