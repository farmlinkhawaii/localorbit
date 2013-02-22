<?php
function ts_get_logo()
{
global $theme_options;
if($theme_options["select_logo_tyle"] == "1"):
	echo 	'
					<div class="span4" id="logo">
						<h1><a href="'.site_url().'">'.get_option('blogname').'</a></h1>
						<em>'.get_option('blogdescription').'</em>
					</div>
			';
else:
	echo 	'
					<div class="span4" id="logo">
					<img src="'.$theme_options["select_logo_tyle_2"].'" />
					</div>
					
			';
endif;
}

?>