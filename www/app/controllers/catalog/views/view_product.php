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

	$prods = core::model('products')->get_catalog()->load();
		$cat_ids   = $prods->get_unique_values('category_ids',true,true);
		$cats  = core::model('categories')->load_for_products($cat_ids);
		$org_ids   = $prods->get_unique_values('org_id');
		$sellers   = core::model('organizations')->collection()->sort('name');
		$sellers	  = $sellers->filter('organizations.org_id','in',$org_ids)->to_hash('org_id');
		core::ensure_navstate(array('left'=>'left_blank'));
core::write_navstate();
		$this->left_filters($cats,$sellers,undefined,true);


$cats  = core::model('categories')->load_for_products(explode(',',$data['category_ids']));//->load()->collection();
?>
<div class="row">
	<div class="span6">
		
		<h2 class="product_name notcaps" style="margin-bottom: 0;"><?=$data['name']?></h2>
		<h3 class="farm_name notcaps" style="margin-top: 0;">from <?=$data['org_name']?>, <?=$data['city']?>, <?=$data['code']?></h3>
		
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
		
		<p class="note">
		<?
			ksort($cats->by_id);
			$categories = array_values($cats->by_id);
			$first = true;
			$second = true;
			foreach ($categories as $category) {
				if ($first) {
					$first = false;
					continue;
				}
				if ($second) {
					$second = false;
				} else {
					echo ':';
				}
				?>
				<u><?=$category[0]['cat_name']?></u>
				<?
			}
		?>
		</p>
		
		<p><strong>Size:</strong> [FIX: Add size string here]</p>
		
		<!--<p><strong>Who:</strong> <?=(($data['who']=='')?$org['profile']:$data['who'])?></p>-->
		<p><strong>What:</strong> <?=$data['description']?></p>
		<p><strong>How:</strong> <?=(($data['how']=='')?$org['product_how']:$data['how'])?></p>
			
		<h3>Produced by <?=$data['org_name']?></h3>
		<p><?=$data['address']?>, <?=$data['city']?>, <?=$data['code']?> <a href="#!sellers-oursellers--org_id-<?=$data['org_id']?>" class="pull-right">See full seller profile...</a></p>
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