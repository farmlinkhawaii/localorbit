<?php
	function ts_the_blog_list($sumpost=0,$sort="id",$category='All')
	{
		//$readmore="Read More &rarr;", $textcount=0, $sumpost=12,$sort="id"
		echo ts_get_blog_list($sumpost,$sort,$category);
	}
	/*
	ts_args :
		+ Category : All
		+ Author : All
		+ Archived : All
		+ Num : All
		+ Readmore text : "Read More &rarr;"
		+ Text Except
		+ Lightbox : False
	*/
	function ts_get_blog_list($sumpost=0,$sort="id",$category='All')
	{
		wp_enqueue_script('jquery.flexslider-min.js');
		wp_enqueue_script('greyScale.min.js');
		//$lightbox="false", $readmore="Read More &rarr;", $textcount=0, $sumpost=12,$sort="id",$category,$author,$
		if($sumpost == 0){
		$sumpost = get_option("posts_per_page");
		}
		$ts_args = array();
		 if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) { 
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if( is_author() ) {
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		}	
		//update_option("posts_per_page",$posts_per_page);

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $sumpost,
			'paged' => $paged,
			'orderby' => $sort, 
			'order'=>'ASC',			
		);
		if($category != 'All'):
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $sumpost,
				'paged' => $paged,
				'orderby' => $sort, 
				'order'=>'ASC',
				'cat'=>$category,
			);				
		endif;
		
		global $posts;
		global $wp_query;
		$query_args = array_merge( $wp_query->query, $args );
		
		if(is_page()){
		
		$posts=query_posts($args);	
		}else{
		
		$posts=query_posts($query_args);	
		}
		$sum_p =0;		
		$return='';
		/**/
		global $theme_options;
		if(have_posts()):
		while(have_posts()):the_post();
			$sum_p++;
			$ID = get_the_ID();

			$blog_type  	= 	get_post_meta($ID,'_blog_type',true);
			$blog_image 	=  	get_post_meta($ID,'_blog_image',true);
			$_blog_video_style 	=  	get_post_meta($ID,'_blog_video_thumb',true);
			$_blog_video_id 	=  	get_post_meta($ID,'_blog_video',true);
			$_blog_slider_id 	=  	get_post_meta($ID,'_blog_slider',true);
			$_blog_meta_enable 	=  	$theme_options["blog_meta_enable"];
			//tt_debug($_blog_meta_enable);
			$return .='	<article class="post entry">                    
                        <div class="visual">
                            ';
							if($blog_type == 'image'):					
									$return.=' <a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$blog_image.'&amp;h=293&amp;w=700&amp;zc=1" class="greyScale" alt=""></a>';
								//End Image Thumb
							elseif($blog_type == 'slider'):	
									$return.='
										<div class="flexslider">
											<ul class="slides">';
												$slider_id = $_blog_slider_id;
												$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
												$slider_num = 1;
												foreach($slider_metas as $slider_meta):
												$return.='<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$slider_meta["image"].'&amp;h=293&amp;w=700&amp;zc=1" class="greyScale" alt=""></a></li>';
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
								
			$return .='
                        </div>                                                
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
								
								$author = '<li>'.esc_html('Posted by:','TS').' <a href="'.get_author_posts_url(get_the_author_meta( 'ID' )).'">'.get_the_author_meta('nickname').'</a></li>';
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
                            <p>'.tt_excerpt($theme_options['blog_except_lenght']).'</p>
                            <div class="read-more"><a href="'.get_permalink().'">'.$theme_options['blog_readmore'].'</a></div>
                        </section>
						<div class="clearfix"></div>
                    </article>';
		endwhile;
		$return.=get_page_navi();
		else:
		$return .= '<div  id="page-404">
				    		<img src="'.THEMESTUDIO_IMG.'/404.png" alt="">
			    	        <p><strong>Ohh…</strong> You have requested the page that its no longer avaible</p>
                        </div>';
		endif;
		return $return;
	}
	/*
		$ts_args
			+ [List|Single]
			+ Lightbox
			+ Text Except
			+ Enable Comment
	*/
	function ts_get_single_blog($ts_args)
	{
		/*
		Load Meta For Blog
		*/
		$ID = get_the_ID();
		$blog_type  	= 	get_post_meta($ID,'_blog_type',true);
		$blog_image 	=  	get_post_meta($ID,'_blog_image',true);
		$_blog_video_style 	=  	get_post_meta($ID,'_blog_video_thumb',true);
		$_blog_video_id 	=  	get_post_meta($ID,'_blog_video',true);
		$_blog_slider_id 	=  	get_post_meta($ID,'_blog_slider',true);
		//$blog_except_lenght = ;
		if($ts_type = "Single")
		{
			
		}
		
	}
		
?>