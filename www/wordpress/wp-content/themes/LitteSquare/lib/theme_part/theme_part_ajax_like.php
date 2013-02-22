<?php
function ajax_like()
{
	$post_ID = $_POST["post_ID"];
	$return = "";
	
	if(isset($_COOKIE["haveliked".$post_ID]) && $_COOKIE["haveliked".$post_ID] == $post_ID){
	
		$return.= esc_html__('You Have Liked!','TT');
	}else{
		if(get_option('like'.$post_ID) != ''):
			$liked = get_option('like'.$post_ID)+1;
			update_option('like'.$post_ID,$liked);
			$return.= get_option('like'.$post_ID);
		else:
			add_option('like'.$post_ID,'1');
			$return.='1';
		endif;
		setcookie("haveliked".$post_ID, $post_ID);
		
	};
	echo  $return;
	die;
}
/*
Ajax Load
*/
add_action( 'wp_ajax_nopriv_ajax_like', 'ajax_like' );
add_action( 'wp_ajax_ajax_like', 'ajax_like' );

?>