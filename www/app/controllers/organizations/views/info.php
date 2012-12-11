<?
global $data,$domains,$all_domains;
$domain = core::model('domains')->load($data['domain_id']);
$users = core::model('customer_entity')->add_custom_field('CONCAT(first_name, \' \', last_name) as full_name')->collection()->filter('is_deleted',0)->filter('is_enabled', 1)->filter('is_active', 1)->filter('org_id', $data['org_id']);
//print_r($users);
/*
$items = array();
$items[] = core_form::input_text('Name:','name',$data,true);
$items[] = core_form::input_text($core->i18n['organizations:facebook'].':','facebook',$data);
$items[] = core_form::input_text($core->i18n['organizations:twitter'].':','twitter',$data);

if(lo3::is_admin() || lo3::is_market())
{
	$items[] = core_form::input_check('Allowed to sell products','allow_sell',$data);
	$items[] = core_form::header_nv('Organization Payment Methods');


}

echo(
	core_form::tab('orgtabs',
		core_form::table_nv(
			$items
		)
	)
);
*/

?>
<div class="tab-pane active" id="orgtabs-a1">
	
	<div class="control-group">
		<label class="control-label" for="name">Name</label>
		<div class="controls">
			<input type="text" name="name" value="<?=$data['name']?>" />
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="facebook"><?=$core->i18n['organizations:facebook']?></label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on">facebook.com/</span>
				<input type="text" name="facebook" value="<?=$data['facebook']?>" />
			</div>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="twitter"><?=$core->i18n['organizations:twitter']?></label>
		<div class="controls">
			<div class="input-prepend">
				<span class="add-on">@</span>
				<input type="text" name="twitter" value="<?=$data['twitter']?>" />
			</div>
		</div>
	</div>


	<? if(lo3::is_admin() || lo3::is_market()): ?>
		
		<?= core_ui::checkdiv('allow_sell','Allowed to sell products',$data['allow_sell']); ?>
	
		<h3>Organization Payment Methods</h3>

		<? if($domain['payment_allow_paypal'] == 1 || $data['payment_allow_paypal']): ?>
			<?= core_ui::checkdiv('payment_allow_paypal','Allow CC via Paypal',$data['payment_allow_paypal']); ?>
		<? endif; ?>

		<? if($domain['payment_allow_purchaseorder'] == 1 || $data['payment_allow_purchaseorder']): ?>
			<?= core_ui::checkdiv('payment_allow_purchaseorder','Allow Purchase Orders',$data['payment_allow_purchaseorder']); ?>
		<? endif; ?>

	<? endif; ?>


	<? if(lo3::is_admin() || lo3::is_market() || $data['org_id'] == $core->session['org_id']) { ?>
		
		<div class="control-group">
			<label class="control-label" for="payment_entity_id">Payment Contact</label>
			<div class="controls">
				<select name="payment_entity_id">
					<?=core_ui::options($users,$data['payment_entity_id'],'entity_id','full_name')?>
				</select>
			</div>
		</div>

	<? } ?>


	<?if(lo3::is_admin() || lo3::is_market()){?>

		<div<?=(($domain['payment_allow_purchaseorder'] == 1 || $data['payment_allow_purchaseorder'])?'':' style="display:none;')?>>
	
			<div class="control-group">
				<label class="control-label" for="po_due_within_days">PO payments due</label>
				<div class="controls">
					<input type="text" class="input-mini" name="po_due_within_days" value="<?=intval($data['po_due_within_days'])?>" /> <span class="help-inline">days</span>
				</div>
			</div>

		</div>

	<?}?>

	<?if(lo3::is_admin()){?>

		<h3>Organization Options</h3>

		<div class="control-group">
			<label class="control-label" for="domain_id">Hub</label>
			<div class="controls">
				<select name="domain_id">
					<?=core_ui::options($all_domains,$data['domain_id'],'domain_id','name')?>
				</select>
			</div>
		</div>
		
		<div class="control-group">
			<label class="control-label" for="buyer_type">Buyer Type</label>
			<div class="controls">
				<select name="buyer_type">
					<?=core_ui::options(array('Wholesale'=>'Wholesale','Retail'=>'Retail'),$data['buyer_type'])?>
				</select>
			</div>
		</div>
		
	<?}?>

</div>