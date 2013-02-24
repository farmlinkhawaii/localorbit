<?php
	function ts_the_portfolio($filter = '1',$sum_post='10',$paged='1',$postfolio_category='All',$order='DESC'){
	
		echo ts_get_portfolio($filter,$sum_post,$paged,$postfolio_category,$order);
	
	}
	function ts_get_portfolio($filter = '1',$sum_post='10',$paged='1',$postfolio_category='All',$order='DESC')
	{
		wp_enqueue_script('jquery.flexslider-min.js');
		wp_enqueue_script('greyScale.min.js');
		$types_arr=array();
		$types=get_terms('portfolio-category');
		$num=0;		
		$return='';
		if($filter == '1'):
						$return.=
						'<nav class="span12" id="filter">
							<ul>
								<li><a class="active" href="#">All</a></li>
	                        	';
								if($types) :
								   foreach($types as $type):
										$types_arr[$num]='<li><a  href="#'.str_replace(' ','-',$type->name).'" >'.$type->name.'</a></li>'."\n";
										$return.= $types_arr[$num];
										$num++;
										
								   endforeach;
								endif;
	                     $return.=   
							'</ul>
                        </nav>';
		endif;
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $sum_post,
			'paged' => $paged,
			'order' => $order, 
		);
		if($postfolio_category != 'All'):
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $sum_post,
			'paged' => $paged,
			'order' => $order, 
			'portfolio-category' =>$postfolio_category,
		);
		endif;
		//tt_debug($args);
		query_posts($args);
		$return.='
                        
                        <section  class="span12" id="portfolio-container" >';
		$sum_p =0;		
 
		while(have_posts()):the_post();
			$sum_p++;
			$w=313;
			$liked = get_option('like'.get_the_ID());
			if($liked == ''){ $liked = '0';};
			$viewed = get_option('view'.get_the_ID());
			if($viewed == ''){ $viewed = '0';};
			
			if(get_post_meta(get_the_ID(),'portfolio_thumb_width',true) == 'one-third'):
				$w=313;
			elseif(get_post_meta(get_the_ID(),'portfolio_thumb_width',true) == 'two-third'):
				$w=626;
			elseif(get_post_meta(get_the_ID(),'portfolio_thumb_width',true) == 'three-third'):
				$w=939;
			endif;
			 $types =get_the_terms(get_the_ID(), 'portfolio-category');
			  $type_single_arr = array();
			  $i = 0;
			  if($types)
			  {
			  foreach($types as $type):
			   $type_single_arr[$i] =  $type->name;
			   $i++;
			  endforeach;
			  }
			$return.='          
							<dl class="'.get_post_meta(get_the_ID(),'portfolio_thumb_width',true).' c'.$sum_p.'" data-work="'.implode($type_single_arr,',').'">
                                <dt>';
								if(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'image'):					
									$return.=' <a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.get_post_meta(get_the_ID(),'_portfolio_image',true).'&amp;h=190&amp;w='.$w.'&amp;zc=1" class="greyScale" alt=""></a>';
								//End Image Thumb
								elseif(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'slider'):	
									$return.='
										<div class="flexslider">
											<ul class="slides">';
												$slider_id = get_post_meta(get_the_ID(),'_portfolio_slider',true);
												$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
												$slider_num = 1;
												if($slider_metas != null):
													foreach($slider_metas as $slider_meta):
													$return.='<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$slider_meta["image"].'&amp;h=190&amp;w='.$w.'&amp;zc=1" class="greyScale" alt=""></a></li>';
													endforeach;
												endif;
									$return.='</ul>
										</div>';
								//End Video Thumb
								elseif(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'video'):	
									$video_type = get_post_meta(get_the_ID(),'_portfolio_video_thumb',true);
									$video_thumb = get_post_meta(get_the_ID(),'_portfolio_video_thumb',true);
									$video_id = get_post_meta(get_the_ID(),'_portfolio_video',true);
									if($video_thumb == 'Youtube'):
										$return.='<iframe src="http://www.youtube.com/embed/'.$video_id.'" width="100%" height="185" frameborder="0" ></iframe>';
									else:
										$return.='<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="100%" height="185" frameborder="0"></iframe>';
									endif;
								
								endif;
								
			$return.='          </dt>
                                <dd>
                                    <footer>
                                        <span  class="tsview" id="view-'.get_the_ID().'">'.$viewed.'</span>
										<span  class="tslike" id="like-'.get_the_ID().'">'.$liked.'</span>
                                    </footer>
                                    <h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
                                </dd>
                            </dl>';			
		endwhile;
        $return.='           </section>';
			return $return;
	}
	
	function ts_the_portfolio_by_type($title='Featured Works',$sum_post='3',$postfolio_category='All',$order='DESC',$type='none'){
		echo ts_get_portfolio_by_type($title,$sum_post,$postfolio_category,$order,$type);
	}
	//Type : 
	// Recent : order by : time
	// Popular : Order by : comment_count
	// Feature : Order by : 
	function ts_get_portfolio_by_type($title = 'Featured Works',$sum_post='3',$postfolio_category='All',$order='DESC',$type='none')
	{
	
		$types_arr=array();
		$types=get_terms('portfolio-category');
		$num=0;		
		$return='';
		$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $sum_post,
				'order' => $order, 
				'ORDER BY' => 'time'
			);
		if($type == 'none'):
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $sum_post,
				'order' => $order, 
				'ORDER BY' => 'time'
			);
		elseif($type == 'recent'):
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $sum_post,

				'order' => $order, 
				'ORDER BY' => 'time'
			);
		elseif($type == 'popular'):
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $sum_post,
				'order' => $order, 
				'ORDER BY' => 'comment_count'
			);
			
		endif;
		if($postfolio_category != 'All'):
		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $sum_post,
			'order' => $order, 
			'portfolio-category' =>$postfolio_category,
		);
		endif;
		//tt_debug($args);
		query_posts($args);
		$return.='
                        
                        <div id="other-projects">
	                        <h3 class="span12">'.$title.'</h3><section class="span12" id="portfolio-container">';
		$sum_p =0;		
		$w="313";
		while(have_posts()):the_post();
			$sum_p++;
 			  $types =get_the_terms(get_the_ID(), 'portfolio-category');
			  $type_single_arr = array();
			  $i = 0;
			  $liked = get_option('like'.get_the_ID());
			if($liked == ''){ $liked = '0';};
			$viewed = get_option('view'.get_the_ID());
			if($viewed == ''){ $viewed = '0';};
			  if($types)
			  {
			  foreach($types as $type):
			   $type_single_arr[$i] =  $type->name;
			   $i++;
			  endforeach;
			  }
			$return.='          
							<dl class="one-third c'.$sum_p.'" data-work="'.implode($type_single_arr,',').'">
                                <dt>';
								if(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'image'):					
									$return.=' <a href="'.get_permalink().'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.get_post_meta(get_the_ID(),'_portfolio_image',true).'&h=190&w=313&zc=1" class="greyScale" alt=""></a>';
								//End Image Thumb
								elseif(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'slider'):	
									$return.='
										<div class="flexslider">
											<ul class="slides">';
												$slider_id = get_post_meta(get_the_ID(),'_portfolio_slider',true);
												$slider_metas = get_post_meta($slider_id,'_slider_slider',true);
												$slider_num = 1;
												foreach($slider_metas as $slider_meta):
												$return.='<li><a href="#"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$slider_meta["image"].'&h=190&w=313&zc=1" class="greyScale" alt=""></a></li>';
												endforeach;
									$return.='</ul>
										</div>';
								//End Video Thumb
								elseif(get_post_meta(get_the_ID(),'_portfolio_type',true) == 'video'):	
									$video_type = get_post_meta(get_the_ID(),'_portfolio_video_thumb',true);
									$video_thumb = get_post_meta(get_the_ID(),'_portfolio_video_thumb',true);
									$video_id = get_post_meta(get_the_ID(),'_portfolio_video',true);
									if($video_thumb == 'Youtube'):
										$return.='<iframe src="http://www.youtube.com/embed/'.$video_id.'" width="100%" height="185" frameborder="0" ></iframe>';
									else:
										$return.='<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="100%" height="185" frameborder="0"></iframe>';
									endif;
								
								endif;
								
			$return.='          </dt>
                                <dd>
                                    <footer>
                                        <span  class="tsview" id="view-'.get_the_ID().'">'.$viewed.'</span>
										<span  class="tslike" id="like-'.get_the_ID().'">'.$liked.'</span>
                                    </footer>
                                    <h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
                                </dd>
                            </dl>';			
		endwhile;
        $return.='           </section></div>';
			return $return;
	}
?>