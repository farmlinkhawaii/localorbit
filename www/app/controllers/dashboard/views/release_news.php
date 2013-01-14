<?
	core::log('show it: '.(print_r($_COOKIE['cookie'],true)));
	// reset to test  devannarbor-mi.localorb.it/release_news.php?has_seen_release_news=0
	if (isset($core->data["has_seen_release_news"])) {
		#setcookie("has_seen_release_news",'yes');
		core::log('pre set: '.print_r($_COOKIE['cookie'],true));
		$user = core::model('customer_entity')->load($core->session['user_id']);
		$user['login_note_viewed'] = 1;
		$user->save();
		$core->session['login_note_viewed'] = 1;
		setcookie("has_seen_release_news",'yes',time()+999999999,'/',$core->config['domain']['hostname']);
		core::log('post set: '.print_r($_COOKIE['cookie'],true));
		
		core::js('$("#releaseNewsModal").modal("hide");');
		core::deinit();
	}
	else if ($core->session['login_note_viewed']  != 1)
	{
	
?>

	
	<!-- Button to trigger modal test -->
	<!--
	<a href="#releaseNewsModal" role="button" class="btn" data-toggle="modal">Launch demo modal</a>
	-->
	
	<div id="releaseNewsContinue"></div>
	
			
	<div id="releaseNewsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
			<h3 id="myModalLabel">It Keeps Getting Better: Introducing a Revamped Design</h3>
		</div>
		    
		<div class="modal-body"> 
			You may have noticed a few changes around here. 
			We're excited to announce a completely updated online marketplace experience with the introduction of several 
			new features and enhancements to a few of your favorites.
			<p/>
			
			What's New:
			<ol>
				<li>Updated design</li>
				<li>Customizable branding options</li>
				<li>New Market Info and News pages</li>
				<li>Extra help tips & descriptive prompts</li>
			</ol>
			
			What's Changed:
			<ol>
				<li>Streamlined navigation</li>
				<li>Faster ordering and checkout process</li>
				<li>Updated email notifications</li>
				<li>Additional product description fields</li>
			</ol>
			<p/>
			Learn more about the changes <a target="_blank" href="https://localorbit.zendesk.com/entries/22926838-introducing-a-revamped-design">here.</a>	
			<p/>
			<p/>
		</div>
		
		
		<div class="modal-footer">
			<a class="btn btn-large" data-dismiss="modal" href="">Remind Me Later</a>
			<a class="btn btn-large btn-primary" onclick="core.doRequest('/dashboard/release_news',{'has_seen_release_news':'true'});">Got It</a>
		</div>
	</div>
	
<?
		core::js('$("#releaseNewsModal").modal();');
	}
?>
	
