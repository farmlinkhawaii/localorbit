<?php 
	global $body_id;
	$body_id = "template-blog-single";
	get_header();
	$sidebar 	=  	$theme_options["blog_single_sidebar"];	
	$blog_single_layout_1 = $theme_options["blog_single_layout_1"];	
	wp_enqueue_script('jquery.flexslider-min.js');
?>
<section id="body">
	<div class="container">
		<div class="row">
			<div id="content" class="span9">
<?php
		$return = '';	
		while (have_posts()) : the_post();
			$ID = get_the_ID();
			$blog_type  	= 	get_post_meta($ID,'_blog_type',true);
			$blog_image 	=  	get_post_meta($ID,'_blog_image',true);
			$_blog_video_style 	=  	get_post_meta($ID,'_blog_video_thumb',true);
			$_blog_video_id 	=  	get_post_meta($ID,'_blog_video',true);
			$_blog_slider_id 	=  	get_post_meta($ID,'_blog_slider',true);
			$_blog_meta_enable 	=  	$theme_options["blog_meta_enable"];
			
			
			//tt_debug($_blog_meta_enable);
			$return.='<article '.get_post_class("post entry").' ">                    
                        <div class="visual">
                            ';
							if($blog_type == 'image'):					
									$return.=' <a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$blog_image.'&amp;h=293&amp;&amp;zc=1" class="greyScale" alt=""></a>';
								//End Image Thumb
							elseif($blog_type == 'slider'):	
									$return.='
										<div class="flexslider">
											<ul class="slides">';
												$slider_id = $_blog_slider_id;
												$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
												$slider_num = 1;
												foreach($slider_metas as $slider_meta):
												$return.='<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$slider_meta["image"].'&amp;h=293&amp;&amp;zc=1" class="greyScale" alt=""></a></li>';
												endforeach;
									$return.='</ul>
										</div>';
								//End Video Thumb
							elseif($blog_type == 'video'):	
									$video_type = $_blog_video_style; 
									
									$video_id = $_blog_video_id;
									if($video_type == 'Youtube'):
										$return.='<iframe src="http://www.youtube.com/embed/'.$video_id.'" width="100%" height="293" frameborder="0" ></iframe>';
									else:
										$return.='<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="100%" height="293" frameborder="0"></iframe>';
									endif;
								
								endif;
								
			
            $return.='            </div>                                                
                        <header class="title">
                            <h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>
                        </header>
                        <footer class="meta">
                            <ul>
                                ';
								
								$times = '<li>Date: <a href="'.get_permalink().'">'.get_the_time('F j, Y').'</a> &nbsp;</li>';
								
			$return .=			$times	;			
			
								//Add Author Meta 
								if(in_array('author',$_blog_meta_enable)):
								
								$author = '<li>'.esc_html('Posted by:').' <a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('nickname').'</a></li>';
			$return .=			$author	;		
			
								endif;
								//End Author Meta
								//Add Comment Meta
								if(in_array('comments',$_blog_meta_enable)):
			$return.='		    <li><a href="'.get_permalink().'">'.get_comments_number(get_the_ID()).' Comments</a></li>';
								endif;
								//End Comment Meta
								/*
								Get Tags
								*/
								if(in_array('tags',$_blog_meta_enable)):
									$arr_tags = array();
									$tags = get_the_tags();
									$i = 0;
									if($tags != null):
										foreach($tags as $tag):
										$arr_tags[$i]='<a class="tag" href="'.get_tag_link($tag->term_id ).'">'.$tag->name.'</a>';
										$i++;
										endforeach;	
									endif;
									if($arr_tags != null):
										$return.= '<li>Tag : '.implode(",",$arr_tags).' &nbsp;</li>'; 
									endif;
								endif;
								/* End Tag Meta*/	
								/*
								Get Category
								*/
								if(in_array('tags',$_blog_meta_enable)):
									$arr_cats = array();
									$i=0;
									$cats = get_the_category(get_the_ID());
									foreach($cats as $cat):
										$arr_cats[$i]='<a  href="'.get_category_link($cat->cat_ID).'">'.$cat->cat_name.'</a>';
										$i++;
									endforeach;		
									if($arr_cats != null):
										$return.= '<li>Category : '.implode(",",$arr_cats).' &nbsp;</li>'; 
									endif;
								endif;
								/*
								End Category Meta
								*/
            $return .=		'</ul>
                        </footer>
                        <section class="body">
                            <p>'.do_shortcode(wpautop(get_the_content())).'</p>
						</section>
                    </article>';	
 endwhile; 
 echo $return;
 
 ?>
  <?php wp_link_pages( $args ); ?>
			<section id="comments">
				<?php comments_template(''); ?>
			</section>	
		</div>
			<aside id="page-sidebar" class="span3 sidebar">
			<?php			
							dynamic_sidebar($sidebar);
			?>
						
			</aside>		
		
		</div>
		
	</div>
</section>
<?php
get_footer();
?>