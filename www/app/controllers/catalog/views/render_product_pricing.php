<?
$pricing = $core->view[0];

for ($i=0; $i < count($pricing); $i++) { ?>
	<li>
	<?if($pricing[$i]['org_id'] != 0){ ?>
		<div class="error">Your price:
	<?}?>

	<?=$pricing[$i]['price']?><small><? if($prod['single_unit'] != '') { ?>/<?=$prod['single_unit']?><? } ?><? if($pricing[$i]['min_qty'] >1){ ?>, min <?=floatval($pricing[$i]['min_qty'])?><?}?></small>

	<?if($pricing[$i]['org_id'] != 0){ ?>
		</div>
	<?}?>

	</li>
<?
	$rendered_prices++;
} 
?>