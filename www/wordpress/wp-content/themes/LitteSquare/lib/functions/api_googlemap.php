<?php
function tt_googlemap($lat = "-25.363882" ,$lon = "131.044922")
{
#
#Google map 
#
	//JS
	echo '<script type="text/javascript">'."\n";
	echo 'function reCenter() {'."\n";
	echo '  window.setTimeout(function() {'."\n";
    echo '  map.panTo(marker.getPosition());'."\n";
    echo '}, 1000);}'."\n";
    echo 'function initialize() {'."\n";
    echo '  var myOptions = {'."\n";
    echo '    zoom: 4,'."\n";
    echo '    center: new google.maps.LatLng('.$lat.', '.$lon.'),'."\n";
    echo '    mapTypeId: google.maps.MapTypeId.ROADMAP };'."\n";
    echo '  map = new google.maps.Map(document.getElementById("google_map"),'."\n";
    echo '      myOptions);'."\n";
    echo '  marker = new google.maps.Marker({'."\n";
    echo '    position: map.getCenter(),'."\n";
    echo '    map: map,'."\n";
    echo '    title: "Click to zoom"'."\n";
    echo '  });'."\n";
    
    echo '}'."\n";
    echo 'google.maps.event.addDomListener(window, "load", initialize);'."\n";
	echo '</script>'."\n";
}
?>