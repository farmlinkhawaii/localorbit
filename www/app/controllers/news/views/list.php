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
	core::hide_dashboard();
	
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
			<h2><i class="icon-newspaper"/>Latest Market News</h2>
			<? foreach($market_news as $market_newsitem){?>
				<div class="row">
					
					<div class="span3">
						<h3 class="altcolor">
							<?=$market_news['title']?> 
							<br /><small><?=core_format::date($market_news['creation_date'],'short')?></small>
						</h3>
					</div>
					<div class="span6">
						<div id="mnews_<?= $market_newsitem['mnews_id']?>">
						<p style="padding-top: 10px;"><?=$market_news['content']?></p>
						</div>
						<!--
						 style="height: 65px;overflow:hidden;"
						<div class="pull-right"><a class="btn btn-info mnews_toggle_<?= $market_newsitem['mnews_id']?>" onclick="$('.mnews_toggle_<?= $market_newsitem['mnews_id']?>').toggle();$('#mnews_<?= $market_newsitem['mnews_id']?>').css('overflow','visible');"><i class="icon-plus" /></a></div>
						<div class="pull-right"><a class="btn btn-info mnews_toggle_<?= $market_newsitem['mnews_id']?>" style="display: none;"  onclick="$('.mnews_toggle_<?= $market_newsitem['mnews_id']?>').toggle();$('#mnews_<?= $market_newsitem['mnews_id']?>').css('overflow','hidden');"><i class="icon-minus" /></a></div>
						-->
					</div>
				</div>
				
				
				<hr />
			<?}?>
		<?}else{?>
			<div class="row">
						
				<div class="span3">
					<h3 class="altcolor">
						Our Market is Buzzing
						<br /><small><?=core_format::date(time(),'short')?></small>
					</h3>
				</div>
				<div class="span6">
					<div id="mnews_0">
					<p style="padding-top: 10px;">Our market is buzzing with so much activity, we haven’t updated this news page. Not to worry. We will be back soon.</p>
					</div>
					<!--
					 style="height: 65px;overflow:hidden;"
					<div class="pull-right"><a class="btn btn-info mnews_toggle_<?= $market_newsitem['mnews_id']?>" onclick="$('.mnews_toggle_<?= $market_newsitem['mnews_id']?>').toggle();$('#mnews_<?= $market_newsitem['mnews_id']?>').css('overflow','visible');"><i class="icon-plus" /></a></div>
					<div class="pull-right"><a class="btn btn-info mnews_toggle_<?= $market_newsitem['mnews_id']?>" style="display: none;"  onclick="$('.mnews_toggle_<?= $market_newsitem['mnews_id']?>').toggle();$('#mnews_<?= $market_newsitem['mnews_id']?>').css('overflow','hidden');"><i class="icon-minus" /></a></div>
					-->
				</div>
			</div>
			
			
			<hr />
		<?}?>
	</div>
</div>

<? } ?>