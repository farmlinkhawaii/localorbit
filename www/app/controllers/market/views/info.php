<?

if(
	(
		$core->session['is_active'] != 1 || 
		$core->session['org_is_active'] != 1
	)
	&&
	$core->config['domain']['feature_allow_anonymous_shopping'] != 1
)
{
	core::process_command('catalog/not_activated',false);
}
else
{
	core::ensure_navstate(array('left'=>'left_hub_info')); 
	core::head('Local Orbit Market Information','Local Orbit Makes it easy for chefs, consumers and institutions to buy great food direct from local producers in one convenient location');
	lo3::require_permission();


	$market = $core->config['domain'];
	$address = $market->get_addresses();
	$address->__source .= ' and default_shipping=1';
	$address = $address->load()->row();
	if($address)
	{
		$has_address = true;
		$lat = $address['latitude'];
		$long = $address['longitude'];
		$address = $address['address'].', '.$address['city'].', '.$address['code'].', '.$address['postal_code'];
	}
	else
	{
		$has_address = false;
	}

	# get a list of market news
	$market_news = core::model('market_news')
		->collection()
		->filter('market_news.domain_id',$market['domain_id'])
		->sort('creation_date','desc')
		->limit(3);
	$market_news->load();

	$sellers = core::model('organizations')
		->autojoin(
			'left',
			'addresses',
			'(addresses.org_id=organizations.org_id and addresses.default_shipping=1 and latitude is not null and latitude<>0)',
			array('address','city','postal_code','latitude','longitude')
		)
		->autojoin(
			'left',
			'directory_country_region',
			'(addresses.region_id=directory_country_region.region_id)',
			array('code')
		)
		->collection()
		->filter('latitude','is not null',true)
		->filter('organizations_to_domains.domain_id',$market['domain_id'])
		->filter('is_active',1)
		->filter('is_enabled',1)
		->filter('public_profile',1);
		
	$delivs = core::model('delivery_days')->collection()->filter('domain_id',$market['domain_id']);

?>

<div class="row">
	<div class="span5">
		<img src="<?= image('profile') ?>?_time_=<?=$core->config['time']?>" style="max-height: 325px;" />
	</div>
	
	<div class="span4">
		<? if($has_address):
			echo(core_ui::map('hubmap','100%','325px',8));
			core_ui::map_center('hubmap',$lat,$long);
			core_ui::map_add_point('hubmap',$lat,$long,'<h1>'.$market['name'].'</h1>'.$address,image('hub_bubble'));
			
			foreach($sellers as $seller)
			{
				if(is_numeric($seller['latitude']) && is_numeric($seller['longitude']))
				{
					$address = $seller['address'].', '.$seller['city'].', '.$seller['code'].', '.$seller['postal_code'];
					core_ui::map_add_point('hubmap',$seller['latitude'],$seller['longitude'],'<h4>'.$seller['name'].'</h4><p class="note">'.$address.'</p>',image('farm_bubble'));
				}
			}
			?>
		<? endif; ?>
	</div>
</div>

<div class="row">
	<div class="span5">
		<h3>About <?=$market['name']?></h3>
		
		<? if(trim($market['market_profile']) != ''){?>
			<?=core_format::plaintext2html($market['market_profile'])?>
		<?}?>

		<? if (trim($market['market_policies']) != ''): ?>
		<h3>Our Policies</h3>
		<?=core_format::plaintext2html($market['market_policies'])?>
		<? endif; ?>

	</div>
	<div class="span4">
		<h3>Our Sellers</h3>
		
		<? foreach($sellers as $seller): ?>
			<a href="#!sellers-oursellers--org_id-<?=$seller['org_id']?>"><?= $seller['name'] ?></a> <small><?= $seller['city'] ?>, <?= $seller['code'] ?></small><br />
		<? endforeach; ?>
	</div>
</div>

<div class="row">
	<div class="span9">
		<? if($market_news->__num_rows > 0 ){?>
			<div class="header_1">Latest News</div>
			<? foreach($market_news as $market_newsitem){?>
				<h4><?=$market_news['title']?></h4>
				<?=$market_news['content']?>  <br />
				<div class="market_news_date">Published on <?=core_format::date($market_news['creation_date'],'short')?> </div>
				<div class="market_news_divider">&nbsp;</div>
			<?}?>
		<?}?>
	</div>
</div>

<? } ?>