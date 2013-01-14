<?
$prod = $core->view[0];
$seller = $core->view[1];


$description = $prod['short_description'];
$farm_name = $prod['org_name'];

$description_popup = $prod['who'];
if($description_popup == '')
	$description_popup = $seller['profile'];
$description_popup .= '<p><a class="btn btn-small btn-info pull-right" href="#!sellers-oursellers--org_id-'.$prod['org_id'].'"><i class="icon-arrow-right" /> Learn More</a></p>';
$description_popup = htmlentities($description_popup);


$how_popup = $prod['how'];
if($how_popup == '')
	$how_popup = $seller['product_how'];
if($how_popup !=='')
	$how_popup .= '<p><a class="btn btn-small btn-info pull-right" href="#!catalog-view_product--prod_id-'.$prod['prod_id'].'"><i class="icon-arrow-right" /> Learn More</a></p>';

$how_popup = htmlentities($how_popup);



?>


	<link rel="stylesheet" href="/css/iconmoon/Sprites/sprites.css">

<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>"><?=$prod['name']?></a>
<br />
<?=$description?>			
<br />
<small class="whowhatwhere">
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$description_popup?>">
		<i class="icon icon-binoculars" />
		<?=$farm_name?>
	</a>&nbsp;
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="" data-content="<?=$how_popup?>">
		<i class="icon icon-eye" />
		How
	</a>&nbsp;
	<a href="" onclick="return false;" rel="clickover" data-placement="bottom" data-title="<?=$prod['city']?>, <?=$prod['code']?>" data-content="<?= htmlspecialchars('<img src="//maps.googleapis.com/maps/api/staticmap?center=' . $prod['latitude'] . ',' . $prod['longitude'] . '&zoom=7&size=310x225&sensor=false&markers=size:small%7Ccolor:white%7C' . $prod['latitude'] . ',' . $prod['longitude'] . '" />'); ?>">
		<i class="icon icon-direction" /> Where
	</a>
</small>