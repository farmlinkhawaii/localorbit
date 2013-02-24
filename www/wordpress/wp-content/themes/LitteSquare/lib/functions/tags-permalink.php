<?php
# PARENT PERMALINK
function ts_parent_permalink()
{
	global $post;
	echo get_permalink($post->post_parent);
}
function ts_get_parent_permalink()
{
	global $post;
	return get_permalink($post->post_parent);
}
# PERMALINK BY NAME
function ts_permalink_by_name($page_name)
{
	global $post;
	echo get_permalink(_get_name_by_page_ID($page_name));
}
function ts_get_permalink_by_name($page_name)
{
	global $post;
	return get_permalink(_get_name_by_page_ID($page_name));
}
?>