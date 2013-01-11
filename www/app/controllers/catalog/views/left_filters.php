<?
# the parameters for views called as functions are stored in $core->view.
global $core;
$cats = $core->view[0];
$sellers = $core->view[1];
//$delivs = $core->view[2];
$days = $core->view[2];
$hashUrl = $core->view[3]?'true':'false';

if($core->data['cart'] == 'yes')
	core::js('$(\'#cartFilterCheck\').prop(\'checked\',true);core.catalog.setFilter(\'cartOnly\',true);');
?>

<!--
<a href="#!catalog-shop" onmouseover="$('#catalog_note').fadeIn(300);" onmouseout="$('#catalog_note').fadeOut(300);"><img src="/img/misc/ellipsis_bubble.png" /></a><br />
<div id="catalog_note"><div>To view a single category, click once, then click again to view all!</div></div>
-->

<small style="position: relative; bottom: -1.6em;" class="pull-right hoverpointer" onclick="core.catalog.resetFilters();"><i class="icon-remove-sign"/>Remove Filters</small>
<h2>Filter By:</h2>
<?

if (count($days) > 1)
{
?>
<hr class="tight">
<strong>
	 <span style="cursor: pointer;" onclick="core.catalog.setFilter('cartOnly',$('#cartFilterCheck').prop('checked'));$('#cartFilterCheck').prop('checked', !$('#cartFilterCheck').prop('checked'));">Your Cart</span>
	 <input onclick="core.catalog.setFilter('cartOnly',this.checked);" id="cartFilterCheck" class="pull-right" type="checkbox" name="in_cart_only" />
</strong>

<hr class="tight">
<strong><input type="checkbox" class="filtercheck" disabled="disabled" checked="checked" style="display: none;" />Availablity Date</strong>

<ul class="nav nav-list">
<?php
	foreach($days as $key => $day)
	{
		$name = core_format::date($time, 'shorter-weekday');
		$dd_ids = implode('_', array_keys($day));
		list($type, $time) = explode('-', $key);
		?>
		<li class="filter dd" id="filter_dd_<?=$dd_ids?>"><a href="#!catalog-shop#dd<?=$dd_ids?>" onclick="core.catalog.setFilter('dd','<?=$dd_ids?>'); return <?=$hashUrl?>;">
		<?=$type?> <?=core_format::date($time, 'shorter-weekday')?></a>
		<input type="hidden" id="filtercheck_<?=$dd_ids?>" class="filtercheck" checked="checked" /></li>
		<?
	}
}
?>
</ul>

<hr class="tight">
<strong><input type="checkbox" class="filtercheck" disabled="disabled" checked="checked" style="display: none;" />Seller</strong>

<ul class="nav nav-list">
<?php
foreach($sellers as $seller)
{
	if($seller[0]['name'] != '')
	{
	?>
	<li class="filter seller" id="filter_org_<?=$seller[0]['org_id']?>"><a href="#!catalog-shop#seller=<?=$seller[0]['org_id']?>" onclick="core.catalog.setFilter('seller',<?=$seller[0]['org_id']?>); return <?=$hashUrl?>;"><?=$seller[0]['name']?></a>
	<input type="hidden" id="filtercheck_<?=$cat[0]['cat_id']?>" class="filtercheck" checked="checked" /></li>
	<?
	}
}
?>
</ul>

<hr class="tight">

<strong>Category</strong>
<ul class="nav nav-list">
<?
$style=1;
foreach($cats->roots as $root)
{
	$cat = $cats->by_id[$root];
?>
<li class="filter category" data-name="<?=$cat[0]['cat_name']?>" id="filter_cat_<?=$cat[0]['cat_id']?>">
	<a href="#!catalog-shop#cat1=<?=$cat[0]['cat_id']?>" onclick="core.catalog.setFilter('cat1',<?=$cat[0]['cat_id']?>);  return <?=$hashUrl?>;">
		<!--<input type="hidden" id="filtercheck_<?=$cat[0]['cat_id']?>" class="filtercheck" checked="checked" />-->
		<?=$cat[0]['cat_name']?>
	</a>
	<input type="hidden" id="filtercheck_<?=$cat[0]['cat_id']?>" class="filtercheck" checked="checked" />
</li>


	<? /* Subcategory
	$subs = $cats->by_parent[$cat[0]['cat_id']];
	if(isset($cats->by_parent[$cat[0]['cat_id']]))
	{
		foreach($subs as $sub)
		{
		?>
		<div onclick="core.catalog.setFilter('cat2',<?=$sub['cat_id']?>,<?=$cat[0]['cat_id']?>);" id="filter_subcat_<?=$sub['cat_id']?>" class="subheader_<?=$style?> filter filter_subcat filter_subcat_of_<?=$cat[0]['cat_id']?>">
			<?=$sub['cat_name']?>
		</div>
		<?
		}
	}
	echo('<br />');
	*/
	$style=($style == 1)?2:1;
}
?>
</ul>
<? core::replace('left'); ?>