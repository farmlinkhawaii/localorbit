<?

$market = $core->config['domain'];	
$address = $market->get_addresses();
$address->__source .= ' and default_shipping=1';
$address = $address->load()->row();

$delivs = core::model('delivery_days')->collection()->filter('domain_id',$market['domain_id']);

?>


<img src="<?= image('profile') ?>?_time_=<?=$core->config['time']?>" />



<? if($core->config['domain']['domain_id'] > 1){?>
<br />&nbsp;<br />
<h3>Pickup/Delivery</h3>
<?
$delivs = core::model('delivery_days')->collection()->filter('domain_id',$core->config['domain']['domain_id']);
foreach($delivs as $deliv)
{
	echo('<p>'.$deliv['buyer_formatted_cycle'].'</p>');
}
?>
<?}?>
<br />
<hr class="tight">
<br />

<a class="twitter-timeline" href="https://twitter.com/EasternMarket" data-widget-id="286885721258725376">Tweets by @EasternMarket</a>

<?
core::js('!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");');
core::replace('left'); 
 
 ?>