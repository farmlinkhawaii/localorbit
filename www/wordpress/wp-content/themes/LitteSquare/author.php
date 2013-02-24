<?php
/**
 * Author File : 
 * The main template file for display portfolio page.
 * Author : vthanh_88
 * @package WordPress
*/
global $body_id; 

$body_id="template-blog";
get_header();

?>
<section id="body">
	<div class="container">
		<div class="row">
			<?php
				global $theme_options;
				$blog_categorylayout = $theme_options["blog_category_layout_1"];
				$blog_categorynums = $theme_options["blog_category_nums"];
				$sidebar = $theme_options["blog_category_sidebar"];
				if($blog_categorylayout == "1"):
			?>
				<aside id="page-sidebar" class="span3 sidebar">
					<?php
						dynamic_sidebar($sidebar);
					?>
				</aside>
				<div id="content" class="span9">
					<?php
							//Call from loop/blog.php
							ts_the_blog_list();
					?>
				</div>
			<?php
				else:
			?>
				<div id="content" class="span9">
					<?php
						//Call from loop/blog.php
							ts_the_blog_list();
					?>
				</div>
				<aside id="page-sidebar" class="span3 sidebar">
					<?php
						
						dynamic_sidebar($sidebar);
					?>
				</aside>
			<?php				
				endif;
			?>
		</div>
	</div>
</section>
<?php
get_footer();
?>