<?php

core::ensure_navstate(array('left'=>'left_dashboard'));

core_ui::fullWidth();

core::head('Edit','Edit');
lo3::require_permission();
lo3::require_login();


global $data,$all_dds;


$data = core::model('products')
	->autojoin(
		'inner',
		'organizations_to_domains',
		'(products.org_id=organizations_to_domains.org_id and organizations_to_domains.is_home=1)'
	)->autojoin(
		'inner',
		'domains',
		'(organizations_to_domains.domain_id=domains.domain_id)',
		array('domains.fee_percen_lo','domains.fee_percen_hub','domains.paypal_processing_fee','domains.feature_sellers_enter_price_without_fees')
	)->load();
$data['total_fees'] = $data['fee_percen_lo'] + $data['fee_percen_hub'] + $data['paypal_processing_fee'];

$data->get_taxonomy();


list(
	$org_home_domain_id,
	$org_all_domains,
	$org_domains_by_orgtype_id
) = core::model('customer_entity')->get_domain_permissions( $data['org_id']);


# get all the delivery days that could apply to this product
$all_dds = new core_collection('
	select distinct dd.*,d.name as domain_name,d.feature_require_seller_all_delivery_opts,a.address,a.city,a.postal_code,dcr.code as state
	from delivery_days dd
	left join addresses  a on (dd.deliv_address_id=a.address_id)
	left join directory_country_region  dcr on (a.region_id=dcr.region_id)
	left join organization_delivery_cross_sells  odcs using (dd_id)
	left join domains  d using (domain_id)
	where  
	(
		odcs.org_id='.$data['org_id'].'
		or
		dd.domain_id in ('.implode(',',$org_all_domains).')
	)
	
	order by d.name'
);
$all_dds->__model = core::model('delivery_days');
$all_dds->load();

$units = core::model('Unit')->collection()->sort(name);

# write out all the js/rules we'll need for this form
core_ui::load_library('js','product.js');
$this->info_rules()->js(); 
$this->pricing_basic_rules()->js(); 
$this->inventory_basic_rules()->js(); 
$this->pricing_advanced_rules()->js(); 
$this->inventory_advanced_rules()->js(); 

page_header('Editing Product: '.$data['name'],'#!products-list','cancel');
?>
<form name="prodForm" class="form-horizontal" method="post" action="/products/update" target="uploadArea" onsubmit="return product.doSubmit(false)" enctype="multipart/form-data">
	<?
	$tabs = array('Product Info','Inventory','Pricing','Images');
	if($all_dds->__num_rows > 0)
		$tabs[] = 'Delivery';
	?>
	<?=core_ui::tab_switchers('producttabs',$tabs)?>
	
	<div class="tab-content">
		<div class="tabarea tab-pane active" id="producttabs-a1">
			
			<?if(lo3::is_admin() || lo3::is_market()){?>
				<?=core_form::value('Seller','<a href="#!organizations-edit--org_id-'.$data['org_id'].'">'.$data['org_name'].'</a>')?>
			<?}?>
			
			<?=core_form::input_text('Title','product_name',$data['name'],array('required' => true))?>
			
			<div class="control-group">
			    <label class="control-label" for="">Product Category</label>
				<div class="controls">
					<?foreach($data->taxonomy as $category){?>
						/ <?=$category['cat_name']?>
					<?}?>
				</div>
			</div>

			<?=core_form::input_textarea(
				'Short Description',
				'short_description',
				$data['short_description'],
				array(
					'required'=>true,
					'size'=>'input-xxlarge',
					'popover'=>'',
					'rows'=>2,
					'sublabel'=>'Please limit this to 50 characters',
			))?>

		
			<?=core_form::input_textarea(
				'Long Description',
				'description',
				$data['description'],
				array(
					'required'=>true,
					'size'=>'input-xxlarge',
					'popover'=>'Buyers want to know how you grow or prepare your products. Tell them how you do it!'
			))?>
			
			
						
			<?=core_form::value('Unit','
				<select name="unit_id" id="unit_id">
					<option value="Select a unit"></option>'.core_ui::options($units,$data['unit_id'],'UNIT_ID','PLURAL').'
				</select>
				<br />
				<div style="line-height: 30px;">
					<a href="#!units-request_new--prod_id-'.$data['prod_id'].'-prod_name-'.urlencode($data['name']).'">Request new unit</a> (if you can\'t find what you need)
				</div>',
				array('sublabel'=>'Type to search')
			)?>  
			<? 
			#core::js('$("#unit_id").select_autocomplete();$("#unit_id").show();');
			?>
			<?=core_form::value('Production Location',
				core::model('addresses')->get_radios($data['org_id'],$data['addr_id'],'address_id'),
				array('sublabel'=>'Edit addresses in <a href="#!organizations-edit--org_id-'.$data['org_id'].'">My Account</a>')
			)?>
			<?
			if(lo3::is_customer())
			{
				$who_msg = $core->i18n('products:who',$core->session['org_id']);
				$how_msg = $core->i18n('products:how',$core->session['org_id']);
			}
			else
			{
				$who_msg = $core->i18n('products:who:admin',$data['org_id']);
				$how_msg = $core->i18n('products:how:admin',$data['org_id']);
			}
			?>	
			
			
			<?=core_form::input_textarea(
				'Short '.$core->i18n['products:who:label'],
				'short_who',
				$data['short_who'],
				array(
					'sublabel' => $who_msg,
					'size'=>'input-xxlarge',
					'rows'=>2,
					'sublabel'=>'Please limit this to 50 characters',
			))?>
				
			<?=core_form::input_textarea(
				'Long '.$core->i18n['products:who:label'],
				'who',
				$data['who'],
				array(
					'sublabel' => $who_msg,
					'size'=>'input-xxlarge',
			))?>
			
			<?=core_form::input_textarea(
				'Short '.$core->i18n['products:how:label'],
				'short_how',
				$data['short_how'],
				array(
					'sublabel' => $how_msg,
					'size'=>'input-xxlarge',
					'rows'=>2,
					'sublabel'=>'Please limit this to 50 characters',
			))?>
			
			<?=core_form::input_textarea(
				'Long '.$core->i18n['products:how:label'],
				'how',
				$data['how'],
				array(
					'sublabel' => $how_msg,
					'size'=>'input-xxlarge',
			))?>

		</div>
		<div class="tabarea tab-pane" id="producttabs-a2">
			<? $this->inventory_form() ?>
		</div>
		<div class="tabarea tab-pane" id="producttabs-a3">
			<?
			$this->pricing_form() 
			?>
		</div>
		<div class="tabarea tab-pane" id="producttabs-a4">
			<? $this->images();	?>
		</div>
		<?if($all_dds->__num_rows > 0){?>
		<div class="tabarea tab-pane" id="producttabs-a5">
			<? $this->delivery_form(); ?>
		</div>
		<?}?>
		<input type="hidden" name="prod_id" value="<?=$data['prod_id']?>" />
	</div>
	<div class="form-actions" id="main_save_buttons">
		<input type="submit" class="btn btn-primary" name="save" value="save and continue editing" />
		<input type="button" onclick="product.doSubmit(true)" class="btn btn-primary" value="save and go back" />
	</div>
</form>
<?
if($core->data['invmode'] == 'yes')
{
	core::js("$('#producttabs-s2').click();");
}
?>