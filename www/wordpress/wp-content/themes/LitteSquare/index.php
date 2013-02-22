<?php

global $body_id; 
global $home_class;
$body_id="template-home";
global $theme_options;
$slider_type = $theme_options["select_slider_type"];
$header_title = $theme_options["home_page_title"];
$page_display_forhome =  $theme_options["home_pages"];
if(isset($_GET["pid"])){
$page_display_forhome = $_GET["pid"];
}

get_header();
?>

<?php
if(isset($_GET["sl"]))
{
$slider_type = $_GET["sl"];
}


if($slider_type == '1')
{
require_once('slider/static_baner.php');
}
elseif($slider_type == '2')
{
require_once('slider/nivoslider.php');
}
elseif($slider_type == '3')
{
require_once('slider/static_slider.php');
}
elseif($slider_type == '4')
{
require_once('slider/sequenses_slider.php');
}

else{}
?>

<section id="body">
	<div class="container">
		<div class="row">
			<div id="content" class="span12">
				<div class="row subrow">
				<?php
		
				$home_post = get_post($page_display_forhome);
					
				echo do_shortcode(wpautop($home_post->post_content));
				?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
?>