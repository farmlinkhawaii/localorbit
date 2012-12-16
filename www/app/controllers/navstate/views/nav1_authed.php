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
	<li><a href="#!catalog-checkout"><i class="icon-shopping-cart icon-white"></i> Your Cart</a></li>
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