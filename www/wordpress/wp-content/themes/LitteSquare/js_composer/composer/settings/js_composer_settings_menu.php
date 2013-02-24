<?php
/**
 * WPBakery Visual Composer Plugin wordpress settings page
 *
 * @package VPBakeryVisualComposer
 *
 */

// don't load directly
if ( !defined('ABSPATH') ) die('-1');

$excluded = array('attachment', 'revision', 'nav_menu_item', 'mediapage');
$post_types = get_post_types(array('public'   => true));

// if this fails, check_admin_referer() will automatically print a "failed" page and die.
if ( !empty($_POST) && check_admin_referer('wpb_js_settings_save_action', 'wpb_js_nonce_field') ) {
		
	// process form data
	$pt_arr = array();
	foreach ( $_POST as $pt ) {
		if ( !in_array($pt, $excluded) && in_array($pt, $post_types) ) {
			$pt_array[] = $pt;
		}
	}
	
	if ( count($pt_array) > 0 ) {
		update_option('wpb_js_content_types', $pt_array);
	} else {
		delete_option('wpb_js_content_types');
	}
}

if ( current_user_can('switch_themes') ) : ?>
	<div id="custom-background" class="wrap">
		<div class="icon32" id="icon-themes"><br></div>
		
		<h2><?php _e("Visual Composer Settings VVVersion", "TS"); ?></h2>
		
		<form action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><?php _e("Content types", "TS"); ?></th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span><?php _e("Post types", "TS"); ?></span></legend>
								<?php
								$pt_array = ($pt_array = get_option('wpb_js_content_types')) ? $pt_array : array();
								foreach ($post_types as $pt) {
									if (!in_array($pt, $excluded)) {
										$checked = (in_array($pt, $pt_array)) ? ' checked="checked"' : '';
									?>
										<label for="use_smilies">
											<input type="checkbox"<?php echo $checked; ?> value="<?php echo $pt; ?>" id="check_<?php echo $pt; ?>" name="post_type_<?php echo $pt; ?>">
												<?php echo $pt; ?>
										</label><br>
									<?php }
								}
								?>
							</fieldset>
						</td>
					</tr>
					
					<tr valign="top">
						<th>&nbsp;</th>
						<td>
							<p class="description indicator-hint"><?php _e("Select for which content types Visual Composer should be available during post creation/editing.", "TS"); ?></p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php wp_nonce_field('wpb_js_settings_save_action', 'wpb_js_nonce_field'); ?>
			<p class="submit">
				<input type="submit" value="Save Changes" class="button-primary" id="save-background-options" name="save-background-options">
            </p>
		</form>
		
		<div>
			<h2><?php _e("Thank you", "TS"); ?></h2>
			<p><?php _e("Visual Composer will save you a lot of time while working with your sites content.", "TS"); ?></p>
			<p><?php _e('If you have comments or simply want to say "Hi", please check <a href="http://wpbakery.com/vc/" title="" target="_blank">plugins homepage</a>.', "TS"); ?></p>
		</div>
		
	</div>
<?php endif; ?>
<?php ?>