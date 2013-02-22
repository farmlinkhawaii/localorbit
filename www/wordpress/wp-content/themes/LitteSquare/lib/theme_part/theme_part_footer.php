<?php
/*------------------------------------------------------------------------
*Top Menu
------------------------------------------------------------------------*/
function ts_footer() 
{
 global $theme_options;
 $copyright= $theme_options["copyright_text"];
 $enable_footer_widget='0';
 if(isset($theme_options["enable_footer_widget"])){
 $enable_footer_widget = $theme_options["enable_footer_widget"];
 }
global $breadcrumbs;
 if(!is_home() && isset($theme_options["enable_breadcrumbs"]) && $theme_options["enable_breadcrumbs"] == '1' && $breadcrumbs <>''):
	
	echo '<nav id="breadcrumbs">
	<div class="container">
	You are here : ';
	echo $breadcrumbs;
	echo '</div></nav>';
endif;
echo'<footer id="footer">'; 
 if($enable_footer_widget=='1'):
	$footer_widget_style=$theme_options["footer_widgets"];
	echo'
			<div class="inner">
				<div class="container">
					 <div class="row">';
						switch($footer_widget_style)
						{
							case '1':
								dynamic_sidebar('footer widget 1');
							break;
							case '2':
								dynamic_sidebar('footer widget 1');
								dynamic_sidebar('footer widget 2');
							break;
							case '3':
								dynamic_sidebar('footer widget 1');
								dynamic_sidebar('footer widget 2');
								dynamic_sidebar('footer widget 3');
							break;
							case '4':
								dynamic_sidebar('footer widget 1');
								dynamic_sidebar('footer widget 2');
								dynamic_sidebar('footer widget 3');
								dynamic_sidebar('footer widget 4');
							break;
						}
	echo '			</div>
				</div>
			</div>';					
?>
			<section id="copyright">
				<div class="container">
					<div class="row">
						<div class="span8"><?php echo stripslashes($copyright); ?></div>
						<div class="span4 hidden-phone">Design by <a href="http://themeforest.net/user/moutheme">MouTheme</a> <?php  if($theme_options["enable_scroll_top"] == "1"): ?>- <a id="go-top" href="#">Go Top</a><?php endif; ?></div>
					</div>
				</div>				
			</section>
        </footer>
<?php
 else:
 ?>
			<section id="copyright">
				<div class="container">
					<div class="row">
						<div class="span8"><?php echo stripslashes($copyright); ?></div>
						<div class="span4 hidden-phone">Design by <a href="http://themeforest.net/user/moutheme">MouTheme</a> <?php  if($theme_options["enable_scroll_top"] == "1"): ?>- <a id="go-top" href="#">Go Top</a><?php endif; ?></div>
					</div>
				</div>				
			</section>
		 </footer>
 <?php
 endif;
}
?>