<?
global $core;
$prods    = $core->view[0];
$allPrices    = $core->view[1];

$special = core::model('weekly_specials')
	->collection()
	->filter('weekly_specials.domain_id',$core->config['domain']['domain_id'])
	->filter('is_active',1)
	->load()
	->row();

$prod = null;
foreach ($prods as $value) {
	if ($value['prod_id'] == $special['product_id']) {
		$prod = $value;
		break;
	}
}

$pricing = $allPrices[$special['product_id']];
$rendered_prices = 0;
if($special && $special['product_id'] != 0)
{
	list($has_image,$webpath) = $special->get_image();
?>

<div class="row" style="font-size: 12px !important;" id="weekly_special"<?=(($core->session['weekly_special_noshow'] == 1)?' style="display:none;"':'')?>>
	

	<div class="span9 first">
		<h3 class="pull-left"><i class="icon icon-tags" /> Featured: <a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$special['title']?></a></h3>
		<!--<small class="hideit"><a class="note pull-right" href="#!catalog-shop" style="line-height: 4.5em; vertical-align: bottom;" onclick="core.catalog.hideSpecial();" ><i class="icon icon-remove-sign"/>&nbsp;Hide this special...</a></small>-->
		<a class="ws_togglers pull-right" style="margin-top: 10px;margin-right: 14px;" onclick="$('.ws_togglers').toggle();$('#weekly_special').css('height','40px').css('overflow','hidden')"><i class="icon icon-minus" /></a>
		<a class="ws_togglers pull-right" style="margin-top: 10px;display: none;margin-right: 14px;" onclick="$('.ws_togglers').toggle();$('#weekly_special').css('height','auto').css('overflow','')"><i class="icon icon-plus" /></a>
	</div>
	<p class="note" style="padding-bottom: 10px;">
		<?=$special['body']?>
	</p>
	<div class="clear"></div>
	<div class="span1 first">
		<img class="img-rounded" src="<?=$webpath?>?_time_=<?=$core->config['time']?>" />
	</div>
	<div class="span4 product-info">
		<!--<small><a class="" href="#!sellers-oursellers--org_id-<?=$prod['org_id']?>"><?=$prod['org_name']?></a></small><br>-->
		<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$special['title']?></a><br />
		<?=$prod['short_description']?><br />
		<small class="whowhatwhere">
			<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$prod['description']?>"><i class="icon icon-info-sign" /> <?=$prod['org_name']?></a>&nbsp;
			<? if ($seller['product_how'] !== ''): ?><a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$seller['product_how']?>"><i class="icon icon-heart-empty" /> How</a>&nbsp;<? endif; ?>
			<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="<?=$prod['city']?>, <?=$prod['code']?>" data-content="<?= htmlspecialchars('<img src="//maps.googleapis.com/maps/api/staticmap?center=' . $prod['latitude'] . ',' . $prod['longitude'] . '&zoom=7&size=210x125&sensor=false&markers=size:small%7Ccolor:white%7C' . $prod['latitude'] . ',' . $prod['longitude'] . '" />'); ?>"><i class="icon icon-screenshot" /> Where</a>
		</small>
	</div>
	<ol class="span2 priceList">
		<?for ($i=0; $i < count($pricing); $i++){?>
			<li>
				<?if($pricing[$i]['org_id'] != 0){ ?>
					<div class="error">Your price:
				<?}?>

				<?=$pricing[$i]['price']?><small><? if($prod['single_unit'] != ''){?>/<?=$prod['single_unit']?><?}?><? if($pricing[$i]['min_qty'] >1){ ?>,
				min <?=floatval($pricing[$i]['min_qty'])?>
				<?}?></small>

				<?if($pricing[$i]['org_id'] != 0){ ?>
					</div>
				<?}?>
			</li>
		<?$rendered_prices++; }?>
	</ol>
	<div class="span2 cartstuff">
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
				?>
			</ul>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="span9 first">
	
	</div>

</div>

	<!--
	<table>
		<tr>
			<td class="weeklyspecial_popup_top">&nbsp;</td>
		</tr>
		<tr>
			<td class="weeklyspecial_popup_middle">
				<table style="width: 900px;margin: 0px 32px;">
					<col width="300" />
					<col width="20" />
					<col width="660" />
					<tr>
						<td style="vertical-align: top;">
							<img src="<?=$webpath?>?_time_=<?=$core->config['time']?>" />
						</td>
						<td>&nbsp;&nbsp;</td>
						<td style="vertical-align: top;">
							<table>
								<col width="1%" />
								<col width="1%" />
								<col width="98%" />
								<col width="1%" />
								<col width="1%" />
								<tr>
									<td>
										<img src="<?=image('weekly_special_large')?>?_time_=<?=$core->config['time']?>" />
									</td>
									<td>&nbsp;</td>
									<td style="vertical-align: top;">
										<div class="weekly_header">the featured deal:</div>
										<div class="weekly_title"><?=$special['title']?></div>

									</td>
									<td>&nbsp;</td>
									<td style="vertical-align: top;">
										<a href="#!catalog-shop" onclick="$('#weekly_special').fadeOut('fast');"><img src="<?=image('deal_close')?>" /></a>
									</td>
								</tr>
								<tr>
									<td colspan="5" style="height: 140px;">
										<?=$special['body']?>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<div class="buttonset">
											<input type="button" class="button_primary" onclick="location.href='#!catalog-view_product--prod_id-<?=$special['product_id']?>';core.go('#!catalog-view_product--prod_id-<?=$special['product_id']?>');" value="add to cart" />
											<input type="button" class="button_secondary" onclick="$('#weekly_special').fadeOut('fast');" value="start shopping" />
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="weeklyspecial_popup_bottom">&nbsp;</td>
		</tr>
	</table>

<a id="weekly_special_icon" href="#!catalog-shop" onclick="$('#weekly_special').fadeIn('fast');"><img src="<?=image('weekly_special_small')?>" /></a>
-->
<?
	//$core->session['weekly_special_noshow'] = 1;
}
?>