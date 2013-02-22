<?php
function get_dynamic_sidebar($index = 1)
{
$sidebar_contents = "";
ob_start();
dynamic_sidebar($index);
$sidebar_contents = ob_get_clean();
return $sidebar_contents;
} 
/**
*	Custom function to get current URL
**/
function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE,
		'instance' => '',
    ), $atts));
    
    $widget_name = esc_html($widget_name);
    //$instance = str_ireplace("&amp;", '&' ,$instance);
    if (!is_a($wp_widget_factory->widgets[$widget_name], 'WP_Widget')):
        $wp_class = 'WP_Widget_'.ucwords(strtolower($class));
        
        if (!is_a($wp_widget_factory->widgets[$wp_class], 'WP_Widget')):
            return '<p>'.sprintf(__("%s: Widget class not found. Make sure this widget exists and the class name is correct"),'<strong>'.$class.'</strong>').'</p>';
        else:
            $class = $wp_class;
        endif;
    endif;
    
    ob_start();
    the_widget($widget_name, $instance);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','widget'); 

function curPageURL() {
 	$pageURL = 'http';
 	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 	$pageURL .= "://";
 	if ($_SERVER["SERVER_PORT"] != "80") {
 	 $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 	} else {
 	 $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 	}
 	return $pageURL;
}
    
function tt_debug($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

function gen_pagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=10) 
{ 
    if(!$total OR !$currentPage OR !$baseLink) 
    { 
        return false; 
    } 

    //Total Number of pages 
    $totalPages = ceil($total/$limit); 
     
    //Text to use after number of pages 
    //$txtPagesAfter = ($totalPages==1)? " page": " pages"; 
     
    //Start off the list. 
    //$txtPageList = '<br />'.$totalPages.$txtPagesAfter.' : <br />'; 
     
    //Show only 3 pages before current page(so that we don't have too many pages) 
    $min = ($page - 3 < $totalPages && $currentPage-3 > 0) ? $currentPage-3 : 1; 
     
    //Show only 3 pages after current page(so that we don't have too many pages) 
    $max = ($page + 3 > $totalPages) ? $totalPages : $currentPage+3; 
     
    //Variable for the actual page links 
    $pageLinks = ""; 
    
    $baseLinkArr = parse_url($baseLink);
    $start = '';
    
    if(isset($baseLinkArr['query']) && !empty($baseLinkArr['query']))
    {
    	$start = '&';
    }
    else
    {
    	$start = '?';
    }
     
    //Loop to generate the page links 
    for($i=$min;$i<=$max;$i++) 
    { 
        if($currentPage==$i) 
        { 
            //Current Page 
            $pageLinks .= '<a href="#" class="active">'.$i.'</a>';  
        } 
        elseif($max <= $totalPages OR $i <= $totalPages) 
        { 
            $pageLinks .= '<a href="'.$baseLink.$start.'page='.$i.'" class="slide">'.$i.'</a>'; 
        } 
    } 
     
    if($nextPrev) 
    { 
        //Next and previous links 
        $next = ($currentPage + 1 > $totalPages) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage + 1).'" class="slide">'._e( 'Next', 'TT' ).'</a>'; 
         
        $prev = ($currentPage - 1 <= 0 ) ? false : '<a href="'.$baseLink.$start.'page='.($currentPage - 1).'" class="slide">'._e( 'Previous', 'TT' ).'</a>'; 
    } 
     
    if($totalPages > 1)
    {
    	return '<br class="clear"/><div class="pagination">'.$txtPageList.$prev.$pageLinks.$next.'</div>'; 
    }
    else
    {
    	return '';
    }
     
} 

function count_shortcode($content = '')
{
	$return = array();
	
	if(!empty($content))
	{
		$pattern = get_shortcode_regex();
    	$count = preg_match_all('/'.$pattern.'/s', $content, $matches);
    	
    	$return['total'] = $count;
    	
    	if(isset($matches[0]))
    	{
    		foreach($matches[0] as $match)
    		{
    			$return['content'][] = substr_replace($match ,"",-1);
    		}
    	}
	}
	
	return $return;
}

function dimox_breadcrumbs($delimiter='/') {
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<p id="crumbs">';
    global $post;
    $homeLink = home_url();
    echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        echo $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        echo $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      echo $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $before . 'Articles posted by ' . $userdata->display_name . $after;
    } elseif ( is_404() ) {
      echo $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page','TT') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</p>';
 
  }
} // end dimox_breadcrumbs()   
function get_dimox_breadcrumbs($delimiter='/') {
  $home = 'Home'; // text for the 'Home' link
  $before = '<span class="current">'; // tag before the current crumb
  $after = '</span>'; // tag after the current crumb
  $return =''; 
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    $return .= '';
    global $post;
    $homeLink = home_url();
    $return .= '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) $return .=(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      $return .= $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
 
    } elseif ( is_day() ) {
      $return .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $return .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      $return .= $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      $return .= '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $return .= $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      $return .= $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        $return .= '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
        $return .= $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $return .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        $return .= $before . get_the_title() . $after;
      }
 
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      $return .= $before . $post_type->labels->singular_name . $after;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      $return .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      $return .= '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      $return .= $before . get_the_title() . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      $return .= $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) $return .= $crumb . ' ' . $delimiter . ' ';
      $return .= $before . get_the_title() . $after;
 
    } elseif ( is_search() ) {
      $return .= $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      $return .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      $return .= $before . 'Articles posted by ' . $userdata->display_name . $after;
    } elseif ( is_404() ) {
      $return .= $before . 'Error 404' . $after;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $return .= ' (';
      $return .= __('Page','TT') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $return .= ')';
    }
 
    $return .= '';
 
  }
	return $return;
} // end dimox_breadcrumbs()   
/**
*	Setup blog comment style
**/
          function tt_comment($comment, $args, $depth) 
          {
          	$GLOBALS['comment'] = $comment; 
			$avatar = get_avatar($comment,50);    
          ?>
                     		  <dl class="comment">
							   
	                                <dt>
	                                   <?php echo $avatar; ?>
	                                    <ul>
	                                        <?php
          				if(!empty($comment->comment_author_url))
          				{ ?>
                            
						<li class="author"><a href="<?php echo $comment->comment_author_url; ?>" class="comment_name"><?php echo $comment->comment_author; ?></a><li>
						<li>Posted on: <a href="<?php echo get_permalink(); ?>"><?php echo tt_ago(strtotime($comment->comment_date)); ?></a></li>
          				</dt><dd><?php comment_text(); ?></dd>
						   		  <?php if($depth < 3):
                                		?>
                          			  	 
                                           	   <?php comment_reply_link(array_merge( $args, array('depth' => $depth,
                                          	   'reply_text' => 'Reply', 'login_text' => esc_html__('Log in to reply to this','TT'), 'max_depth' => $args['max_depth'], $comment->comment_ID)));
          									   ?>
                                           
                                       <?php
          						   endif
                                       ?>
              						</dl>			 
                        				<?php
                        				}
                        				else
                        				{
              						?>
						<li class="author"><a href="<?php echo $comment->comment_author_url; ?>" class="comment_name"><?php echo $comment->comment_author; ?></a><li>
						<li>Posted on: <a href="<?php echo get_permalink(); ?>"><?php echo tt_ago(strtotime($comment->comment_date)); ?></a></li>
          				</dt><dd><?php comment_text(); ?></dd>	   		  
						<?php if($depth < 3):
                                              		?>
                                        			  	 
                                                         	   <?php comment_reply_link(array_merge( $args, array('depth' => $depth,
                                                        	   'reply_text' => 'Reply', 'login_text' => esc_html__('Log in to reply to this','TT'), 'max_depth' => $args['max_depth'], $comment->comment_ID)));
                        									   ?>
                                                         
                                                     <?php
                        						   endif
                                                     ?>
              						</dl>	
                            			<?php
              						}
                            			?>
	                              
<?php } 
function tt_ago($timestamp){
   $difference = time() - $timestamp;
   $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
   $lengths = array("60","60","24","7","4.35","12","10");
   for($j = 0; $difference >= $lengths[$j]; $j++)
   $difference /= $lengths[$j];
   $difference = round($difference);
   if($difference != 1) $periods[$j].= "s";
   $text = "$difference $periods[$j] ago";
   return $text;
}



// Substring without losing word meaning and
// tiny words (length 3 by default) are included on the result.
// "..." is added if result do not reach original string length

function tt_substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}


/**
*	Setup recent posts widget
**/
function tt_tabsposts($items = 3, $echo = TRUE, $bg_color = 'black' , $echo_title = TRUE) 
{
	$return_html = '';
	
		$posts1 = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish');
		global $wpdb;
		$query = "SELECT ID, post_title, post_content, post_date FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0,".$items;
		$posts2 = $wpdb->get_results($query);

	if(!empty($posts1) && !empty($posts2))
	{

		$return_html.= '<ul class="nav nav-tabs">
    		<li class="active">
            <a data-toggle="tab" href="#recent">Recent</a>
            </li>
            <li class="">
            <a data-toggle="tab" href="#popular">Popular</a>
            </li>
		</ul>
		<div class="tab-content">
			 <div id="recent" class="tab-pane active">';
			 
			foreach($posts1 as $post)
			{
			    $return_html.= '<dl>';
				$image_thumb = '';
								
				if(has_post_thumbnail($post->ID))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
				}
				
				$return_html.= '<dt>';
				if(!empty($image_thumb))
				{
					$return_html.= '
								   <a href="'.get_permalink($post->ID).'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$image_thumb[0].'&amp;h=55&amp;w=55&amp;zc=1" alt="" class=""/></a>
								  ';
				}
				$return_html.= '</dt><dd>
				'.$post->post_title;
				
				
				$return_html.= '<a href="'.get_permalink($post->ID).'"><p>'.date('F j, Y', strtotime($post->post_date)).'</p></a></dd>';
				$return_html.= '</dl>';
			}
				
		$return_html.= '</div>
		 <div id="popular" class="tab-pane">';
			 
			foreach($posts2 as $post)
			{
			    $return_html.= '<dl>';
				$image_thumb = '';
								
				if(has_post_thumbnail($post->ID))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
				}
				
				$return_html.= '<dt>';
				if(!empty($image_thumb))
				{
					$return_html.= '
								   <a href="'.get_permalink($post->ID).'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$image_thumb[0].'&amp;h=55&amp;w=55&amp;zc=1" alt="" class=""/></a>
								  ';
				}
				$return_html.= '</dt><dd>
				'.$post->post_title;
				
				
				$return_html.= '<a href="'.get_permalink($post->ID).'"><p>'.date('F j, Y', strtotime($post->post_date)).'</p></a></dd>';
				$return_html.= '</dl>';
			}
				
		$return_html.= '</div>';	
		
		$return_html.= '</div><div class="clearfix"></div>';

	}
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}
/**
*	Setup recent posts widget
**/
function tt_posts($sort = 'recent', $items = 3, $echo = TRUE, $bg_color = 'black' , $echo_title = TRUE) 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish');
		$title = esc_html__('Recent Posts', 'TT');
	}
	else
	{
		global $wpdb;
		
		$query = "SELECT ID, post_title, post_content, post_date FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0,".$items;
		$posts = $wpdb->get_results($query);
		$title = esc_html__('Popular Posts', 'TT'); 
	}
	
	if(!empty($posts))
	{
		if($echo_title)
		{
			$return_html.= '<h3 class="widget-title">'.$title.'</h3>';
		}
		
		$return_html.= '<ul class="wg-post">';

			foreach($posts as $post)
			{
				$image_thumb = '';
								
				if(has_post_thumbnail($post->ID))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
				}
				
				$return_html.= '<li>';
				if(!empty($image_thumb))
				{
					$return_html.= '<div style="float:left;">
								   <a href="'.get_permalink($post->ID).'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$image_thumb[0].'&amp;h=55&amp;w=55&amp;zc=1" alt="" class=""/></a>
								   </div>';
				}
				$return_html.= '<div class="recent_txt">
				'.$post->post_title;
				
				
				$return_html.= '<p><a href="'.get_permalink($post->ID).'">'.date('F j, Y', strtotime($post->post_date)).'</a></p></div><div class="clearfix"></div></li>';

			}	

		$return_html.= '</ul><div class="clearfix"></div>';

	}
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function tt_posts_2($sort = 'recent', $items = 3, $echo = TRUE, $bg_color = 'black' , $echo_title = TRUE) 
{
	$return_html = '';
	
	if($sort == 'recent')
	{
		$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&post_type=post&post_status=publish');
		$title = esc_html__('Recent Posts', 'TT');
	}
	else
	{
		global $wpdb;
		
		$query = "SELECT ID, post_title, post_content, post_date FROM {$wpdb->prefix}posts WHERE post_type = 'post' AND post_status= 'publish' ORDER BY comment_count DESC LIMIT 0,".$items;
		$posts = $wpdb->get_results($query);
		$title = esc_html__('Popular Posts', 'TT'); 
	}
	
	if(!empty($posts))
	{
		if($echo_title)
		{
			$return_html.= '<h3 class="widget-title">'.$title.'</h3>';
		}
		
		$return_html.= '<ul class="latest_posts">';

			foreach($posts as $post)
			{
				$image_thumb = '';
								
				if(has_post_thumbnail($post->ID))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'full', true);
				}
				
				$return_html.= '<li>';
				$return_html.='<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
				$return_html.= '</li>';

			}	

		$return_html.= '</ul>';

	}
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}


function tt_cat_posts($cat_id = '', $items = 5, $echo = TRUE) 
{
	$return_html = '';
	$posts = get_posts('numberposts='.$items.'&order=DESC&orderby=date&category='.$cat_id);
	$title = get_cat_name($cat_id);
	$category_link = get_category_link($cat_id);
	$count_post = count($posts);
	
	if(!empty($posts))
	{

		$return_html.= '<h3 class="widget-title">'.$title.'</h3>';
		$return_html.= '<ul class="wg-post">';

			foreach($posts as $post)
			{
				$image_thumb = '';
								
				if(has_post_thumbnail($post->ID))
				{
				    $image_id = get_post_thumbnail_id($post->ID);
				    $image_thumb = wp_get_attachment_image_src($image_id, 'size-57-57', true);
				}
				
				$return_html.= '<li>';
				if(!empty($image_thumb))
				{
					$return_html.= '<div style="float:left;">
								   <a href="'.get_permalink($post->ID).'"><img src="'.get_stylesheet_directory_uri().'/timthumb.php?src='.$image_thumb[0].'&amp;h=55&amp;w=55&amp;zc=1" alt="" class=""/></a>
								   </div>';
				}
				$return_html.= '<div class="recent_txt">
				'.$post->post_title;
				
				
				$return_html.= '<p><a href="'.get_permalink($post->ID).'">'.date('F j, Y', strtotime($post->post_date)).'</a></p></div><div class="clearfix"></div></li>';

			}	

		$return_html.= '</ul>';

	}
	
	if($echo)
	{
		echo $return_html;
	}
	else
	{
		return $return_html;
	}
}

function _substr($str, $length, $minword = 3)
{
    $sub = '';
    $len = 0;
    
    foreach (explode(' ', $str) as $word)
    {
        $part = (($sub != '') ? ' ' : '') . $word;
        $sub .= $part;
        $len += strlen($part);
        
        if (strlen($word) > $minword && strlen($sub) >= $length)
        {
            break;
        }
    }
    
    return $sub . (($len < strlen($str)) ? '...' : '');
}
function get_the_content_with_formatting ($chars = 560, $stripteaser = 0, $more_file = '') {

	$content = get_the_content('', $stripteaser, $more_file);
	$content = strip_shortcodes($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$content = _substr(strip_tags(strip_shortcodes($content)), $chars);
	if($more_file <> '')
	{ 
	$content.= '<br/><a href="'.get_permalink().'">'.$more_file.'</a><br/>';
	}
	return $content;
}

function image_from_description($data) {
    preg_match_all('/<img src="([^"]*)"([^>]*)>/i', $data, $matches);
    return $matches[1][0];
}



function select_image($img, $size) {
    $img = explode('/', $img);
    $filename = array_pop($img);

    // The sizes listed here are the ones Flickr provides by default.  Pass the array index in the

    // 0 for square, 1 for thumb, 2 for small, etc.
    $s = array(
        '_s.', // square
        '_t.', // thumb
        '_m.', // small
        '.',   // medium
        '_b.'  // large
    );

    $img[] = preg_replace('/(_(s|t|m|b))?\./i', $s[$size], $filename);
    return implode('/', $img);
}



function get_flickr($settings) {
	if (!function_exists('MagpieRSS')) {
	    // Check if another plugin is using RSS, may not work
	    include_once (ABSPATH . WPINC . '/class-simplepie.php');
	    error_reporting(E_ERROR);
	}
	
	if(!isset($settings['items']) || empty($settings['items']))
	{
		$settings['items'] = 9;
	}
	
	// get the feeds
	if ($settings['type'] == "user") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?id=' . $settings['id'] . '&tags=' . $settings['tags'] . '&per_page='.$settings['items'].'&format=rss_200'; }
	elseif ($settings['type'] == "favorite") { $rss_url = 'http://api.flickr.com/services/feeds/photos_faves.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "set") { $rss_url = 'http://api.flickr.com/services/feeds/photoset.gne?set=' . $settings['set'] . '&nsid=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "group") { $rss_url = 'http://api.flickr.com/services/feeds/groups_pool.gne?id=' . $settings['id'] . '&format=rss_200'; }
	elseif ($settings['type'] == "public" || $settings['type'] == "community") { $rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?tags=' . $settings['tags'] . '&format=rss_200'; }
	else {
	    print '<strong>No "type" parameter has been setup. Check your settings, or provide the parameter as an argument.</strong>';
	    die();
	}
	# get rss file
	
	$feed = new SimplePie($rss_url);
	$photos_arr = array();
	
	foreach ($feed->get_items() as $key => $item)
	{
	    $enclosure = $item->get_enclosure();
	    $img = image_from_description($item->get_description()); 
	    $thumb_url = select_image($img, 0);
	    $large_url = select_image($img, 4);
	    
	    $photos_arr[] = array(
	    	'title' => $enclosure->get_title(),
	    	'thumb_url' => $thumb_url,
	    	'url' => $large_url,
	    );
	    
	    $current = intval($key+1);
	    
	    if($current == $settings['items'])
	    {
	    	break;
	    }
	} 

	return $photos_arr;
}
function html2rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}
function hex_lighter($hex,$factor = 30) 
    { 
    $new_hex = ''; 
     
    $base['R'] = hexdec($hex{0}.$hex{1}); 
    $base['G'] = hexdec($hex{2}.$hex{3}); 
    $base['B'] = hexdec($hex{4}.$hex{5}); 
     
    foreach ($base as $k => $v) 
        { 
        $amount = 255 - $v; 
        $amount = $amount / 100; 
        $amount = round($amount * $factor); 
        $new_decimal = $v + $amount; 
     
        $new_hex_component = dechex($new_decimal); 
        if(strlen($new_hex_component) < 2) 
            { $new_hex_component = "0".$new_hex_component; } 
        $new_hex .= $new_hex_component; 
        } 
         
    return $new_hex;     
} 
function hex_darker($hex,$factor = 30)
{
        $new_hex = '';
        
        $base['R'] = hexdec($hex{0}.$hex{1});
        $base['G'] = hexdec($hex{2}.$hex{3});
        $base['B'] = hexdec($hex{4}.$hex{5});
        
        foreach ($base as $k => $v)
                {
                $amount = $v / 100;
                $amount = round($amount * $factor);
                $new_decimal = $v - $amount;
        
                $new_hex_component = dechex($new_decimal);
                if(strlen($new_hex_component) < 2)
                        { $new_hex_component = "0".$new_hex_component; }
                $new_hex .= $new_hex_component;
                }
                
        return $new_hex;        
}

function XML2Array ( $xml , $recursive = false )
{
    if ( ! $recursive )
    {
        $array = simplexml_load_string ( $xml ) ;
    }
    else
    {
        $array = $xml ;
    }
    
    $newArray = array () ;
    $array = ( array ) $array ;
    foreach ( $array as $key => $value )
    {
        $value = ( array ) $value ;
        if ( isset ( $value [ 0 ] ) )
        {
            $newArray [ $key ] = trim ( $value [ 0 ] ) ;
        }
        else
        {
            $newArray [ $key ] = XML2Array ( $value , true ) ;
        }
    }
    return $newArray ;
}

/**
     * Converts a simpleXML element into an array. Preserves attributes and everything.
     * You can choose to get your elements either flattened, or stored in a custom index that
     * you define.
     * For example, for a given element
     * <field name="someName" type="someType"/>
     * if you choose to flatten attributes, you would get:
     * $array['field']['name'] = 'someName';
     * $array['field']['type'] = 'someType';
     * If you choose not to flatten, you get:
     * $array['field']['@attributes']['name'] = 'someName';
     * _____________________________________
     * Repeating fields are stored in indexed arrays. so for a markup such as:
     * <parent>
     * <child>a</child>
     * <child>b</child>
     * <child>c</child>
     * </parent>
     * you array would be:
     * $array['parent']['child'][0] = 'a';
     * $array['parent']['child'][1] = 'b';
     * ...And so on.
     * _____________________________________
     * @param simpleXMLElement $xml the XML to convert
     * @param boolean $flattenValues    Choose wether to flatten values
     *                                    or to set them under a particular index.
     *                                    defaults to true;
     * @param boolean $flattenAttributes Choose wether to flatten attributes
     *                                    or to set them under a particular index.
     *                                    Defaults to true;
     * @param boolean $flattenChildren    Choose wether to flatten children
     *                                    or to set them under a particular index.
     *                                    Defaults to true;
     * @param string $valueKey            index for values, in case $flattenValues was set to
            *                            false. Defaults to "@value"
     * @param string $attributesKey        index for attributes, in case $flattenAttributes was set to
            *                            false. Defaults to "@attributes"
     * @param string $childrenKey        index for children, in case $flattenChildren was set to
            *                            false. Defaults to "@children"
     * @return array the resulting array.
     */
    function simpleXMLToArray($xml, 
                    $flattenValues=true,
                    $flattenAttributes = true,
                    $flattenChildren=true,
                    $valueKey='@value',
                    $attributesKey='@attributes',
                    $childrenKey='@children'){

        $return = array();
        if(!($xml instanceof SimpleXMLElement)){return $return;}
        $name = $xml->getName();
        $_value = trim((string)$xml);
        if(strlen($_value)==0){$_value = null;};

        if($_value!==null){
            if(!$flattenValues){$return[$valueKey] = $_value;}
            else{$return = $_value;}
        }

        $children = array();
        $first = true;
        foreach($xml->children() as $elementName => $child){
            $value = simpleXMLToArray($child, $flattenValues, $flattenAttributes, $flattenChildren, $valueKey, $attributesKey, $childrenKey);
            if(isset($children[$elementName])){
                if($first){
                    $temp = $children[$elementName];
                    unset($children[$elementName]);
                    $children[$elementName][] = $temp;
                    $first=false;
                }
                $children[$elementName][] = $value;
            }
            else{
                $children[$elementName] = $value;
            }
        }
        if(count($children)>0){
            if(!$flattenChildren){$return[$childrenKey] = $children;}
            else{$return = array_merge($return,$children);}
        }

        $attributes = array();
        foreach($xml->attributes() as $name=>$value){
            $attributes[$name] = trim($value);
        }
        if(count($attributes)>0){
            if(!$flattenAttributes){$return[$attributesKey] = $attributes;}
            else{$return = array_merge($return, $attributes);}
        }
        
        return $return;
    }

function theme_queue_js(){
  if (!is_admin()){
    if (!is_page() AND is_singular() AND comments_open() ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}
add_action('get_header', 'theme_queue_js');

function in_subcat($blogcat,$current_cat='') {
	$in_subcategory = false;
	
	if (cat_is_ancestor_of($blogcat,$current_cat) || $blogcat == $current_cat) $in_subcategory = true;
		
    return $in_subcategory;
}


function show_page_menu($customClass = 'nav clearfix', $addUlContainer = true, $addHomeLink = true){
	global $shortname, $themename, $exclude_pages, $strdepth, $page_menu, $is_footer;
	
	//excluded pages
	if (get_option($shortname.'_menupages') <> '') $exclude_pages = implode(",", get_option($shortname.'_menupages'));
	
	//dropdown for pages
	$strdepth = '';
	if (get_option($shortname.'_enable_dropdowns') == 'on') $strdepth = "depth=".get_option($shortname.'_tiers_shown_pages');
	if ($strdepth == '') $strdepth = "depth=1";
	
	if ($is_footer) { $strdepth="depth=1"; $strdepth2 = $strdepth; }
	
	$page_menu = wp_list_pages("sort_column=".get_option($shortname.'_sort_pages')."&sort_order=".get_option($shortname.'_order_page')."&".$strdepth."&exclude=".$exclude_pages."&title_li=&echo=0");
	
	if ($addUlContainer) echo('<ul class="'.$customClass.'">');
		if (get_option($shortname . '_home_link') == 'on' && $addHomeLink) { ?> 
			<li <?php if (is_front_page() || is_home()) echo('class="current_page_item"') ?>><a href="<?php echo home_url(); ?>"><?php esc_html__('Home','TT'); ?></a></li>
		<?php };
		
		echo $page_menu;
	if ($addUlContainer) echo('</ul>');
	
};


function show_categories_menu($customClass = 'nav clearfix', $addUlContainer = true){
	global $shortname, $themename, $category_menu, $exclude_cats, $hide, $strdepth2, $projects_cat;
		
	//excluded categories
	if (get_option($shortname.'_menucats') <> '') $exclude_cats = implode(",", get_option($shortname.'_menucats')); 
	
	//hide empty categories
	if (get_option($shortname.'_categories_empty') == 'on') $hide = '1';
	else $hide = '0';
	
	//dropdown for categories
	$strdepth2 = '';
	if (get_option($shortname.'_enable_dropdowns_categories') == 'on') $strdepth2 = "depth=".get_option($shortname.'_tiers_shown_categories'); 
	if ($strdepth2 == '') $strdepth2 = "depth=1";
	
	$args = "orderby=".get_option($shortname.'_sort_cat')."&order=".get_option($shortname.'_order_cat')."&".$strdepth2."&exclude=".$exclude_cats."&hide_empty=".$hide."&title_li=&echo=0";
	
	$categories = get_categories($args);
	
	if (!empty($categories)) {
		$category_menu = wp_list_categories($args);	
		if ($addUlContainer) echo('<ul class="'.$customClass.'">');
			if ($category_menu <> '<li>No categories</li>') echo($category_menu); 
		if ($addUlContainer) echo('</ul>');
	};
	
};

/*this function gets page name by its id*/
function get_pagename($page_id)
{
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = '".$page_id."' AND post_type = 'page'");
	return $page_name;
}


/*this function gets category name by its id*/
function get_categname($cat_id)
{
	global $wpdb;
	$cat_name = $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id = '".$cat_id."'");
	return $cat_name;
}


/*this function gets category id by its name*/
function get_catId($cat_name)
{
	$cat_name_id = get_cat_ID($cat_name);
	return $cat_name_id;
}


/*this function gets page id by its name*/
function get_pageId($page_name)
{
	global $wpdb;
	$page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '".$page_name."' AND post_type = 'page'");
	
	//fix for qtranslate plugin
	if ( $page_name_id == '' ) $page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%".trim($page_name)."%' AND post_type = 'page'");

	return $page_name_id;
}
function tt_get_author_posts_url($author_id, $author_nicename = '') {
      global $wp_rewrite;
      $auth_ID = (int) $author_id;
      $link = $wp_rewrite->get_author_permastruct();

      if ( empty($link) ) {
              $file = home_url() . '/';
              $link = $file . '?author=' . $auth_ID;
      } else {
              if ( '' == $author_nicename ) {
                      $user = get_userdata($author_id);
                      if ( !empty($user->user_nicename) )
                              $author_nicename = $user->user_nicename;
             }
              $link = str_replace('%author%', $author_nicename, $link);
             $link = home_url(). trailingslashit($link);
      }

      $link = apply_filters('author_link', $link, $author_id, $author_nicename);

      return $link;
}

/* Folower */
function rss_count ($rss_user) {
$rssurl="https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=feeds.feedburner.com/". $rss_user;
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $rssurl);
$stored = curl_exec($ch);
curl_close($ch);
$grid = new SimpleXMLElement($stored);
$rsscount = $grid->feed->entry['circulation']+0;
return number_format($rsscount);
}
function rss_count_run($feed) {
$rss_subs = rss_count ($feed);
$rss_option = "rss_sub_value";
$rss_subscount = get_option($rss_option);
if (is_null($rss_subs)) { return $rss_subscount; }
else {update_option($rss_option, $rss_subs); return $rss_subs;}
}
function rss_sub_value($feed) {
echo rss_count_run($feed);
};

function twitter_followers_count ($twitter_username) {
			   $url = 'http://twitter.com/users/show/'.$twitter_username;
               $response = file_get_contents ( $url );
               $t_profile = new SimpleXMLElement ( $response );
               $count = $t_profile->followers_count;
			   echo $count; 
};

function fb_fanpage_count($fanpage_id) {
$count = get_transient('fan_count');
if ($count !== false) return $count;
$count = 0;
$data = wp_remote_get('http://api.facebook.com/restserver.php?method=facebook.fql.query&query=SELECT%20fan_count%20FROM%20page%20WHERE%20page_id='.$fanpage_id.'');
if (is_wp_error($data)) {
return 'Error';
}else{
$count = strip_tags($data[body]);
}
set_transient('fan_count', $count, 60*60*24); // 24 hour cache
echo $count;
}
?>