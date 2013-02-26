<?php
class core_model_base_catalog_product_entity_gallery extends core_model
{
	function init_fields()
	{
		$this->add_field(new core_model_field(0,'value_id','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(1,'entity_type_id','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(2,'attribute_id','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(3,'store_id','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(4,'entity_id','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(5,'position','int',8,'','catalog_product_entity_gallery'));
		$this->add_field(new core_model_field(6,'value','string',-4,'','catalog_product_entity_gallery'));
		$this->init_data();
	}
}
?>