<?
$cart = $core->view[0];
?>
<div class="row">
	<span class="span3">
		<img src="<?=image('loading-progress')?>" id="totals_loading" />
	</span>
</div>
<div id="total_table" class="row" style="display: none">
			<span class="span2">Item Subtotal</span>
			<span class="span1"><span id="item_total"><?=core_format::price($cart['item_total'])?></span></span>
			<span class="span2">Discounts</span>
			<span class="span1"><span id="adjusted_total"><?=core_format::price($cart['adjusted_total'])?></span></span>
			<span class="span2">Delivery</span>
			<span class="span1"><span id="fee_total"></span></span>
			<span class="span2"><h4>Total</h4></span>
			<span class="span1"><h4 id="grand_total"><?=core_format::price($cart['grand_total'])?></h4></span>
</div>