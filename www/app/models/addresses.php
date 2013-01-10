<?php
class core_model_addresses extends core_model_base_addresses
{
	function init_fields()
	{
		global $core;
		parent::init_fields();
		$this->autojoin(
			'left',
			'directory_country_region',
			'(directory_country_region.region_id=addresses.region_id)',
			array('code')
		);
	}
	function get_table($type,$col,$url)
	{
		global $core;
		#	core::log(gettype($col->__model->autojoin));
		#core::log('tring to determine class: '.print_r(get_class_methods(get_class($col->__model)),true));
		$col->add_formatter('address_formatter');
		$col->filter('is_deleted','=','0');
		$addresses = new core_datatable('addresses',$url,$col);
		$addresses->add(new core_datacolumn('address','Address',true,'50%','<a href="Javascript:core.address.editAddress(\''.$type.'\',\'{address_id}\');">{label}</a><br>{formatted_address}'));
		$addresses->add(new core_datacolumn('telephone','Telephone',true,'20%','<a href="Javascript:core.address.editAddress(\''.$type.'\',\'{address_id}\');">{telephone}</a>'));
		#$addresses->add(new core_datacolumn('fax','Fax',true,'12%','<a href="Javascript:core.address.editAddress(\''.$type.'\',\'{address_id}\');">{fax}</a>'));
		#$addresses->add(new core_datacolumn('address_id','Default Bill',false,'13%',core_ui::radiodiv('default_billing_{address_id}','&nbsp;',false,'is_default_billing',false,'core.address.setDefaultBill({address_id},{org_id});')));
		#$addresses->add(new core_datacolumn('address_id','Default Ship',false,'13%',core_ui::radiodiv('default_shipping_{address_id}','&nbsp;',false,'is_default_shipping',false,'core.address.setDefaultShip({address_id},{org_id});')));

		$addresses->add(new core_datacolumn('address_id','Default Bill',false,'13%','<input type="radio" name="default_billing" id="default_billing_{address_id}" value="{address_id}" onclick="core.address.setDefaultBill({address_id},{org_id});"{billing_checked} />'));
		$addresses->add(new core_datacolumn('address_id','Default Ship',false,'13%','<input type="radio" name="default_shipping" id="default_shipping_{address_id}" value="{address_id}" onclick="core.address.setDefaultShip({address_id},{org_id});"{shipping_checked} />'));

		$addresses->add(new core_datacolumn('address_id',core_ui::check_all('addresses'),false,'4%',core_ui::check_all('addresses','address_id')));

		$addresses->size = (-1);
		$addresses->display_filter_resizer = false;
		$addresses->render_page_select = false;
		$addresses->render_page_arrows = false;
		
		$addresses->display_exporter_pager = false;
		#$addresses->render_page_arrows = false;
		
		$addresses->render();
	}
	
	function get_selector($org_id)
	{
		return $this->add_formatter('simple_formatter')
			->collection()
			->filter('org_id',$org_id);
	}
	
	function get_radios($org_id,$value,$name='addr_id')
	{
		$data = $this->add_formatter('simple_formatter');
		$data = $data->collection()
			->filter('org_id','=',$org_id)
			->filter('is_deleted','=',0)
			->sort('label');
		
		$html = '';
		
		$data->load();
		
		foreach($data as $row)
		{
			$html .= core_ui::radiodiv(
				$name,
				'<b>'.$row['label'].'</b><br />'.$row['formatted_address'],
				$value == $row['addr_id'],
				$name.'_radiogroup'
			);
		}
		return $html;
	}
}

function simple_formatter($data)
{
	$data['formatted_address'] = $data['address'].', '.$data['city'].', '.$data['code'].' '.$data['postal_code'];
	
	return $data;
}

function address_formatter($data)
{
	$data['billing_checked'] = '';
	$data['shipping_checked'] = '';
	$data['formatted_address'] = $data['address'].', '.$data['city'].', '.$data['code'].' '.$data['postal_code'];
	if($data['default_billing'] == 1)
	{
		$data['billing_checked'] = ' checked="checked"';
		
		#core::log('setting default billing');
		#core::js('core.ui.setRadiodiv(\'default_billing_'.$data['address_id'].'\',\'is_default_billing\',1);');
	}
	if($data['default_shipping'] == 1)
	{
		$data['shipping_checked'] = ' checked="checked"';
		#core::log('setting default_shipping');
		#core::js('core.ui.setRadiodiv(\'default_shipping_'.$data['address_id'].'\',\'is_default_shipping\',1);');
	}
	return $data;
}
?>