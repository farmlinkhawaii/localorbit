<?php
/**
 * Comment template
 * The main template file for display portfolio page.
 * Author : vthanh_88
 * @package WordPress
*/
global $theme_options;
if ( post_password_required() ) { ?>
   
	<p><?php echo esc_html__( 'This post is password protected. Enter the password to view comments.', 'TC' ); ?></p>
<?php
	return;
}

if( have_comments() ) : ?> 
					
    					<!-- <div class="span9"><h2 class="section-title"><?php //comments_number('No comment', 'Comment', '% responses to this post'); ?> for "<?php the_title(); ?>"<span></span></h2></div> -->

            					<?php wp_list_comments( array('callback' => 'tt_comment', 'avatar_size' => '72') ); ?>
    						
    					<!-- End of thread -->  
					
<?php endif; ?>  



<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="pagination"><p><?php previous_comments_link(); ?> <?php next_comments_link(); ?></p></div><br class="clear"/><div class="line"></div><br/><br/>
<?php endif; // check for comment navigation ?>



<?php if ('open' == $post->comment_status) : ?> 
	  <section id="comment-form" class= "">
				
        		<?php  if($theme_options['enable_comment_post'] == "1"): ?>
        			<?php   theme_comment_form() ;?>
        		<?php else:
        		echo esc_html__('<h3>Comment is disabled</h3>','TC');
        		endif; ?>
        		
		</section>	
<?php endif; ?> 