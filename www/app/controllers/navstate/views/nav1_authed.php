<ul class="nav pull-right">
	<li class="divider-vertical"></li>
	<li><a href="<?=$core->config['app_page']?>#!dashboard-home" onclick="core.go(this.href);" class="main"><?=$core->i18n['nav1:dashboard']?></a></li>
	<li class="divider-vertical"></li>
	<li><a href="https://localorbit.zendesk.com/forums">Help</a></li>
	<li class="divider-vertical"></li>
	<li><a href="#">Your Cart</a></li>
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