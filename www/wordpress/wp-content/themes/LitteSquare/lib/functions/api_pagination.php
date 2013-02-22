<?php 
/*
* ----------------------------------------------------------------------------------------------------
* Pagination Functions
* @PACKAGE BY HAWKtt
* ----------------------------------------------------------------------------------------------------
*/


/*------------------------------------------------------------------------
*tt Pagination
------------------------------------------------------------------------*/
function tt_pagination() 
{
	$pagination = '1';//''get_theme_option('general','pagination');

	if($pagination == '1') {
		tt_page_navi ();
	}elseif($pagination == '3' && function_exists('wp_pagenavi')){	
		wp_pagenavi();	
	}else{
		tt_page_navi ();
	}
}


/*------------------------------------------------------------------------
*Load WP Pagination
------------------------------------------------------------------------*/
function tt_page_navi ($pages = '')
{
	global $paged;

	if(empty($paged))$paged = 1;

	$prev = $paged - 1;							
	$next = $paged + 1;	
	$range = 2; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;

	if($pages == '')
	{	
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}


	if(1 != $pages)
	{
		echo "<div class='pagination clearfix' id='pagination'><strong>Page</strong>";
		echo ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>&laquo;</a>":"";
		echo ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>&lsaquo;</a>":"";
	
		
		for ($i=1; $i <= $pages; $i++){
		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
		echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>"; 
		}
		}
	
		echo ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>&rsaquo;</a>" :"";
		echo ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>&raquo;</a>":"";
		echo "</div>\n";
	}
}


/*------------------------------------------------------------------------
*Load WP Pagination
------------------------------------------------------------------------*/
function get_page_navi ($pages = '')
{
	global $paged;
	$return='';
	if(empty($paged))$paged = 1;

	$prev = $paged - 1;							
	$next = $paged + 1;	
	$range = 2; // only edit this if you want to show more page-links
	$showitems = ($range * 2)+1;

	if($pages == '')
	{	
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}


	if(1 != $pages)
	{
		$return .= "<nav class='pagination clearfix' id='pagination'><strong>Page </strong>";
		$return .= ($paged > 2 && $paged > $range+1 && $showitems < $pages)? "<a href='".get_pagenum_link(1)."'>&laquo;</a>":"";
		$return .= ($paged > 1 && $showitems < $pages)? "<a href='".get_pagenum_link($prev)."'>&lsaquo;</a>":"";
	
		
		for ($i=1; $i < $pages; $i++){
		if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
		$return .= ($paged == $i)? "<span class='current'>".$i.",</span> ":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i.",</a> "; 
		}
		}
	
		$return .= ($paged == $pages)? "<span class='current'>".$pages.".</span> ":"<a href='".get_pagenum_link($pages)."' class='inactive' >".$pages.".</a> ";
			
		$return .= ($paged < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($next)."'>&rsaquo;</a>" :"";
		$return .= ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) ? "<a href='".get_pagenum_link($pages)."'>&raquo;</a>":"";
		$return .= "</nav>\n";
	}
	return $return;
}


/*------------------------------------------------------------------------
*Load Prev Next Pagination
------------------------------------------------------------------------*/
function tt_prev_next () 
{
	 echo '<div class="normal-pagination clearfix"><span class="prev">';
	 previous_posts_link(__('Previous', 'TT')); 
	 echo '</span><span class="next">';
	 next_posts_link(__('Next', 'TT')); 
	 echo '</span></div>';
}

?>