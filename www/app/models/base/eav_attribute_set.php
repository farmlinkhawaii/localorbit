<?php
class core_model_base_eav_attribute_set extends core_model
{
	function init_fields()
	{
		$this->add_field(new core_model_field(0,'attribute_set_id','int',8,'','eav_attribute_set'));
		$this->add_field(new core_model_field(1,'entity_type_id','int',8,'','eav_attribute_set'));
		$this->add_field(new core_model_field(2,'attribute_set_name','string',-4,'','eav_attribute_set'));
		$this->add_field(new core_model_field(3,'sort_order','int',8,'','eav_attribute_set'));
		$this->init_data();
	}
}
?>