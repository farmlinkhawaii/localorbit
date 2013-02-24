<?php
# CATEGORY ID
function ts_category_ID() {
	$category = get_the_category();
	echo $category[0]->cat_ID;
}
function ts_get_category_ID() {
	$category = get_the_category();
	return $category[0]->cat_ID;
}
# CATEGORY PARENT ID
function ts_category_parent_ID() {
	$category = get_the_category();
	echo $category[0]->category_parent;
}
function ts_get_category_parent_ID() {
	$category = get_the_category();
	return $category[0]->category_parent;
}
# CATEGORY SLUG
function ts_category_slug() {
	$category = get_the_category();
	echo $category[0]->category_nicename;
}
function ts_get_category_slug() {
	$category = get_the_category();
	return $category[0]->category_nicename;
}
# CATEGORY NAME
function ts_category_name() {
	$category = get_the_category();
	echo $category[0]->cat_name;
}
function ts_get_category_name() {
	$category = get_the_category();
	return $category[0]->cat_name;
}
# CATEGORY COUNT
function ts_category_count($input = '') {
	echo ts_get_category_count($input);
}
function ts_get_category_count($input = '') {
	global $wpdb;
	if($input == '')
	{
		$category = get_the_category();
		return $category[0]->category_count;
	}
	elseif(is_numeric($input))
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->term_taxonomy.term_id=$input";
		return $wpdb->get_var($SQL);
	}
	else
	{
		$SQL = "SELECT $wpdb->term_taxonomy.count FROM $wpdb->terms, $wpdb->term_taxonomy WHERE $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id AND $wpdb->terms.slug='$input'";
		return $wpdb->get_var($SQL);
	}
}
# CATEGORY NAME BY ID
function ts_get_category_name_by_ID($category_id)
{
	global $wpdb;
	return $wpdb->get_var("SELECT name FROM $wpdb->terms WHERE term_id=".$category_id);
}
# CATEGORY ID BY NAME
function ts_get_category_ID_by_name($category_name)
{
	global $wpdb;
	return $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE slug='".$category_name."'");
}
?>