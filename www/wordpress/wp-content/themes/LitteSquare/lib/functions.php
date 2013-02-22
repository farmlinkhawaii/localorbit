<?php
//path to directory to scan

//get all image files with a .jpg extension.
$theme_functions = glob(THEMESTUDIO_THEME_FUNCTIONS . "*.php");
 
//print each file name
foreach($theme_functions as $theme_function)
{
require_once($theme_function);
}
?>