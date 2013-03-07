<?php 

$sellers = core::model('domains')->load_sellers();
$social_option = null;

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

echo('<h2>Sellers</h2>');
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

<div id="tweets">
	<div class="twitter-header">
		<h3>Tweets</h3>
	</div>
	<div class="twitter-feed"></div>
</div>
<div id="facebook">
	<div class="facebook-header">
	<h3>Facebook</h3>
	<div class="fb-follow" data-href="https://www.facebook.com/localorbit" data-layout="button_count" data-show-faces="false" data-width="100"></div>
	</div>
	<ol class="facebook-feed">
	</ol>
</div>

<? core::replace('left'); ?>