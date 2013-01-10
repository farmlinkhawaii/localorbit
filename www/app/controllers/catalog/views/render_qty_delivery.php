<?
$prod = $core->view[0];
$days = $core->view[1];
$dd_id = $core->view[2];
$dd_ids = $core->view[3];
$qty = $core->view[4];
?>
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
					if (!isset($dd_id) || array_key_exists($dd_id, $day)) {
						$selected_dd_key = $key;
						break;
					}
				}
			}
			$dd_ids_id = implode('_', array_keys($day));
			list($type, $time) = explode('-', $key);
			?>
			<a class="dropdown-toggle dd_selector" data-toggle="dropdown">
				<?=$type?> <?=core_format::date($time, 'shortest-weekday')?>
				<span class="caret"></span>
			</a>
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
			<?=$type?> <?=core_format::date($time, 'shortest-weekday')?>
			<?
		}
		?>
	</ul>
		</div>
	</div>
</div>