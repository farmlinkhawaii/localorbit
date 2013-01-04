<?

if(
	(
		$core->session['is_active'] != 1 || 
		$core->session['org_is_active'] != 1
	)
	&&
	$core->config['domain']['feature_allow_anonymous_shopping'] != 1
)
{
	core::process_command('catalog/not_activated',false);
}
else
{
	core::ensure_navstate(array('left'=>'left_news'));
	core_ui::showLeftNav();
	
	core::head('Local Orbit Market Information','Local Orbit Makes it easy for chefs, consumers and institutions to buy great food direct from local producers in one convenient location');
	lo3::require_permission();

	$market = $core->config['domain'];

	# get a list of market news
	$market_news = core::model('market_news')
		->collection()
		->filter('market_news.domain_id',$market['domain_id'])
		->sort('creation_date','desc');
	$market_news->load();

?>



<div class="row">
	<div class="span9">
		<? if($market_news->__num_rows > 0 ){?>
			<h2>Latest Market News</h2>
			<? foreach($market_news as $market_newsitem){?>
				<h3 class="altcolor"><?=$market_news['title']?> <small><?=core_format::date($market_news['creation_date'],'short')?></small></h3>
				<p><?=$market_news['content']?></p>
				<hr>
			<?}?>
		<?}?>
	</div>
</div>

<? } ?>