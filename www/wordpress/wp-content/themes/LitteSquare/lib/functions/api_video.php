<?php
function tt_video_show($video_width)
{
#
#Get the meta
#
$video_height = get_meta_option('video_height');
$video_m4v = get_meta_option('video_m4v');
$video_ogv = get_meta_option('video_ogv');
$video_webm = get_meta_option('video_webm');
$video_preview = get_meta_option('slidershow_video_preview');
$video_embed_code = stripslashes(get_meta_option('video_embed_code'));
$video_id = get_the_id();
?>
<?php if($video_embed_code): ?>
	  <?php echo $video_embed_code; ?>
<?php else: ?>
<?php
	//JS
	echo '<script type="text/javascript">'."\n";
	echo '//<![CDATA['."\n";
	echo 'jQuery(document).ready(function(){		'."\n";
	echo '		jQuery("#jquery_jplayer_'.$video_id.'").jPlayer({'."\n";
	echo '			ready: function () {'."\n";
	echo '				jQuery(this).jPlayer("setMedia", {'."\n";
	if($video_m4v) { echo '					m4v: "'.$video_m4v.'",'."\n"; }
	if($video_ogv) { echo '					ogv: "'.$video_ogv.'",'."\n"; }
	if($video_webm) { echo '					webmv: "'.$video_webm.'",'."\n"; }
	echo '					poster: "'.$video_preview.'"'."\n";
	echo '				});'."\n";
	echo '			},'."\n";
	echo '			size: {'."\n";
	echo '				width: "'.$video_width.'",'."\n";
	echo '				height: "'.$video_height.'px"'."\n";
	echo '			},'."\n";
	echo '		    swfPath: "'.JS_URI.'/flash",'."\n";
	echo '			cssSelectorAncestor: "#jp_interface_'.$video_id.'",'."\n";
	echo '			supplied: "webmv, ogv, m4v"'."\n";
	echo '		});'."\n";
	echo '});'."\n";
	echo '//]]>'."\n";
	echo '</script>'."\n";
?>
<div class="jp-video jp-video-single-container">
<div class="jp-type-single">
	<div id="jquery_jplayer_<?php echo $video_id; ?>" class="jp-jplayer" style="height:<?php echo $video_height; ?>px;"></div>
	<div id="jp_interface_<?php echo $video_id; ?>" class="jp-interface">
		<div class="jp-video-play" style="height:<?php echo $video_height; ?>px; top:-<?php echo $video_height; ?>px;"></div>
		<ul class="jp-controls">
		<li class="jp-controls-li"><a href="#" class="jp-play" tabindex="1">play</a></li>
		<li class="jp-controls-li"><a href="#" class="jp-pause" tabindex="1">pause</a></li>
		<li class="jp-controls-li"><a href="#" class="jp-stop" tabindex="1">stop</a></li>
		<li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
		<li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
		</ul>
		<div class="jp-progress">
		<div class="jp-seek-bar">
			<div class="jp-play-bar"></div>
		</div>
		</div>
		<div class="jp-volume-bar">
			<div class="jp-volume-bar-value"></div>
		</div>
	</div>
</div>
</div>
<?php endif; ?>
<?php
}
?>