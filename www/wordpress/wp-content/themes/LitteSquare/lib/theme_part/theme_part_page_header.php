<?php
	function ts_get_page_header(){
?>
    	<div class="container" id="header-title">
        	<div class="row">
            	<!-- Page Title -->
				<hgroup class="span8">
				<?php
				if(is_author()):
					
				?>
					<h1><?php echo get_the_author_meta("nickname",$_GET["author"]); ?></h1>
					<h2><?php echo get_the_author_meta("description",$_GET["author"]); ?></h2>
				<?php
				elseif(is_category()):
				?>
					<h1><?php echo ts_get_category_name(); ?></h1>
					<h2><?php echo category_description( ts_get_category_ID() ); ?></h2>				
				<?php
				elseif(is_search()):
				?>
					<h1><?php echo $_GET["s"]; ?></h1>
					<h2><?php echo "Search result for '".$_GET["s"]."'"; ?></h2>				
				<?php
				elseif(is_404()):
				?>
					<h1><?php echo '404 Pages' ?></h1>
					<h2><?php echo "Have no pages result"; ?></h2>				

				<?php else:
						$page_title = get_the_title();
		$page_descript = get_post_meta(get_the_ID(),"_general_subtitle",true);

				?>
	            	<h1><?php echo $page_title; ?></h1>
					 <h2><?php echo $page_descript; ?></h2>
				<?php
				endif;
				?>
	               
	            </hgroup>
                <!-- Search Form -->
                <div class="hidden-phone span4">
		            <?php get_search_form();//global $theme_options; $theme_options=get_option("themestudio");if($theme_options["enable_breadcrumbs"] == "1"):
//	echo dimox_breadcrumbs();
//endif;?>
                </div>
				
            </div>
        </div>
<?php
	}
?>