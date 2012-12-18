<!--
<?if(trim($core->config['domain']['buyer_types_description']) != ''){?>
	<h3>Currently Selling To</h3>
	<p><?=$core->config['domain']['buyer_types_description']?></p>
<?}?>
-->


<?if(trim($core->config['domain']['secondary_contact_name']) != ''){?>
	<h3>Contact</h3>
	<p><a href="mailTo:<?=$core->config['domain']['secondary_contact_email']?>"><?=$core->config['domain']['secondary_contact_name']?></a><br />
	<?if(trim($core->config['domain']['secondary_contact_phone']) != ''){?>
		T: <?=$core->config['domain']['secondary_contact_phone']?><br>
	<?}?>
	</p>

<?}?>


<? if($core->config['domain']['domain_id'] > 1){?>
	<h3>Pickup/Delivery</h3>
	<?
	$delivs = core::model('delivery_days')->collection()->filter('domain_id',$core->config['domain']['domain_id']);
	foreach($delivs as $deliv)
	{
		echo('<p>'.$deliv['buyer_formatted_cycle'].'</p>');
	}
?>
<?}?>
<? core::replace('left'); ?>