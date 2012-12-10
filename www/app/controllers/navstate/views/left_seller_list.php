<?php 

$sellers = core::model('domains')->load_sellers();


global $random_seller;


if($core->config['url-controller'] == 'sellers')
{
	if(is_numeric($core->data['org_id']))
	{
		$random_seller = $core->data['org_id'];
	}
	else
	{
		$random_index = rand(0,($sellers->__num_rows - 1));
		foreach($sellers as $seller)
		{
			#echo('row is: '.$sellers->__current.'<br />');
			if($sellers->__current == $random_index)
			{
				$random_seller = $seller['org_id'];
			}
		}
	}
}

core::log('random seller is: '.$random_seller);

echo('<h2>Our Sellers</h2>');
echo('<ul class="nav nav-list">');
foreach($sellers as $seller)
{
	?>
	<li>
		<a href="#!sellers-oursellers--org_id-<?=$seller['org_id']?>">
			<?=$seller['name']?>
		</a>
	</li>
	<?
}
echo('</ul>');
?>


<? core::replace('left'); ?>