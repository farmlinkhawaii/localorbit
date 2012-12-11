<?
core::ensure_navstate(array('left'=>'left_dashboard'));
core_ui::fullWidth();
?>
<? $this->seller_orders(); ?>
<hr>
<? $this->seller_products(); ?>