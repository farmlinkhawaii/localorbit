<?php

core::ensure_navstate(array('left'=>'left_about'));
core::head('View Our Sellers','View the sellers on our market.');
lo3::require_permission();
lo3::require_login();

lo3::require_orgtype('admin');

?>

<h1>View the Sellers on our Market</h1>        
