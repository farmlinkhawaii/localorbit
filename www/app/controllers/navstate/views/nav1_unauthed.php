<ul class="nav pull-right">
	<li class="divider-vertical"></li>
	<li><a onclick="$('#overlay,#popup3,#popup_closer').fadeIn(150);">Contact</a></li>
	<li class="divider-vertical"></li>
	<li><a style="color: #555;" href="/login.php" onclick="core.go(this.href);"><?=$core->i18n['nav1:login']?></a></li>
</ul>
<? core::replace('nav1top');?>
&nbsp;
<? core::replace('nav1sub');?>