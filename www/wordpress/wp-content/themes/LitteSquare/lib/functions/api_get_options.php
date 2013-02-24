<?php
/*
* ----------------------------------------------------------------------------------------------------
* Get options
* @PACKAGE BY HAWKTHEME
* ----------------------------------------------------------------------------------------------------
*/

/*
* Get related posts by taxonomy
*/
function get_posts_related_by_taxonomy($taxonomy, $posts_per_page, $args=array())
{
	  global $post;
	  $post_id = $post->ID;
	  $query = new WP_Query();
	  $terms = wp_get_object_terms($post_id, $taxonomy);
	  if (count($terms)) 
	  {
			// Assumes only one term for per post in this taxonomy
			$post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
			$post = get_post($post_id);
			$args = wp_parse_args($args,array(
			  'post_type' => $post->post_type, // The assumes the post types match
			  //'post__in' => $post_ids,
			  'post__not_in' => array($post_id),
			  'taxonomy' => $taxonomy,
			  'term' => $terms[0]->slug,
			  'exclude' => $post,
			  'posts_per_page' => $posts_per_page
			));
			$query = new WP_Query($args);
	  }
	  return $query;
}



/*
* Get meta boxes
*/
function get_meta_option($var, $post_id=NULL) {

	if($post_id) return get_post_meta($post_id, $var, true);
	if(is_404()) return get_post_meta(0, $var, true); //Fixed 404 page
    global $post;
	if($post != null)
	{
    return get_post_meta($post->ID, $var, true);
	}else
	{
	return '';
	}
}




/*
* Get page id by name
*/
function get_page_id($name) 
{
    $page = get_page_by_path($name);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}



/*
* Get category id by name
*/
function get_category_id($name, $taxonomy) 
{
	$term = get_term_by('name', $name, $taxonomy);
	 if ($term) {
        return $term->term_id;
    } else {
        return null;
    }
}



/*
* Get name by id
*/
function get_category_name($id, $taxonomy)
{
	$term = get_term_by('id', $id, $taxonomy);
	return $term->name;
}



/*
* Get image url by id
*/
function get_image_url($post_id=NULL){
	
	global $post;
	if($post_id)
	{ 
		$image_wp = wp_get_attachment_image_src($post->ID,'full', true);
	}	
	else
	{
		$image_wp = wp_get_attachment_image_src(get_post_thumbnail_id(),'full', true); 
	}
	return $image_wp[0];
	
}


function get_theme_option($page, $name = NULL) 
{

	global $theme_options;

	if ($name == NULL) {
		if (isset($theme_options[$page])) {
			return $theme_options[$page];
		} else {
			return false;
		}

	} else {
		if (isset($theme_options[$page][$name])) {
			return $theme_options[$page][$name];
		} else {
			return false;
		}
	}

}


?>