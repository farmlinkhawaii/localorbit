<?php
/**
 * Template Name: Page Fullwidth Template
 * The main template file for display portfolio page.
 * Author : vthanh_88
 * @package WordPress
*/
global $body_id; 

$page_type = get_post_meta(get_the_ID(),'_page_template',true);
$body_id="template-default";
if($page_type == 'default'):
$body_id="template-default";
elseif($page_type == 'blog'):
$body_id="template-blog";
elseif($page_type == 'portfolio'):
$body_id="template-portfolio";
elseif($page_type == 'contact'):
$body_id="template-contact";
endif;
get_header();

?>
<section id="body">
	<div class="container">
		<div class="row">
			<?php
			if($page_type == "default"):
				if(get_post_meta(get_the_ID(),'_page_default',true) == "fw"):	
			?>
				<div id="content" class="span12">
					<div class="row subrow">
						<?php
						if(have_posts()):the_post();
						   the_content();  
						endif;
						?>
					</div>
				</div>
			<?php
				elseif(get_post_meta(get_the_ID(),'_page_default',true) == "lb"):	
			?>
				<aside id="page-sidebar" class="span3 sidebar">
					<?php
						$sidebar = get_post_meta(get_the_ID(),'_page_sidebar',true);
						dynamic_sidebar($sidebar);
					?>
				</aside>			
				<div id="content" class="span9">
					<div class="row subrow">
						<?php
						if(have_posts()):the_post();
						   the_content();  
						endif;
						?>
					</div>
				</div>	
			
			<?php			
				elseif(get_post_meta(get_the_ID(),'_page_default',true) == "rb"):	
			?>
				<div id="content" class="span9">
					<div class="row subrow">
						<?php
						if(have_posts()):the_post();
						   the_content();  
						endif;
						?>
					</div>
				</div>	
				<aside id="page-sidebar" class="span3 sidebar">
					<?php
						$sidebar = get_post_meta(get_the_ID(),'_page_sidebar',true);
						dynamic_sidebar($sidebar);
					?>
				</aside>
			
			<?php			
				endif;
				
			//End Page Default
			elseif($page_type == "blog"):
				$blog_layout = get_post_meta(get_the_ID(),'_page__blog_style',true);
				$blog_sidebar = get_post_meta(get_the_ID(),'_page_sidebar',true);
				$blog_cat = get_post_meta(get_the_ID(),'_page_blog_cat',true);
				$blog_nums = get_post_meta(get_the_ID(),'_page_blog_num',true);
				$sidebar = get_post_meta(get_the_ID(),'_page_sidebar',true);
				if($blog_layout == "lb"):
			?>
				<aside id="page-sidebar" class="span3 sidebar">
					<?php
						dynamic_sidebar($sidebar);
					?>
				</aside>
				<div id="content" class="span9">
					<?php
							//Call from loop/blog.php
							ts_the_blog_list($blog_nums,'id',$blog_cat);
					?>
				</div>
			<?php
				else:
			?>
				<div id="content" class="span9">
					<?php
						//Call from loop/blog.php
							ts_the_blog_list($blog_nums,'id',$blog_cat);
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
			
			<?php
			//End Blog Pages
			elseif($page_type == "portfolio"):
				$postfolio_nums = get_post_meta(get_the_ID(),'_page_portfolio_num',true);
				$postfolio_jqueryfilter = get_post_meta(get_the_ID(),'portfolio_filter',true);
				$postfolio_category = get_post_meta(get_the_ID(),'pages_portfolio_Category',true);
			?>
			<section id="content" class="span12">
				<div class="row">				
					<?php
						//Call from loop/blog.php
							ts_the_portfolio($postfolio_jqueryfilter,$postfolio_nums,'1',$postfolio_category,'DESC');
					?>
				</div>
			</section>
			<?php
			//End Portfolio Pages
			endif;
			?>
		</div>
	</div>
</section>
<?php
get_footer();
?>