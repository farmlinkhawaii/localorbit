<?php

core::ensure_navstate(array('left'=>'left_dashboard'));
core::head('Edit organizations','This page is used to edit organizations');
lo3::require_permission();
lo3::require_login();


# load the data needed for this form and store it into misc global vars
global $data,$domains,$all_domains,$org_all_domains;
$data = core::model('organizations')->load();
core::log('loading org '.$data['org_id']);
$all_domains = core::model('domains')->collection()->sort('name');
$org_domains = core::model('organizations_to_domains')->collection()->filter('org_id',$data['org_id']);
list(
	$org_home_domain_id,
	$org_all_domains,
	$org_domains_by_orgtype_id
) = core::model('customer_entity')->get_domain_permissions( $data['org_id']);
//print_r($org_all_domains);
$is_mm = (count($org_domains_by_orgtype_id[2]) > 0);

# get a list of domains whch this org can cross sell on
$domains = core::model('domains')
	->collection()
	->filter(
		'domain_id',
		'in',
		'(
			select domain_id 
			from domain_cross_sells 
			where accept_from_domain_id in ('.implode(',',$org_all_domains).')
		)'
	)->sort('name')->load();
$this->save_rules($data['allow_sell'] == 1)->js();

# kick out a normal customer trying to view any other org
if(lo3::is_customer() && $data['org_id'] != $core->session['org_id'])
{
	#core::log('here');
	core::log('redirect 1');
	lo3::require_orgtype('admin');
}

# kick out a market manager trying to view an org from another domain
if(lo3::is_market() && !in_array($org_home_domain_id,$core->session['domains_by_orgtype_id'][2]))
{
	#core::log('here');
	core::log('redirect 2');
	lo3::require_orgtype('admin');
}


# javascript to load org-editing-specific functionality
core_ui::load_library('js','org.js');
core_ui::load_library('js','address.js');

# determine which tabs we're going to show, and store the right tabid
$tabs = array('Organization Info','Addresses','Users','Bank Account');
if(
	$data['allow_sell'] == 1 and 
	$domains->__num_rows > 0 and
	(
		!lo3::is_customer() || 
		(lo3::is_customer() && $data['feature_sellers_cannot_manage_cross_sells'] == 0)
	)
)
{
	$tabs[] = 'Cross Sell';
	$crosssell_tab_id = count($tabs);
}
if($data['allow_sell'] == 1)
{
	$tabs[] = 'Seller Profile';
	$profile_tab_id = count($tabs);
}
if($is_mm && lo3::is_admin())
{
	$tabs[] = 'Managed Hubs';
	$managehubs_tab_id = count($tabs);
}

# print out the form
page_header('Editing '.$data['name'],'#!organizations-list','cancel');

if($data['is_deleted'] == 1)
{
	echo('<div class="error">This organization has been deleted.</div>');
}
?>
<form name="organizationsForm" method="post" action="/organizations/save" onsubmit="return core.submit('/organizations/save',this);" enctype="multipart/form-data">
	<?=core_ui::tab_switchers('orgtabs',$tabs)?>
	<? $this->info($is_mm); ?>
	<? $this->addresses(); ?>
	<? $this->users(); ?>
	<? $this->payment_methods(); ?>
	<? $this->cross_sell($crosssell_tab_id); ?>
	<? $this->profile($profile_tab_id); ?>
	<? $this->managed_hubs($managehubs_tab_id,$is_mm); ?>
	<?
	if($core->data['me'] == '1') 
		save_only_button();
	else
		save_buttons();
	?>
	<input type="hidden" name="org_id" value="<?=$data['org_id']?>" />
</form>
