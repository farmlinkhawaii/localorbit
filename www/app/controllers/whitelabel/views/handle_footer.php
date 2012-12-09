<?php 
$opts = core::model('template_options')->get_options(array('footer'));
?>

<div class="container">
	<div class="row" style="margin-top: 30px;">
	
		<div class="span4">
			<div class="row">
				<div class="span1">
					<a href="#!misc-home">
						<img src="/img/default/logo_gray.png" />
					</a>
				</div>
				<div class="span2">
					<h4>Proudly Powered by Local Orbit</h4>
					<p class="note">Copyright <?=date('Y')?>, All Rights Reserved</p>
				</div>
			</div>
		</div>

		<div class="span4">
		<? if ($core->config['domain']['domain_id'] > 1): ?>

		<? else:
			for ($i = 1; $i < 5; $i++) {
	
				if($opts['footer-col'.$i.'-label'] != ''){ ?>

				
				<img src="<?=$opts['footer-col'.$i.'-image']?>" /><br />
				<b class="footer"><?=$opts['footer-col'.$i.'-label']?></b>
				<ul class="footer">
				<?for ($j = 1; $j < 12; $j++){?>
					<?if($opts['footer-col'.$i.'-link'.$j.'-href'] !=''){?>
					<li class="footer">
						<? if($i == 4 && $j == 2){?>
						<a class="footer" href="#" onclick="$('#overlay,#popup3,#popup_closer').fadeIn(150);">Send Us A Note Today!</a>
						<?}else{?>
						<a class="footer"<?
					
						# if a link is external to LO, open it in a new tab/window
						if(strpos($opts['footer-col'.$i.'-link'.$j.'-href'],'http') === false)
						{
							if(strpos($opts['footer-col'.$i.'-link'.$j.'-href'],'#!') !== false)
							{
								echo(' onclick="core.go(this.href);"');
							}
						}
						else
						{
							echo(' target="_blank"');
						}
					
						?> href="<?=$opts['footer-col'.$i.'-link'.$j.'-href']?>">
							<?=$opts['footer-col'.$i.'-link'.$j.'-label']?>
						</a>
						<?}?>
					</li>
					<?}?>
				<?}?>
				</ul>
				<?}?>
			<? }
		endif;
		?>
		</div>

		<div class="span4 tos">
			<small><a href="app.php#!misc-tos" onclick="core.go(this.href);">Terms of Service</a> | <a href="app.php#!misc-localorbit_privacy" onclick="core.go(this.href);">Privacy</a> | <a href="http://localorbit.zendesk.com/forums" target="_blank">Help</a></small>
		</div>
	
	</div>
</div>

<? core::replace('footer'); ?>