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
	<li><a href="#!catalog-checkout"><i class="icon-shopping-cart icon-white" style="position: relative; top: 2px;"></i> Your Cart</a></li>
	<li class="divider-vertical"></li>
	<li><a href="https://localorbit.zendesk.com/forums">Help</a></li>
	<li class="divider-vertical"></li>
	<li><a href="<?=$core->config['app_page']?>#!auth-logout" onclick="core.go(this.href);"><?=$core->i18n['nav1:logout']?></a></li>
</ul>
<p class="navbar-text pull-right">
	<?=$core->i18n['greeting']?> <a href="<?=$core->config['app_page']?>#!dashboard-home" onclick="core.go(this.href);" class="navbar-link"><?=$core->session['first_name']?></a>
</p>
<? core::replace('nav1top');?>
<li><a href="<?=$core->config['app_page']?>#!catalog-shop" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:shop']?></a></li>
<li><a href="#">News</a></li>
<li><a href="<?=$core->config['app_page']?>#!market-info" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:marketinfo']?></a></li>
<? core::replace('mainnav');?>