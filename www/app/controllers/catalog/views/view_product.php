<?php

core::ensure_navstate(array('left'=>'left_filters'));
core_ui::showLeftNav();
core::head('View a product','View a product.');
lo3::require_permission();

$data = core::model('products')->join_address()->load();
$all_products = $data->get_catalog()->to_hash('prod_id');

if (count($all_products[$data['prod_id']]) <= 0) {
?>
<div class="error">This product is not currently available for ordering.</div>
<?
} else {
$inv = $data->get_inventory();
$prices = core::model('product_prices')->load_for_product($data['prod_id'],$core->config['domain']['domain_id'],intval($core->session['org_id']));
$img = $data->get_image();
$org = core::model('organizations')->load($data['org_id']);

$cart_item = array('qty_ordered'=>0);
$cart = core::model('lo_order')->get_cart();
$cart->load_items();
foreach($cart->items as $item)
{
	core::log("chekcing item: ".$item['prod_id']);
	if($item['prod_id'] == $data['prod_id'])
		$cart_item = $item->to_array();
		
}

?>
<div class="row">
	<div class="span6">
		
		<h2 class="product_name notcaps" style="margin-bottom: 0;"><?=$data['name']?></h2>
		<h3 class="farm_name notcaps" style="margin-top: 0;">from <?=$data['org_name']?>, [FIX:ORG Location]</h3>
		
		<hr>
		
		<form name="prodForm" class="form-inline">
		<div class="row">
			<div class="span2">
				<script>
				
				$(document).ready(function () {
				    $("[rel=tooltip]").tooltip();
				});
				
				</script>
				<? foreach($prices as $price): ?>
					<a href="#" id="yourprice" rel="tooltip" data-original-title="YOUR PRICE" data-placement="right"><?= core_format::price($price['price'])?><? if($data['single_unit'] != ''): ?><small> / <?= $data['single_unit']?></small><? endif; ?>
					<? if($price['min_qty'] > 1): ?>, Min. <?=intval($price['min_qty'])?><? endif; ?></a>
				<? endforeach; ?>
			</div>
			<div class="span2">
				[FIX:DeliveryDate]
			</div>
			<div class="span2">
				<? if( $inv > 0): ?>
					<input type="text" name="qty" id="qty" class="input-small" value="<?=$cart_item['qty_ordered']?>" />
					<div class="error" id="not_enough_inv" style="display: none;"></div>
					
					<button type="submit" class="btn" onclick="$('#not_enough_inv').hide();core.doRequest('/cart/update_item',{'prod_id':<?=$data['prod_id']?>,'qty':document.prodForm.qty.value});">Add to Cart</button>
					
				<? else: ?>
					<div class="error">This product is not currently available for ordering.</div>
				<? endif; ?>
			</div>
		</div>
		</form>
		
		<hr>
		
		<p class="note">[FIX: Add category breadcrumbs]</p>
		
		<p><strong>Size:</strong> [FIX: Add size string here]</p>
		
		<!--<p><strong>Who:</strong> <?=(($data['who']=='')?$org['profile']:$data['who'])?></p>-->
		<p><strong>What:</strong> <?=$data['description']?></p>
		<p><strong>How:</strong> <?=(($data['how']=='')?$org['product_how']:$data['how'])?></p>
			
		<h3>Produced by <?=$data['org_name']?></h3>
		<p>[FIX:Production Address] <a href="#" class="pull-right">See full seller profile...</a></p>
		<?
		$addr = $data['address'].', '.$data['city'].', '.$data['code'].', '.$data['postal_code'];
		echo(core_ui::map('prodmap','100%','400px',8));
		core_ui::map_center('prodmap',$addr);
		core_ui::map_add_point('prodmap',$addr,'<h1>'.$data['org_name'].'</h1>'.$addr);
		}
		?>
		
		
	</div>

	<div class="span3">
		<?if($img){?>
			<img class="homepage" src="/img/products/cache/<?=$img['pimg_id']?>.<?=$img['width']?>.<?=$img['height']?>.300.300.<?=$img['extension']?>" />
		<?}else{?>
			<img src="<?=image('product_placeholder')?>" />
		<?}?>
		
		<h4>Other Products from this Seller</h4>
		[FIX: Add other products]
		
		<h4>Other Products from this Category</h4>
		[FIX: Add other products]
	</div>
</div>