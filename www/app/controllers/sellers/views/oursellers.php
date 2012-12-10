<?php  

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
		
	lo3::require_permission();
	
	global $core;
	core::head('Our Sellers','','');

	core::ensure_navstate(array('left'=>'left_seller_list')); 

	# figure out which seller to load
	$seller = core::model('domains')->load_sellers()->limit(1);
	
	
	if(intval($core->data['org_id']) == 0)
	{
		# we need to choose a random one to display
		$seller->sort('rand()');
	}
	else
	{
		# one is specified in teh url
		$seller->filter('o.org_id',$core->data['org_id']);
	}
	
	$seller = $seller->row();
	#core::log(print_r($seller,true));
	
	

	# get their address and photo
	if(intval($seller['org_id']) == 0) 
	{
		page_header('No sellers yet!');
		?>
		<div class="alert alert-error">There are no sellers on this hub yet. Please check back once some have registered.</div>
		<?
		#core::replace('left','&nbsp;');
	}
	else
	{
		$address = core::model('addresses')
			->add_formatter('simple_formatter')
			->collection()
			->filter('org_id',$seller['org_id'])
			->filter('default_shipping',1)
			->limit(1);
		$address = $address->row();
		core::log('address: '.$address['latitude'].'/'.$address['longitude']);
		$map = '';
		if(is_numeric($address['latitude'])  && is_numeric($address['longitude']))
		{
			$map = core_ui::map('mymap','100%','325px',8);
			core_ui::map_center('mymap',$address['latitude'],$address['longitude']);
			core_ui::map_add_point('mymap',$address['latitude'],$address['longitude'],'<h1>'.$seller['name'].'</h1>'.$address['formatted_address'],image('farm_bubble'));
		}
		list($has_image,$web_path) = $seller->get_image();

		# get a list of their products
		$products = core::model('products')->get_catalog_for_seller($seller['org_id']);

		$products->load();
?>

<div class="row">
	<div class="span5">

		<h2><?=$seller['name']?></h2>
		<?if($has_image){?><img src="<?=$web_path?>" /><?}?>
	
	</div>
	<div class="span4">
		
		<h3><?=$address['formatted_address']?></h3>
		<?=$map?>

	</div>
</div> <!-- /row-->

<div class="row">
	<div class="span5">
		
		<?if(trim($seller['profile']) != ''){?>
			<h2>Who We Are</h2>
			<p><?=core_format::plaintext2html($seller['profile'])?></p>
		<?}?>
	
	</div>
	<div class="span4">

		<?if(trim($seller['product_how']) != ''){?>
			<h2>How We Do It</h2>
			<p><?=core_format::plaintext2html($seller['product_how'])?></p>
		<?}?>

	</div>
</div>

<hr>

<div class="row">

	<div class="span9">
	<? if($products->__num_rows > 0 ){?>
		<? foreach($products as $prod){?>
		<div class="subheader_1">
			<a href="#!catalog-view_product--prod_id-<?=$prod['prod_id']?>">
				<?=$prod['name']?> (<?=$prod['plural_unit']?>)
			</a>
		</div>
		<?}?>
	<?}?>
	</div>

</div>
			
<?}?>
<?}?>