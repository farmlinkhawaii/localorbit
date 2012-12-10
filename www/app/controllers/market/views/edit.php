<?php
core::ensure_navstate(array('left'=>'left_dashboard'));
core::head('Edit Market','This page is used to edit markets');
lo3::require_permission();
lo3::require_login();


# javascript to load tabset, market-specific functionality
core_ui::tabset('markettabs');
core_ui::load_library('js','market.js');
core_ui::load_library('js','address.js');
$this->rules()->js();

# load misc data
global $data, $org;
$data = core::model('domains')->load();

# if the hub you were trying to edit is NOT the same as YOUR hub, then 
# make sure the user is actually an admin. Otherwise, they can be a market manager
if(lo3::is_admin() || count($core->session['domains_by_orgtype_id'][2]) > 1)
{
	page_header('Editing '.$data['name'],'#!market-list','Back to hubs');
}
else
{
	lo3::require_orgtype('market');
	page_header('Editing '.$data['name']);
}

$managed = new core_collection('
	select organizations.org_id,name
	from organizations 
	inner join organizations_to_domains on (
		organizations_to_domains.domain_id='.$data['domain_id'].' 
		and organizations_to_domains.org_id=organizations.org_id 
		and organizations_to_domains.orgtype_id=2
	)
	
');

$org  = core::model('organizations')->collection()->filter('organizations_to_domains.orgtype_id',2)->filter('organizations_to_domains.domain_id',$data['domain_id']);
$zones = core::model('timezones')->collection()->sort('offset_seconds','desc');
$org->next();

# get the list of domains onwhich cross selling *could* occur
$domains = core::model('domains')->collection();
$cross_sells = core::model('domain_cross_sells')->collection()->filter('domain_id',$data['domain_id']);
$allows = array();
foreach($cross_sells as $cross_sell)
	$allows[$cross_sell['accept_from_domain_id']] = true;

$tabs = array('Hub Info','Delivery','Branding','Market Info','Addresses','Payments/Fees');
if(lo3::is_admin())
{
	$tabs[] = 'Cross Selling';
	$tabs[] = 'Features';
}
?>
<form name="marketForm" class="form-horizontal" method="post" action="/market/save" target="uploadArea" onsubmit="return core.submit('/market/save',this);" enctype="multipart/form-data">
	<?=core_ui::tab_switchers('markettabs',$tabs)?>
	
	<div class="tab-content">
	<div class="tab-pane tabarea" id="markettabs-s1">
		
		<fieldset>
			<?if(lo3::is_admin()){?>
			<div class="control-group">
				<label class="control-label">Domain ID</label>
				<div class="controls">
					<?=$data['domain_id']?>
				</div>
			</div>
			<?}?>
			<div class="control-group">
				<label class="control-label">Name</label>
				<div class="controls">
					<input type="text" name="name" value="<?=$data['name']?>" />
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label">Detailed Name</label>
				<div class="controls">
					<input type="text" name="detailed_name" value="<?=$data['detailed_name']?>" /> <small class="help-inline">This field is used for the registration dropdown</small>
				</div>
			</div>
			
			<?if(lo3::is_admin()){?>
			<div class="control-group">
				<label class="control-label">Managed By</label>
				<div class="controls">
					<? foreach($managed as $managed_org){?>
					<a href="#!organizations-edit--org_id-<?=$managed_org['org_id']?>"><?=$managed_org['name']?></a><br>
					<?}?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Hostname</label>
				<div class="controls">
					<input type="text" name="hostname" value="<?=$data['hostname']?>" />
					<?/* 
					<div class="input-append">
						<input type="text" name="hostname" value="<?=$data['hostname']?>" />
						<span class="add-on">.localorb.it</span>
					</div>
					*/?>
				</div>
			</div>
			<?}?>
			<div class="control-group">
				<label class="control-label">Timezone</label>
				<div class="controls">
					<select name="tz_id">
						<?=core_ui::options($zones,$data['tz_id'],'tz_id','tz_name')?>
					</select>
				</div>
			</div>
			
			<?=core_ui::checkdiv('do_daylight_savings','Apply Daylight Savings',$data['do_daylight_savings'])?>
			<?=core_ui::checkdiv('is_live','Is Live',$data['is_live'])?>
			<?=core_ui::checkdiv('is_closed','Close Store',$data['is_closed'])?>
			<?=core_ui::checkdiv('show_on_homepage','Show on Registration',$data['show_on_homepage'])?>
			<?if(lo3::is_admin()){?>
				<?=core_ui::checkdiv('autoactivate_organization','Auto-activate Organizations',$data['autoactivate_organization'])?>
			<?}?>

		</fieldset>
	</div>

	<div class="tab-pane tabarea" id="markettabs-s2">
		<? $this->delivery();	?>
	</div>
	<div class="tab-pane tabarea" id="markettabs-s3">
		<? $this->branding(); ?>
	</div>
	<div class="tab-pane tabarea" id="markettabs-s4">
		<? $this->market_info(); ?>
	</div>
	<div class="tab-pane tabarea" id="markettabs-s5">
		<? $this->addresses(); ?>
	</div>
	<div class="tab-pane tabarea" id="markettabs-s6">
		<? $this->payments_fees();?>
	</div>
	<? if(lo3::is_admin()){?>
	<div class="tab-pane tabarea" id="markettabs-s7">
		<table class="form">
		<?php foreach($domains as $domain){ ?>
			<tr>
				<td class="label">&nbsp;</td>
				<td class="value">
					<?=core_ui::checkdiv('accept_products_from_'.$domain['domain_id'],'Accept products from '.$domain['name'],$allows[$domain['domain_id']])?>
				</td>
			</tr>
		<?}?>
		</table>
	</div>

	

	<div class="tab-pane tabarea" id="markettabs-s8">

		<fieldset>
			<?=core_form::input_check('Require sellers to accept all delivery options','feature_require_seller_all_delivery_opts',$data,false,$core->i18n['hub:features:req_selr_all_delv_opts'])?>			
			<?=core_form::input_check('Force items at checkout to soonest delivery option','feature_force_items_to_soonest_delivery',$data,false,$core->i18n['hub:features:items_to_1st_delv'])?>			
			<?=core_form::input_check('Sellers enter prices before fees','feature_sellers_enter_price_without_fees',$data,false,$core->i18n['hub:features:sellers_enter_price_without_fees'])?>			
			<?=core_form::input_check('Sellers cannot modify cross-sells','feature_sellers_cannot_manage_cross_sells',$data,false,$core->i18n['hub:features:sellers_cannot_modify_cross_sells'])?>			
			<?=core_form::input_check('Sellers can change delivery statuses','feature_sellers_mark_items_delivered',$data,false,$core->i18n['hub:features:feature_sellers_mark_items_delivered'])?>			
			<?=core_form::input_check('Allow anonymous shopping','feature_allow_anonymous_shopping',$data,false,'Note: checking this feature will also enable organization auto-activation, credit card payments, and disable POs',null,false,"market.toggleAnon();")?>			
			<tr id="default_homepage_selector"<?=(($data['feature_allow_anonymous_shopping'] != '1')?' style="display: none;"':'')?>>
				<td class="label">Homepage:</td>
				<td>
					<select name="default_homepage">
						<?=core_ui::options(array('Login'=>'Login','Market Info'=>'Market Info','Our Sellers'=>'Our Sellers','Shop'=>'Shop'),$data['default_homepage'])?>
					</select>
				</td>	
			</tr>
		</fieldset>
	</div>
	
	</div>
	
	<?}?>
	<?
	if(lo3::is_admin())
		save_buttons(true);
	if(lo3::is_market())
		save_only_button();
	?>
	<input type="hidden" name="domain_id" value="<?=$data['domain_id']?>" />
	<input type="hidden" name="org_id" value="<?=$org['org_id']?>" />
	
</form>