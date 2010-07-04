<?php

$arras_custom_bg_options = maybe_unserialize(get_option('arras_custom_bg_options'));
if (!$arras_custom_bg_options) {
	$arras_custom_bg_options = array(
		'enable'		=> false,
		'id' 			=> 0,
		'attachment' 	=> 'scroll',
		'pos-x'			=> 'center',
		'pos-y'			=> 'top',
		'repeat'		=> 'no-repeat',
		'color'			=> '#F0F0F0',
		'foreground'	=> false,
		'wrap'			=> false
	);
}
update_option('arras_custom_bg_options', maybe_serialize($arras_custom_bg_options));

function arras_custom_background_scripts() {
	wp_enqueue_script('farbtastic');
}

function arras_custom_background_styles() {
	?> <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/admin.css" type="text/css" /> <?php
	wp_enqueue_style('farbtastic');
}

function arras_custom_background() {
	global $arras_custom_bg_options;

	$notices = '';
	
	if ( isset($_REQUEST['reset']) ) {
		check_admin_referer('arras-custom-background');
		$arras_custom_bg_options = array(
			'enable'		=> false,
			'id' 			=> 0,
			'attachment' 	=> 'scroll',
			'pos-x'			=> 'center',
			'pos-y'			=> 'center',
			'repeat'		=> 'no-repeat',
			'color'			=> '#F0F0F0',
			'foreground'	=> false,
			'wrap'			=> false
		);
		update_option('arras_custom_bg_options', maybe_serialize($arras_custom_bg_options));
		$notices = '<div class="updated"><p>' . __('Your settings have been reverted to the defaults.', 'arras') . '</p></div>';
	}

	if ( isset($_REQUEST['save']) ) {
		check_admin_referer('arras-custom-background');
		
		if ($_FILES['import']['error'] != 4) {
			$overrides = array('test_form' => false);
			$file = wp_handle_upload($_FILES['import'], $overrides);

			if ( isset($file['error']) )
			die( $file['error'] );
			
			$url = $file['url'];
			$type = $file['type'];
			$file = $file['file'];
			$filename = basename($file);

			// Construct the object array
			$object = array(
			'post_title' => $filename,
			'post_content' => $url,
			'post_mime_type' => $type,
			'guid' => $url);

			// Save the data
			$arras_custom_bg_options['id'] = wp_insert_attachment($object, $file);
		}
		
		$arras_custom_bg_options['enable'] = (boolean)(isset($_POST['bg-enable']));
		$arras_custom_bg_options['attachment'] = stripslashes($_POST['bg-attachment']);
		$arras_custom_bg_options['pos-x'] = stripslashes($_POST['bg-pos-x']);
		$arras_custom_bg_options['pos-y'] = stripslashes($_POST['bg-pos-y']);
		$arras_custom_bg_options['repeat'] = stripslashes($_POST['bg-repeat']);
		$arras_custom_bg_options['color'] = stripslashes($_POST['bg-color']);
		$arras_custom_bg_options['foreground'] = (boolean)(isset($_POST['foreground']));
		$arras_custom_bg_options['wrap'] = (boolean)(isset($_POST['wrap']));
		
		update_option('arras_custom_bg_options', maybe_serialize($arras_custom_bg_options));
		
		$notices = '<div class="updated"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
	}

	if ( isset($_GET['page']) && $_GET['page'] == 'arras-custom-background' ) : ?>
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		 jQuery('#colorpicker').farbtastic('#bg-color');
		 jQuery('#colorpicker').hide();
		 jQuery('#bg-color').click(function() {
			jQuery('#colorpicker').fadeIn();
		 });
		 jQuery('#bg-color').blur(function() {
			jQuery('#colorpicker').fadeOut();
		 });
	});
	</script>
	
	<div class="wrap">
	
	<?php echo $notices ?>
	
	<?php screen_icon('themes'); ?>
	<h2><?php _e('Custom Background', 'arras') ?></h2>
	
	<form enctype="multipart/form-data" id="arras-custom-bg-form" method="post" action="admin.php?page=arras-custom-background" class="clearfix">
		<?php wp_nonce_field('arras-custom-background'); ?>
		<div id="custom-bg-options">
			<p style="margin-top: 0">
			<?php echo arras_form_checkbox('bg-enable', false, (boolean)$arras_custom_bg_options['enable'], 'id="bg-enable"'); ?>
			 <label style="display: inline; color: red;" for="bg-enable"><?php _e('Activate Custom Background', 'arras') ?></label>
			</p>
			<div class="upload-bg">
				<label for="import"><?php _e('Upload Background Image', 'arras') ?></label>
				<input type="file" id="upload" name="import" size="40" />
			</div>
			<div class="advanced">
				<p><label for="bg-attachment"><?php _e('Background Attachment', 'arras') ?></label>
				<?php echo arras_form_radio('bg-attachment', 'fixed', $arras_custom_bg_options['attachment'] == 'fixed') . __('Fixed', 'arras')?><br />
				<?php echo arras_form_radio('bg-attachment', 'scroll', $arras_custom_bg_options['attachment'] == 'scroll') . __('Scroll (along with the rest of the page)', 'arras') ?></p>
				<p><label for="bg-pos-x"><?php _e('Horizontal Position', 'arras') ?></label>
				<?php echo arras_form_radio('bg-pos-x', 'left', $arras_custom_bg_options['pos-x'] == 'left') . __('Left', 'arras') ?><br />
				<?php echo arras_form_radio('bg-pos-x', 'center', $arras_custom_bg_options['pos-x'] == 'center') . __('Center', 'arras') ?><br />
				<?php echo arras_form_radio('bg-pos-x', 'right', $arras_custom_bg_options['pos-x'] == 'right') . __('Right', 'arras') ?></p>
				<p><label for="bg-pos-y"><?php _e('Vertical Position', 'arras') ?></label>
				<?php echo arras_form_radio('bg-pos-y', 'top',  $arras_custom_bg_options['pos-y'] == 'top') . __('Top', 'arras') ?><br />
				<?php echo arras_form_radio('bg-pos-y', 'center',  $arras_custom_bg_options['pos-y'] == 'center') . __('Center', 'arras') ?><br />
				<?php echo arras_form_radio('bg-pos-y', 'bottom',  $arras_custom_bg_options['pos-y'] == 'bottom') . __('Bottom', 'arras') ?></p>
				<p><label for="bg-repeat"><?php _e('Repeat Background Image?', 'arras') ?></label>
				<?php echo arras_form_radio('bg-repeat', 'no-repeat',  $arras_custom_bg_options['repeat'] == 'no-repeat') . __('None', 'arras') ?><br />
				<?php echo arras_form_radio('bg-repeat', 'repeat-x',  $arras_custom_bg_options['repeat'] == 'repeat-x') . __('Repeat Horizontally', 'arras') ?><br />
				<?php echo arras_form_radio('bg-repeat', 'repeat-y',  $arras_custom_bg_options['repeat'] == 'repeat-y') . __('Repeat Vertically', 'arras') ?><br />
				<?php echo arras_form_radio('bg-repeat', 'repeat',  $arras_custom_bg_options['repeat'] == 'repeat') . __('Repeat Both', 'arras') ?>
				</p>
				<p><label for="bg-color"><?php _e('Background Color', 'arras') ?></label>
					<input type="text" id="bg-color" name="bg-color" size="7" value="<?php echo $arras_custom_bg_options['color']; ?>" />
					<div id="colorpicker"></div>
				</p>
				<p><?php echo arras_form_checkbox('foreground', true, (boolean)$arras_custom_bg_options['foreground'], 'id="foreground"'); ?> <label style="display: inline" for="foreground"><?php _e('Semi-Transparent Foreground', 'arras') ?></label><br /><?php _e('This feature does not work in IE6 and for those using the legacy stylesheet.', 'arras') ?></p>
				<p><?php echo arras_form_checkbox('wrap', true, (boolean)$arras_custom_bg_options['wrap'], 'id="wrap"'); ?> <label style="display: inline" for="foreground"><?php _e('Apply Background from Top', 'arras') ?></label></p>
			</div>
			<p><input name="save" class="button-primary" type="submit" value="<?php _e('Save Changes', 'arras') ?>" />
			<input name="reset" class="button-secondary" type="submit" value="<?php _e('Reset', 'arras') ?>" /></p>
		</div><!-- #custom-bg-options -->
		<div id="custom-bg-preview">
			<h3><?php _e('Current Background Image', 'arras') ?></h3>
			<?php if ( $arras_custom_bg_options['id'] != 0 ) echo wp_get_attachment_image($arras_custom_bg_options['id'], 'full'); ?>
		</div><!-- #custom-bg-preview -->
	</form>
	
	</div><!-- .wrap -->
	
	<?php endif; ?>
	
<?php
}

function arras_add_custom_background() {
	global $arras_custom_bg_options;
	
	if (!$arras_custom_bg_options['enable']) return false;
	
	$img = wp_get_attachment_image_src($arras_custom_bg_options['id'], 'full');
	
	if ($arras_custom_bg_options['wrap']) $css_class = 'body';
	else $css_class ='#wrapper';
?>
<?php echo $css_class ?> { background:<?php if($arras_custom_bg_options['id'] != 0) echo ' url(' . $img[0] . ')'; ?> <?php echo $arras_custom_bg_options['pos-x'] . ' ' . $arras_custom_bg_options['pos-y'] . ' ' . $arras_custom_bg_options['attachment'] . ' ' . $arras_custom_bg_options['repeat'] . ' ' . $arras_custom_bg_options['color']; ?> !important; }
<?php
if ($arras_custom_bg_options['foreground']) :
?>
#main { background: url(<?php echo get_template_directory_uri() ?>/images/foreground.png) !important; }
<?php
endif;
}
add_action('arras_custom_styles', 'arras_add_custom_background');

?>