<?php
lo3::require_permission();
lo3::require_login();


global $data;

$regions = core::model('directory_country_region')->collection()->filter('country_id','US');

if(!$data)
	$data = core::model('domains')->load();
	
if(!in_array($data['domain_id'],$core->session['domains_by_orgtype_id'][2]))
	lo3::require_orgtype('admin');
else
	lo3::require_orgtype('market');
	
$col = $data->get_addresses();
#core::log(print_r($col->to_hash('address_id'),true));
core::js('core.addresses='.json_encode($col->to_hash('address_id')).';');
core::model('addresses')->get_table('market',$col,'market/addresses?domain_id='.$core->data['domain_id']);
?>
<div class="buttonset unlock_area" id="addAddressButton"<?=(($core->session['sec_pin'] == 1)?'':' style="display:none;"')?>>
	<input type="button" class="button_secondary" value="Add New Address" onclick="core.address.editAddress('market',0);" />
	<input type="button" class="button_secondary" value="Remove Checked" onclick="core.address.removeCheckedAddresses(this.form);" />
</div>
<br />

<fieldset id="editAddress" style="display: none;">
	<legend>Address Info</legend>
	
	
	<script>
		$("input[name=address]").change(function(event){
			setLatLon();
		});
		$("input[name=city]").change(function(event){
			setLatLon();
		});
		$("input[name=postal_code]").change(function(event){
			setLatLon();
		});
		function setLatLon() {
			core.address.lookupLatLong(this.form.address.value,this.form.city.value,this.form.region_id.options[this.form.region_id.selectedIndex].text,this.form.postal_code.value);
		}	
	</script>

	<?=core_form::input_text('Label','label','','')?>
	<?=core_form::input_text('Address','address','','')?>
	<?=core_form::input_text('City','city','','')?>
	
	<div class="control-group">
		<label class="control-label" for="label">State</label>
			<div class="controls">
				<select name="region_id" onchange="core.address.lookupLatLong(this.form.address.value,this.form.city.value,this.form.region_id.options[this.form.region_id.selectedIndex].text,this.form.postal_code.value);">
					<option value="0"></option>
					<?=core_ui::options($regions,null,'region_id','default_name')?>					
				</select>
			</div>
	</div>
	
	
	
	<?=core_form::input_text('Postal Code','postal_code','','')?>
	<?=core_form::input_text('Telephone','telephone','','')?>
	<?=core_form::input_text('Fax','fax','','')?>
		
	
	<input type="hidden" name="delivery_instructions" id="delivery_instructions" value="" />
	<input type="hidden" name="latitude" id="latitude" value="" />
	<input type="hidden" name="longitude" id="longitude" value="" />
	<input type="hidden" name="address_id" value="" />
	<div class="buttonset">
		<input type="button" class="button_secondary" value="save this address" onclick="core.address.lookupLatLong(this.form.address.value,this.form.city.value,this.form.region_id.options[this.form.region_id.selectedIndex].text,this.form.postal_code.value); core.address.saveAddress('market');" />
		<input type="button" class="button_secondary" value="cancel" onclick="core.address.cancelAddressChanges();" />
	</div>
</fieldset>