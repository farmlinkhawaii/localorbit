<?php
/*
* ----------------------------------------------------------------------------------------------------
* Theme Common
* @PACKAGE BY TT
* ----------------------------------------------------------------------------------------------------
*/
#
#Add basic theme functions
#
add_theme_support('menus');
add_theme_support('post-thumbnails', array('post', 'portfolio', 'slidershow'));
add_theme_support( 'post-thumbnails' ); 
add_theme_support('automatic-feed-links');
add_theme_support( 'custom-header');
add_theme_support( 'custom-background' );  
add_action('init', 'enable_excerpts');
add_editor_style('editor-style.css');

function enable_excerpts()
{
    add_post_type_support('page', 'excerpt');
	add_post_type_support('post', 'excerpt');
	add_post_type_support('postfolio', 'excerpt');
	
	
}
register_nav_menus( array( 
	'main menu' => esc_html__( 'Top Navigation', 'TT' ),
)); 

#
#Set the thumbs size for the posts
#
#
#Get theme options
#
$home_slidershow_height = 400;//get_theme_option('slidershow','slidershow_image_height');


//theme_add_thumbnail_size($thumb_size);
#
#Creates wordpress image thumb sizes for the theme
#
function theme_add_thumbnail_size($thumb_size)
{	
	foreach ($thumb_size['imgSize'] as $sizeName => $size)
	{
		if($sizeName == 'base')
		{
			set_post_thumbnail_size($thumb_size['imgSize'][$sizeName]['width'], $thumb_size[$sizeName]['height'], true);
		}
		else
		{	
			add_image_size(	 
				$sizeName,
				$thumb_size['imgSize'][$sizeName]['width'], 
				$thumb_size['imgSize'][$sizeName]['height'], 
				true);
		}
	}
}



#
#Remove Auto <p> For Shortcodes
#
function theme_remove_autop($content) 
{ 
	$content = do_shortcode( shortcode_unautop( $content ) ); 
	$content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
	return $content;
}

#
#Remove Default Widgets & Add Shortcode Support
#
function theme_remove_wp_widgets()
{
}
add_action('widgets_init', 'theme_remove_wp_widgets');
add_filter('widget_text', 'do_shortcode');
#
# Fixed WP Title
#
function theme_filter_wp_title( $title, $separator ) 
{
	if ( is_feed() )
		return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf( esc_html__( 'Search results for %s', 'TT' ), '"' . get_search_query() . '"' );
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( esc_html__( 'Page %s', 'TT' ), $paged );
			$title .= " $separator " . get_bloginfo( 'name', 'display' );
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( esc_html__( 'Page %s', 'TT' ), max( $paged, $page ) );

	return $title;
}

add_filter( 'wp_title', 'theme_filter_wp_title', 10, 2 );

#
# Google Recaptchar Process whene submit comment
#




#
#Theme Comments List
#
function theme_comment( $comment, $args, $depth ) 
{
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		
	?>
	
	<li class="pingback">
		<?php esc_html_e( 'Pingback:', 'TT' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'TT' ), '<span class="edit-link">', '</span>' ); ?>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	
	<article id="comment-<?php comment_ID(); ?>" class="clearfix comment-wrap">
		<div class="comment-author vcard">
		<?php
			$avatar_size = 64;
			if ( '0' != $comment->comment_parent ) { $avatar_size = 48; }
			echo get_avatar( $comment, $avatar_size );
		?>	
		
		<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( '<span class="reply">Reply</span>', 'TT' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?><!-- .reply -->
		
		</div><!-- .comment-author .vcard -->

		<div class="comment-entry">
			<div class="comment-meta">
			
			<?php
			printf( __( '%1$s on %2$s <span class="says">said:</span>', 'TT' ),
			sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
			sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
				esc_url( get_comment_link( $comment->comment_ID ) ),
				get_comment_time( 'c' ),
				/* translators: 1: date, 2: time */
				sprintf( __( '%1$s at %2$s', 'TT' ), get_comment_date(), get_comment_time() )
			));
			edit_comment_link( __( 'Edit', 'TT' ), '<span class="edit-link">', '</span>' ); 
			?>
			
			</div>
			<div class="comment-content">
			
			<?php if ( $comment->comment_approved == '0' ) : ?>
			
				<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'TT' ); ?></em>
			<?php endif; ?>
			
			<div class="comment-text post-content"><?php comment_text(); ?></div>
			<?php if(isset($_SESSION['recaptchar_comment_error'])){ $error_captchar = '<p>'.$_SESSION['recaptchar_comment_error'].'</p>';echo $error_captchar;$_SESSION['recaptchar_comment_error'] ='';} ?>
			</div>
		</div><!-- .comment-entry -->
	</article><!-- #comment-## -->
	
	<?php
	break;
	endswitch;
}


#
#Theme Comments Form
#
function theme_comment_form() 
{
	global $theme_options;
	$fields =  array(
			'author' => '
                            <input type="text" placeholder="Your Name ..." name="author" class="span3" id="comment_form_name author">
                       ',
			'email'  => '
                            <input type="text" placeholder="Your Email..." name="email" class="span3" id="email">
                        ',
			'url'    => '
                            <input type="text" placeholder="Your Website..." class="span3" name="website">
                       ',
						
	);
	$comment_notes_after='';
	$args = array(
			'title_reply' =>  esc_html__( 'Leave a Reply', 'TT' ),
			'comment_notes_before' => '<fieldset class="row">',
			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
			'comment_field' => '
                           	   		 <textarea name="comment" id="form_comment_field" class="span9" placeholder="'.$theme_options["comment_message"].'"></textarea>
								',
			'comment_notes_after' => '</fieldset>',
			'id_submit' =>'btncomment',
			'cancel_reply_link' =>'Cancer'
	);
	
	comment_form($args); 

}
// Add filter whene comment submit :
function api_is_user_must_using_captchar()
{
 	$recaptchar_hide_when = get_theme_option('general','recaptchar_hide_when');
	if(current_user_can($recaptchar_hide_when))
	{
       return false;
	}
	else
	{
	   return true; 
	}
}        
/*
*
*TT added function
*
*
*/
function google_recaptchar_verify($privatekey,$recaptcha_challenge_field,$recaptcha_response_field)
{
  $resp = recaptcha_check_answer ($privatekey,
                                  $_SERVER["REMOTE_ADDR"],
                                  $recaptcha_challenge_field,
                                  $recaptcha_response_field);
  
    if (!$resp->is_valid) {
      // What happens when the CAPTCHA was entered incorrectly
      return ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
           "(reCAPTCHA said: " . $resp->error . ")");
    } else {
      // Your code here to handle a successful verification
	  return 'success';
    }
}
//CAL FOR CONTACT
function sent_mail_post()
{
 
/*
    	|--------------------------------------------------------------------------
    	| Mailer module
    	|--------------------------------------------------------------------------
    	|
    	| These module are used when sending email from contact form
    	|
    	*/
    	//Get your email address
		$contact_email = get_theme_option('contact','email');
    	//Enter your email address, email from contact form will send to this addresss. Please enter inside quotes ('myemail@email.com')
    	define('DEST_EMAIL', $contact_email);
    	//Change email subject to something more meaningful
    	define('SUBJECT_EMAIL',$_POST['subject']);
    	//Error message when message can't send
    	define('SUCCESS_MESSAGE', '<h4 class="form_thanks">Thanks! Our Team will get in touch in next 24 hours.<h4>');
    	//Thans message when message  sended
    	define('ERROR_MESSAGE', '<h4 class="form_thanks">Oops! something went wrong, please try to submit later.</h4>');
    	/*
    	|
    	| Begin sending mail
    	|
    	*/
		$result='';
    	$from_name = $_POST['name'];
    	$from_email = $_POST['email'];
    	$mime_boundary_1 = md5(time());
        $mime_boundary_2 = "1_".$mime_boundary_1;
        $mail_sent = false;
        # Common Headers
        $headers = "";
        $headers .= 'From: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
        $headers .= 'Reply-To: '.$from_name.'<'.$from_email.'>'.PHP_EOL;
        $headers .= 'Return-Path: '.$from_name.'<'.$from_email.'>'.PHP_EOL;        // these two to set reply address
        $headers .= "Message-ID: <".date('Y-m-d H:i:s')."webmaster@".$_SERVER['SERVER_NAME'].">";
        $headers .= "X-Mailer: PHP v".phpversion().PHP_EOL;                  // These two to help avoid spam-filters
        # Boundry for marking the split & Multitype Headers
        $headers .= 'MIME-Version: 1.0'.PHP_EOL;
        $headers .= "Content-Type: multipart/mixed;".PHP_EOL;
        $headers .= "   boundary=\"".$mime_boundary_1."\"".PHP_EOL;
    	$message = 'Name: '.$from_name.PHP_EOL;
    	$message.= 'Email: '.$from_email.PHP_EOL.PHP_EOL;
    	$message.= 'Message: '.PHP_EOL.$_POST['comment'].PHP_EOL.PHP_EOL;
    	if(isset($_POST['website']))
    	{
    		$message.= 'Website: '.$_POST['website'].PHP_EOL;
    	}
		if(isset($_POST['phone']))
    	{
    		$message.= 'Phone: '.$_POST['phone'].PHP_EOL;
    	}
		if(isset($_POST['address']))
    	{
    		$message.= 'Address: '.$_POST['address'].PHP_EOL;
    	}
		
    	if(!empty($from_name) && !empty($from_email) && !empty($message))
    	{
    		mail(DEST_EMAIL, SUBJECT_EMAIL, $message, $headers);
    		return SUCCESS_MESSAGE;
			exit;
    	}
    	else
    	{
    		return  ERROR_MESSAGE;
    		exit;
    	}
    	/*
    	|
    	| End sending mail
    	|
    	*/	
		return $result;
}
function get_post_count($categories) {
	global $wpdb;
	$post_count = 0;

		foreach($categories as $cat) :
			$querystr = "
				SELECT count
				FROM $wpdb->term_taxonomy, $wpdb->posts, $wpdb->term_relationships
				WHERE $wpdb->posts.ID = $wpdb->term_relationships.object_id
				AND $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
				AND $wpdb->term_taxonomy.term_id = $cat
				AND $wpdb->posts.post_status = 'publish'
			";
			$result = $wpdb->get_var($querystr);
  		$post_count += $result;
   endforeach; 

   return $post_count;
}
?>