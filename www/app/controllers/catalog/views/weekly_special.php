<?
global $core;
$prods    = $core->view[0];
$allPrices    = $core->view[1];
$all_sellers    = $core->view[2];

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
		$seller = $all_sellers[$prod['org_id']];
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
		<?
		$this->render_product_description($prod,$seller);
		?>
	</div>
	<ol class="span2 priceList">
		<? $this->render_product_pricing($pricing); ?>	
	
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
<?
	//$core->session['weekly_special_noshow'] = 1;
}
?>