<?
# the parameters for views called as functions are stored in $core->view.
global $core,$prods,$prices,$delivs;
$prod    = $core->view[0];
$cats    = $core->view[1];
$seller  = $core->view[2];
$pricing = $core->view[3];
$delivs  = $core->view[4];
$style1  = $core->view[5];
$style2  = $core->view[6];
$qty     = $core->view[7];
$total   = $core->view[8];
$days 	 = $core->view[9];


# format the total a bit
if(floatval($total) > 0)
{
	$total = core_format::price($total);
}
else
{
	$total = '';
}

# modify the prod data slightly to make rendering easier
$prod['category_ids'] = explode(',',$prod['category_ids']);
$dd_ids = explode(',',$prod['dd_ids']);
$dds = array();
foreach($dd_ids as $dd_id)
{
	$dds[] = $delivs[$dd_id][0];
}
$rendered_prices = 0;
?>
<div class="row">

	<div id="product_<?=$prod['prod_id']?>" class="product-row">

		<div class="span1 product-image">
			<? if(intval($prod['pimg_id']) > 0){?>
			<img class="img-rounded catalog" src="/img/products/cache/<?=$prod['pimg_id']?>.<?=$prod['width']?>.<?=$prod['height']?>.100.75.<?=$prod['extension']?>" />
			<?}else{?>
			<img class="img-rounded catalog_placeholder" src="<?=image('product_placeholder_small')?>" />
			<?}?>
		</div>

		<div class="span4 product-info">
			<small><a class="" href="#!sellers-oursellers--org_id-<?=$prod['org_id']?>"><?=$prod['org_name']?></a></small><br>
			<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$prod['name']?></a><br>

			<small class="whowhatwhere">
				<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$prod['description']?>"><i class="icon icon-info-sign" /> What</a>&nbsp;
				<? if ($seller['product_how'] !== ''): ?><a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$seller['product_how']?>"><i class="icon icon-heart-empty" /> How</a>&nbsp;<? endif; ?>
				<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="<?=$prod['city']?>, <?=$prod['code']?>" data-content="<?= htmlspecialchars('<img src="//maps.googleapis.com/maps/api/staticmap?center=' . $prod['latitude'] . ',' . $prod['longitude'] . '&zoom=7&size=210x125&sensor=false&markers=size:small%7Ccolor:white%7C' . $prod['latitude'] . ',' . $prod['longitude'] . '" />'); ?>"><i class="icon icon-screenshot" /> Where</a>
			</small>

			<?/*<p style="margin-bottom: 0;"><a class="accordion-toggle note" data-toggle="collapse" href="#moreInfo<?=$prod['prod_id']?>"><small>More Information...</small></a></p>*/?>
		</div>

		<ol class="span2 priceList">
			<? for ($i=0; $i < count($pricing); $i++) { ?>
				<li>

					<?if($pricing[$i]['org_id'] != 0){ ?>
						<div class="error">Your price:
					<?}?>

					<?=$pricing[$i]['price']?><small><? if($prod['single_unit'] != '') { ?>/<?=$prod['single_unit']?><? } ?><? if($pricing[$i]['min_qty'] >1){ ?>, min <?=floatval($pricing[$i]['min_qty'])?><?}?></small>

					<?if($pricing[$i]['org_id'] != 0){ ?>
						</div>
					<?}?>

				</li>
				<?$rendered_prices++;
			} ?>
		</ol>

		<div class="span2">
			<div class="row">
				<div class="span1 product-quantity">
					<input class="span1 prodQty prodQty_<?=$prod['prod_id']?>" type="text" name="prodQty_<?=$prod['prod_id']?>" id="prodQty_<?=$prod['prod_id']?>" onkeyup="core.catalog.updateRow(<?=$prod['prod_id']?>,this.value);" value="<?=$qty?>" placeholder="Qty"/>
				</div>

				<div class="span1 prodTotal_text prodTotal_<?=$prod['prod_id']?>_text" id="prodTotal_<?=$prod['prod_id']?>_text">
					<span class="value"><?=$total?></span> <i class="remove icon-remove-sign"/>
				</div>
			</div>
			<div class="row">
				<div class="span2">
					<div class="dropdown">
					<input class="prodDdSet" type="hidden" name="prodDdSet_<?=$prod['prod_id']?>" id="prodDdSet_<?=$prod['prod_id']?>" value="<?=implode('_', $dd_ids)?>"/>
					<?
					if (count($days) > 1)
					{
						$first = true;
						foreach($days as $key => $day)
						{
							if (count(array_intersect($dd_ids, array_keys($day))) > 0) {
								$dd_ids_id = implode('_', array_keys($day));
								list($type, $time) = explode('-', $key);
								if ($first) {
									$first = false;
									?>
								<a class="dropdown-toggle dd_selector" data-toggle="dropdown"><i class="icon icon-truck" /> <?=$type?> <?=core_format::date($time, 'shortest-weekday')?></a>
		  						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
								<input class="prodDd" type="hidden" name="prodDd_<?=$prod['prod_id']?>" id="prodDd_<?=$prod['prod_id']?>" value="<?=$dd_ids_id?>"/>
		  						<?
								}
								?>
								<li class="filter dd" id="filter_dd_<?=$dd_ids_id?>"><a href="<?=($hashUrl?'#!catalog-shop#dd='.$dd_ids_id:'#')?>" onclick="core.catalog.setFilter('dd','<?=$dd_ids_id?>');">
								<?=$type?> <?=core_format::date($time, 'shorter-weekday')?></a>
								</li>
								<?
							}
						}
					}
					else
					{
						list($key, $day) = each($days);
						list($type, $time) = explode('-', $key);
						$dd_ids_id = implode('_', array_keys($day));
						?>
								<input class="prodDd" type="hidden" name="prodDd_<?=$prod['prod_id']?>" id="prodDd_<?=$prod['prod_id']?>" value="<?=$dd_ids_id?>"/>
								<i class="icon icon-truck" /> <?=$type?> <?=core_format::date($time, 'shortest-weekday')?>
						<?
					}
					?>
				</ul>
					</div>
				</div>
			</div>
		</div>

		<hr class="span9" />
	</div> <!-- /.product-row-->

</div> <!-- /.row-->

<? /*
<tr id="product_<?=$prod['prod_id']?>" class="catalog catalog_<?=$style1?>_<?=$style2?> category_<?=$prod['category_ids'][2]?> category_<?=$prod['category_ids'][3]?>">
	<td class="catalog">
		<? if(intval($prod['pimg_id']) > 0){?>
		<img class="catalog" src="/img/products/cache/<?=$prod['pimg_id']?>.<?=$prod['width']?>.<?=$prod['height']?>.100.75.<?=$prod['extension']?>" />
		<?}else{?>
		<img class="catalog_placeholder" src="<?=image('product_placeholder_small')?>" />
		<?}?>
	</td>
	<td class="catalog">
		<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>">
			<span style="font-size: 120%;">
				<?=$prod['name']?>
				<? if($prod['single_unit'] != ''){?>
				(<?=$prod['single_unit']?>)
				<?}?>
			</span>
			<br />from <?=$prod['org_name']?></a>
		<br />
		<a href="#!catalog-shop" onmouseover="core.catalog.popupWho(<?=$prod['prod_id']?>,this);"><img onmouseover="core.lo3.rollOver(this)" onmouseout="core.lo3.rollOut(this)" src="<?=image('store/who_off')?>" /></a>
		<a href="#!catalog-shop" onmouseover="core.catalog.popupWhere(<?=$prod['prod_id']?>,this);"><img onmouseover="core.lo3.rollOver(this)" onmouseout="core.lo3.rollOut(this)" src="<?=image('store/where_off')?>" /></a>
		<a href="#!catalog-shop" onmouseover="core.catalog.popupWhat(<?=$prod['prod_id']?>,this);"><img onmouseover="core.lo3.rollOver(this)" onmouseout="core.lo3.rollOut(this)" src="<?=image('store/what_off')?>" /></a>
	</td>
	<td class="catalog">
		<table class="form">
			<?for ($i=0; $i < count($pricing); $i++){?>
			<tr>
				<td class="label" style="width: 10px;">
					<?=(($i == $rendered_prices)?'&nbsp;':'&nbsp;')?>
				</td>
				<td class="value" style="width: 200px;">

				<?if($pricing[$i]['org_id'] != 0){ ?>
					<div class="error">Your price:
				<?}?>

				<?=$pricing[$i]['price']?><? if($prod['single_unit'] != ''){?>/<?=$prod['single_unit']?><?}?><? if($pricing[$i]['min_qty'] >1){ ?>,
				min <?=floatval($pricing[$i]['min_qty'])?>
				<?}?>

				<?if($pricing[$i]['org_id'] != 0){ ?>
					</div>
				<?}?>

				</td>
			</tr>
			<?$rendered_prices++; }?>
		</table>
		<div class="catalog_error" id="qtyBelowMin_<?=$prod['prod_id']?>"><br /></div>
		<div class="catalog_error" id="qtyBelowInv_<?=$prod['prod_id']?>"><br /></div>
	</td>
	<td class="catalog">
		<table class="form">
			<tr>
				<td style="vertical-align: top;" class="catalog_tot"><input type="text" name="prodQty_<?=$prod['prod_id']?>" id="prodQty_<?=$prod['prod_id']?>" size="3" style="width: 57px;" onkeyup="core.catalog.updateRow(<?=$prod['prod_id']?>,this.value);" value="<?=$qty?>" /></td>
				<td style="vertical-align: top;" class="catalog_tot"><input type="text" name="prodTotal_<?=$prod['prod_id']?>" id="prodTotal_<?=$prod['prod_id']?>" size="3" style="width: 57px;" value="<?=$total?>" /></td>
				<td rowspan="2">
					<a id="zeroQty_<?=$prod['prod_id']?>" href="#!catalog-shop" onclick="$('#prodQty_<?=$prod['prod_id']?>').val(0);core.catalog.updateRow(<?=$prod['prod_id']?>,0);">
						<img onmouseover="core.lo3.rollOver(this)" onmouseout="core.lo3.rollOut(this)" src="<?=image('cart_remove_off')?>" />
					</a>
				</td>
			</tr>
			<tr>
				<td class="cat_total">Qty</td>
				<td class="cat_total">Subtotal</td>
			</tr>
		</table>
	</td>
</tr>
*/ ?>