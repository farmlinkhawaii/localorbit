<?php 
	global $body_id;
	$body_id = "template-portfolio";
	get_header();
	$sidebar 	=  	$theme_options["blog_single_sidebar"];	
	$blog_single_layout_1 = $theme_options["blog_single_layout_1"];	
	wp_enqueue_script('jquery.flexslider-min.js');
?>
<section id="body">
	<div class="container">
		<div class="row">
			<div id="content" class="span12">
					<div class="row">
<?php
					while (have_posts()) : the_post();	
					
					
					$ID = get_the_ID();
					
					if(get_option('view'.get_the_ID()) != ''):
						$view = get_option('view'.get_the_ID())+1;
						update_option('view'.get_the_ID(),$view);
					else:
						add_option('view'.get_the_ID(),'1');
					endif;
					
					$_portfolio_type  	= 	get_post_meta($ID,'_portfolio_type',true);
					$_portfolio_image 	=  	get_post_meta($ID,'_portfolio_image',true);
					$_portfolio_video 	=  	get_post_meta($ID,'_portfolio_video',true);
					$_portfolio_video_thumb 	=  	get_post_meta($ID,'_portfolio_video_thumb',true);
					$_portfolio_slider 	=  	get_post_meta($ID,'_portfolio_slider',true);
?>                	
                        <nav class="span12" id="filter1">
	                        <ul>
	                        	<li><?php echo previous_post_link('%link'); ?></li>
	                        	<li><a href="<?php global $theme_options; if(isset($theme_options["portfolio_list_url"])){ echo $theme_options["portfolio_list_url"];} ?>">All</a></li>
	                        	<li><?php echo next_post_link('%link'); ?></li>
	                        </ul>
                        </nav>
                        
                        <article id="portfolio-item" class="span12">
                            <?php
							if($_portfolio_type == 'image'):					
							?>
									<a href="<?php echo get_permalink(); ?>"><img src="<?php echo get_stylesheet_directory_uri().'/timthumb.php?src='.$_portfolio_image; ?>&amp;h=410&amp;&amp;zc=1" alt=""></a>
							<?php
							elseif($_portfolio_type == 'slider'):	
									?>
										<div class="flexslider">
											<ul class="slides">
									<?php
												$slider_id = $_portfolio_slider;
												$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
												$slider_num = 1;
												foreach($slider_metas as $slider_meta):
									?>
									
													<li><a href="#"><img src="<?php echo get_stylesheet_directory_uri()."/timthumb.php?src=".$slider_meta["image"]; ?>&amp;h=410&amp;&amp;zc=1" class="" alt=""></a></li>
									<?php
												endforeach;
									?>
											</ul>
										</div>
									<?php	
								//End Video Thumb
							elseif($_portfolio_type == 'video'):	
									$video_type = $_portfolio_video_thumb; 
									
									$video_id = $_portfolio_video;
									if($video_type == 'Youtube'):
									?>
										<iframe src="http://www.youtube.com/embed/<?php echo $video_id; ?>" width="100%" height="293" frameborder="0" ></iframe>
									<?php
									else:
									?>
										<iframe src="http://player.vimeo.com/video/<?php echo $video_id; ?>" width="100%" height="293" frameborder="0"></iframe>
									<?php
									endif;
									
								endif;
							
							?>							
                        	<h1 id="project-title"><?php the_title(); ?></h1>
                            
                            	<?php the_content();?>
                            
                            <a href="<?php echo get_post_meta(get_the_ID(),'_portfolio_website',true); ?>" class="button-big pull-right">Launch Project</a>
                        </article>
<?php
					endwhile;
?>  
                        
                        
                        <?php
						if(get_post_meta(get_the_ID(),'_portfolio_enable_feature')):
						?>
						<div class="span12">
                        	<div class="divider"></div>
                        </div>
						<?php
							// Dat lai tham so
							ts_the_portfolio_by_type();
						endif;
						?>
                        
                    </div>
					<!-- End Content -->
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
?>