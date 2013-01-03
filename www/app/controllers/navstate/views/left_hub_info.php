<?

$market = $core->config['domain'];	
$address = $market->get_addresses();
$address->__source .= ' and default_shipping=1';
$address = $address->load()->row();
?>


<img src="<?= image('profile') ?>?_time_=<?=$core->config['time']?>" />

<hr class="tight">

<a class="twitter-timeline" href="https://twitter.com/EasternMarket" data-widget-id="286885721258725376">Tweets by @EasternMarket</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

<? core::replace('left'); ?>