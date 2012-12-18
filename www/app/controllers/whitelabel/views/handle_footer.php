<?php 
$opts = core::model('template_options')->get_options(array('footer'));
?>

<div class="container">
	<div class="row" style="margin-top: 30px;">
	
		<div class="span6">
			<div class="row">
				<div class="span1">
					<a href="#!misc-home">
						<img src="/img/misc/footer_logo.png" />
					</a>
				</div>
				<div class="span5">
					<h4 style="margin: 10px 0 0 0;">Proudly Powered by Local Orbit</h4>
					<small>Copyright <?=date('Y')?>, All Rights Reserved</small>
				</div>
			</div>
		</div>

		

		<div class="span6 tos">
			<?if(trim($core->config['domain']['secondary_contact_name']) != ''){?>
				<b>Contact <?=$core->config['domain']['name']?></b><br />
				<small><a href="mailTo:<?=$core->config['domain']['secondary_contact_email']?>"><?=$core->config['domain']['secondary_contact_name']?></a><br />
				<?if(trim($core->config['domain']['secondary_contact_phone']) != ''){?>
					T: <?=$core->config['domain']['secondary_contact_phone']?><br>
				<?}?>
				</small>
				<br />
			<?}?>
		</div>
	
	</div>
</div>

<? core::replace('footer'); ?>