<?

?>

<div id="weekly_special">
	<h4><i class="icon-star"></i>Current Featured Deal</h4>
	
	<img class="img-rounded" src="/img/weeklyspec/1.jpg?_time_=1357326096" width="95%">
	
	<div class="product-info">
		<small><a class="" href="#!sellers-oursellers--org_id-<?=$prod['org_id']?>">Boettcher Farm</a></small><br>
		<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>">Supersweet Sungolds</a><br>

		<small class="whowhatwhere">
			<a href="" onclick="return false;" rel="clickover" data-placement="right" data-title="" data-content="The sweetest cherry tomato you'll ever taste. We promise! And what's more, they're loaded with vitamin C."><i class="icon icon-info-sign" /> What</a>&nbsp;
			<? if ($seller['product_how'] !== ''): ?><a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$seller['product_how']?>"><i class="icon icon-heart-empty" /> How</a>&nbsp;<? endif; ?>
			<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="<?=$prod['city']?>, <?=$prod['code']?>" data-content="<?= htmlspecialchars('<img src="//maps.googleapis.com/maps/api/staticmap?center=' . $prod['latitude'] . ',' . $prod['longitude'] . '&zoom=7&size=210x125&sensor=false&markers=size:small%7Ccolor:white%7C' . $prod['latitude'] . ',' . $prod['longitude'] . '" />'); ?>"><i class="icon icon-screenshot" /> Where</a>
		</small>
	</div>
	
	<p class="note">Without a doubt, the sweetest tomato you'll ever taste. They're ripening by the bushel this month and Boettcher Farm has a great deal. Eat 'em like candy or toss into pasta. Buy extra and put them in ziplocs to freeze for the winter. Enter TOMSUN2012 at checkout for 20% off Boettcher's Sungold Tomatoes.</p>
	
</div>

<? core::replace('left'); ?>