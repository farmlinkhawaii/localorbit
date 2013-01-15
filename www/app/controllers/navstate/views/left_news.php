<?

$special = core::model('weekly_specials')
	->collection()
	->filter('weekly_specials.domain_id',$core->config['domain']['domain_id'])
	->filter('is_active',1)
	->load()
	->row();
	


if($special && $special['product_id'] != 0)
{
	list($has_image,$webpath) = $special->get_image();
	$prod = core::model('products')->load($special['product_id']);
	$seller = core::model('products')->load($prod['org_id']);
	
	# handle the cart
	$cart = core::model('lo_order')->get_cart();
	$cart->load_items();

	# write out necessary javascript, including the complete product/pricing/delivery listing
	core_ui::load_library('js','catalog.js');
	#core::js('core.prices ='.json_encode($prices).';');
	core::js('core.delivs ='.json_encode($delivs).';');
	core::js('core.cart = '.$cart->write_js(true).';');
	#core::js('core.dds = '.json_encode($days) . ';');
	
	# figure out the actual qty in the cart of hte special
	#$qty   = $item_hash[$prod['prod_id']][0]['qty_ordered'];
	#$total = $item_hash[$prod['prod_id']][0]['row_total'];
	#$dd_id = $item_hash[$prod['prod_id']][0]['dd_id'];
	#$dd_ids = explode(',',$prod['dd_ids']);

	#$pricing = $allPrices[$special['product_id']];
	#$rendered_prices = 0;

	# reorganize the cart into a hash by prod_id, so we can look up quantities easier
	# while rendering the catalog
	

?>

<div id="weekly_special">
	<div class="row">
		<div class="span3">
			<h3 class="pull-left"><i class="icon-star"></i>Featured: <a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$special['title']?></a></h3>
			<!--<small class="hideit"><a class="note pull-right" href="#!catalog-shop" style="line-height: 4.5em; vertical-align: bottom;" onclick="core.catalog.hideSpecial();" ><i class="icon icon-remove-sign"/>&nbsp;Hide this special...</a></small>-->
			<a class="ws_togglers pull-right" style="margin-top: 10px;margin-right: 14px;" onclick="$('.ws_togglers').toggle();$('#weekly_special').css('height','40px').css('overflow','hidden')"><i class="icon icon-minus-circle" /></a>
			<a class="ws_togglers pull-right" style="margin-top: 10px;display: none;margin-right: 14px;" onclick="$('.ws_togglers').toggle();$('#weekly_special').css('height','auto').css('overflow','')"><i class="icon icon-plus-circle" /></a>
			
			<p class="span3 note" style="padding-bottom: 10px;">
				<?=$special['body']?>
			</p>
			
		</div>
	</div>
	<div class="row">
		<div class="span3">
			<?
			core::process_command('catalog/render_product_description',true,$prod,$seller);
			?>
		</div>
	</div>
	<div class="row">
		<div class="span3">
			<? $this->render_product_pricing($pricing); ?>	
		</div>
	</div>
	<div class="row">
		<div class="span3">
			<? $this->render_qty_delivery($prod,$days,$dd_id,$dd_ids,$qty,$total); ?>
		</div>
	</div>
	
</div>
<?}?>
<? core::replace('left'); ?>