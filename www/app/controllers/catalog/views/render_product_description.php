<?
$prod = $core->view[0];
$seller = $core->view[1];

$description = $prod['short_description'];
$farm_name = $prod['org_name'];

$long_description = $prod['description'];
$description_popup = trim($prod['who']);

if (!empty($long_description))
{
	$long_description = htmlentities($long_description . '<a class="btn btn-small btn-info pull-right" href="#!catalog-view_product--prod_id-'.$prod['prod_id'].'">Learn More</a>');
}
//if($description_popup == '')
if (!empty($description_popup))
{
	$description_popup = trim($seller['profile']);
	$description_popup .= '<p><a class="btn btn-small btn-info pull-right" href="#!sellers-oursellers--org_id-'.$prod['org_id'].'"><i class="icon-arrow-right" /> Learn More</a></p>';
	$description_popup = htmlentities($description_popup);
}

$how_popup = $prod['how'];
if($how_popup == '')
	$how_popup = $seller['product_how'];
if(!empty($how_popup))
{
	$how_popup .= '<p><a class="btn btn-small btn-info pull-right" href="#!catalog-view_product--prod_id-'.$prod['prod_id'].'"><i class="icon-arrow-right" /> Learn More</a></p>';
	$how_popup = htmlentities($how_popup);
}

?>


	<link rel="stylesheet" href="/css/iconmoon/Sprites/sprites.css">

<a class="product_name" href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$prod['name']?></a>
<br />
<?=$description?>
<?
if (!empty($long_description) && trim($prod['description']) !== trim($description))
{
?>
&nbsp;<i class="icon-plus-circle" rel="clickover" data-placement="bottom" data-content="<?=$long_description?>" style=""/>
<?
}
?>
<br />
<small class="whowhatwhere">
	<?
	if (!empty($description_popup))
	{
	?>
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$description_popup?>">
		<i class="icon icon-binoculars" />
		<?=$farm_name?>
	</a>&nbsp;
	<?
	}
	if (!empty($how_popup))
	{
	?>
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$how_popup?>">
		<i class="icon icon-eye" />
		How
	</a>&nbsp;
	<?
	}
	?>
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="<?=$prod['city']?>, <?=$prod['code']?>" data-content="<?= htmlspecialchars('<img src="//maps.googleapis.com/maps/api/staticmap?center=' . $prod['latitude'] . ',' . $prod['longitude'] . '&zoom=7&size=310x225&sensor=false&markers=size:small%7Ccolor:white%7C' . $prod['latitude'] . ',' . $prod['longitude'] . '" />'); ?>">
		<i class="icon icon-direction" /> Where
	</a>
</small>