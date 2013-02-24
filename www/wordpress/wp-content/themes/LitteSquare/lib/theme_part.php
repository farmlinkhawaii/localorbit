<?php
//get all image files with a .jpg extension.
$theme_parts = glob(THEMESTUDIO_THEME_PART . "*.php");
 
//print each file name
foreach($theme_parts as $theme_part)
{
require_once($theme_part);
}
?>