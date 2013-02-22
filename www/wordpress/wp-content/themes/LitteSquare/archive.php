<?php
/**
 * Archive pages
 * Author : vthanh_88
 * @package WordPress
*/
#
# Get Archive
#
$post_type="post";
$archive_title = 'Archives ';
if ( is_day() ) :
	$archive_title.= get_the_date();
	elseif ( is_month() ) :
			$archive_title.= get_the_date('F Y') ;
	elseif ( is_year() ) :
			$archive_title.= get_the_date('Y');
	else :
			$archive_title = "Portfolio  ".$_GET["portfolio-types"] ; 
			$post_type="portfolio";
	endif; 

#
#Get Paged
#
if ( get_query_var('paged') ) {
	$paged = get_query_var('paged');
} elseif ( get_query_var('page') ) { 
	$paged = get_query_var('page');
} else {
	$paged = 1;
}
if($post_type =="post")
{
 include('archive-post.php');
}
else
{
include('archive-portfolio.php');
}

?>
      
<?php

get_footer();  
?>