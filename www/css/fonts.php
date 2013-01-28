<?
/*
mysql_connect($core->config['db']['hostname'],$core->config['db']['username'],$core->config['db']['password']);
mysql_select_db($core->config['db']['database']);
   $font_list = array();
   $fonts = core::model('fonts')->collection();
   foreach ($fonts as $font) {
      list($font_label) = explode(',', $font['font_name']);
      $font_list[] = str_replace(' ', '+', str_replace('\'', '', $font_label));
   }
   $font_list = implode('|', $font_list);
*/
?>
   @import url(http://fonts.googleapis.com/css?family=<?=$font_list?>);