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

<div class="row" id="weekly_special"<?=(($core->session['weekly_special_noshow'] == 1)?' style="display:none;"':'')?>>

	<div class="span9">
		<h2 class="pull-left">The Featured Deal</h2>
		<small><a class="note pull-right" href="#!catalog-shop" style="line-height: 4.5em; vertical-align: bottom;" onclick="core.catalog.hideSpecial();" ><i class="icon-remove-sign"/>&nbsp;Hide this special...</a></small>
	</div>

	<div class="clear"></div>

	<div class="span2">
		<img class="img-rounded" src="<?=$webpath?>?_time_=<?=$core->config['time']?>" />
	</div>

	<div class="span3">
		<h3 style="margin: 0;"><a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$special['title']?></a></h3>
		<p style="margin-top: 0;">from <a href="#!sellers-oursellers--org_id-<?=$prod['org_id']?>"><?=$prod['org_name']?></a></p>
		<p class="note"><?=$special['body']?></p>
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

	<div class="span1">
		<!--<input class="prodTotal" readonly="readonly" type="text" name="prodTotal_<?=$prod['prod_id']?>" id="prodTotal_<?=$prod['prod_id']?>" size="3" style="width: 57px;" value="<?=$total?>" />-->
		<input class="span1 prodQty prodQty_<?=$prod['prod_id']?>" type="text" name="prodQty_<?=$prod['prod_id']?>" id="weeklySpecial_prodQty_<?=$prod['prod_id']?>" onkeyup="core.catalog.updateRow(<?=$prod['prod_id']?>,this.value);" value="<?=$qty?>" placeholder="Qty"/>
	</div>

	<div class="span1 prodTotal_text prodTotal_<?=$prod['prod_id']?>_text" id="weeklySpecial_prodTotal_<?=$prod['prod_id']?>_text">
		<!--<i class="icon-remove-sign"/>--><span class="value"><?=$total?></span>
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