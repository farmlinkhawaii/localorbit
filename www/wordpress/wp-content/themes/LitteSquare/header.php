<?php
session_start();
$_SESSION["haveliked"] = "0";
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html  <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<title><?php wp_title(); ?></title>
<?php wp_print_styles();?>
<?php wp_print_scripts();?>
<?php wp_head(); ?>
</head>
	<?php 
		global $breadcrumbs;
		$breadcrumbs = '';
		global $post;
		if(isset($post)):
		$breadcrumbs=get_dimox_breadcrumbs();
		endif;
		$add_class= "";
		  global $body_id; 
		  global $theme_options;
	      $slider_type = $theme_options["select_slider_type"];
		  $enable_bg_body = '';
		  if(isset($theme_options["enable_pattern_background_body"]) && $theme_options["enable_pattern_background_body"] == "1"){
			$enable_bg_body = "ts_style3";
		  }
		  if(isset($_GET["sl"])){ $slider_type = $_GET["sl"];}
		  
		  if(is_home()):
			  if( $slider_type == '1'):
			  
				$add_class ="";
			  
			  elseif( $slider_type == '2'):
			  
				$add_class ="slider-nivo"; 
			  
			  elseif( $slider_type == '3'):
			  
				$add_class ="";
			  
			  elseif( $slider_type == '4'):
			  
				$add_class ="";
			  
			  endif;
		  endif;
		  $add_class=$enable_bg_body." ".$add_class;
		  $page_display_forhome =  $theme_options["home_pages"];
	?>

	<body id="<?php echo $body_id;?>" <?php body_class($add_class); ?>>
<!-- Header -->
	<header id="header">
    	<div class="container" id="header-navigation">
        	<div class="row">
            	<!-- Logo -->
	        	<?php 
					ts_get_logo();
				?>
                <!-- Navigation -->
	           <?php 
					ts_theme_top_wp_nav(); 
			   ?>	
			</div>
        </div>
		<?php
			if(is_home()){
				global $theme_options;
				$header_title = $theme_options["home_page_title"];
				if($header_title != ''){
				
				echo '<div id="header-title" class="container">
						<div class="row">'.
						
							$header_title
						
						.'</div>
					</div>';
				}
			}
			else
			{
			ts_get_page_header();
			}
		?>
    </header><!-- #header -->