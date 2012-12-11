<?
# the parameters for views called as functions are stored in $core->view. 
global $core;
$cats = $core->view[0];
$sellers = $core->view[1];
?>

<!--
<a href="#!catalog-shop" onmouseover="$('#catalog_note').fadeIn(300);" onmouseout="$('#catalog_note').fadeOut(300);"><img src="/img/misc/ellipsis_bubble.png" /></a><br />
<div id="catalog_note"><div>To view a single category, click once, then click again to view all!</div></div>
-->

<small style="position: relative; bottom: -1.6em;" class="pull-right hoverpointer" onclick="core.catalog.resetFilters();"><button class="close pull-left">&times;&nbsp;</button> Reset Filter</small>
<h2>Catalog</h2>

<hr style="margin: 5px 0;">

<h3><!--<input type="checkbox" class="filtercheck" disabled="disabled" checked="checked" />--><input type="checkbox" class="filtercheck" disabled="disabled" checked="checked" /> Sellers</h3>

<ul class="nav nav-list">
<?php
foreach($sellers as $seller)
{
	if($seller[0]['name'] != '')
	{
	?>
	<li id="filter_org_<?=$seller[0]['org_id']?>"><a onclick="core.catalog.setFilter('seller',<?=$seller[0]['org_id']?>);"><?=$seller[0]['name']?></a>
	<input type="hidden" id="filtercheck_<?=$cat[0]['cat_id']?>" class="filtercheck" checked="checked" /></li>
	<?
	}
}
?>
</ul>

<hr style="margin: 5px 0;">

<h3>Categories</h3>
<ul class="nav nav-list">
<?
$style=1;
foreach($cats->roots as $root)
{
	$cat = $cats->by_id[$root]; 
?>
<li id="filter_cat_<?=$cat[0]['cat_id']?>">
	<a href="#" onclick="core.catalog.setFilter('cat1',<?=$cat[0]['cat_id']?>);">
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