<?php
# USER ID
function ts_user_id()
{
	global $userdata;
	get_currentuserinfo();
	echo $userdata->ID;
}
function ts_get_user_id()
{
	global $userdata;
	get_currentuserinfo();
	return $userdata->ID;
}
#USER NAME
function ts_user_name()
{
	global $userdata;
	get_currentuserinfo();
	echo $userdata->user_login;
}
function ts_get_user_name()
{
	global $userdata;
	get_currentuserinfo();
	return $userdata->user_login;
}
#USER LEVEL
function ts_user_level()
{
	global $userdata;
	get_currentuserinfo();
	echo $userdata->user_level;
}
function ts_get_user_level()
{
	global $userdata;
	get_currentuserinfo();
	return $userdata->user_level;
}
?>