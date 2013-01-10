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
$dd_id 	 = $core->view[10];


# remove this code
#$first_period = strpos($description,'.');
#$first_exclam = strpos($description,'!');
#$index = ($first_period < $first_exclam)?$first_period:$first_exclam;
#$description = substr($description,0,$index+1);

#$farm_name = substr($prod['org_name'],0,20);
#$farm_name .= (strlen($prod['org_name'])>=20)?'&hellip;':'';


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
foreach($dd_ids as $dd_id_key)
{
	$dds[] = $delivs[$dd_id_key][0];
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
			<? $this->render_product_description($prod,$seller); ?>	
		</div>

		<ol class="span2 priceList">
			<? $this->render_product_pricing($pricing); ?>	
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
						$selected_dd_key = null;

						$first = isset($dd_id) ? false : true;
						foreach($days as $key => $day)
						{
							if (count(array_intersect($dd_ids, array_keys($day))) > 0) {
								//$dd_ids_id = implode('_', array_keys($day));
								//list($type, $time) = explode('-', $key);
								if (!isset($dd_id) || array_key_exists($dd_id, $day)) {
									$selected_dd_key = $key;
									break;
								}
							}
						}
						$dd_ids_id = implode('_', array_keys($day));
						list($type, $time) = explode('-', $key);
						?>
						<a class="dropdown-toggle dd_selector" data-toggle="dropdown"><i class="icon icon-truck" /> <?=$type?> <?=core_format::date($time, 'shortest-weekday')?></a>
		  				<input class="prodDd" type="hidden" name="prodDd_<?=$prod['prod_id']?>" id="prodDd_<?=$prod['prod_id']?>" value="<?=$dd_ids_id?>"/>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
						<?
						foreach($days as $key => $day)
						{
							if (count(array_intersect($dd_ids, array_keys($day))) > 0) {
								$dd_ids_id = implode('_', array_keys($day));
								list($type, $time) = explode('-', $key);
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