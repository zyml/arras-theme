<?php
function arras_addmenu() {
	$options_page = add_menu_page( __('Arras Theme', 'arras'), __('Arras Theme', 'arras'), 8, 'arras-options', 'arras_admin', get_template_directory_uri() . '/images/icon.png');
	add_submenu_page( 'arras-options', __('Arras Theme', 'arras'), __('Theme Options', 'arras'), 8, 'arras-options', 'arras_admin' );
	add_submenu_page( 'arras-options', __('Arras Theme', 'arras'), __('Quick Guide', 'arras'), 8, 'arras-guide', 'arras_guide' );

	add_action('admin_print_scripts-'. $options_page, 'arras_admin_scripts');
	add_action('admin_print_styles-'. $options_page, 'arras_admin_styles');
}

function arras_admin() {
	global $arras_options;
	
	$notices = ''; // store notices here so that options_page.php will echo it out later
	
	if ( isset($_GET['page']) && $_GET['page'] == 'arras-options' ) {
		//print_r($_POST);
		
		if ( isset($_REQUEST['save']) ) {
			$arras_options->save_options();
			arras_update_options();
			$notices = '<div class="updated"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
		}
		
		if ( isset($_REQUEST['reset']) ) {
			delete_option('arras_options');
			arras_flush_options();
			$notices = '<div class="updated"><p>' . __('Your settings have been reverted to the defaults.', 'arras') . '</p></div>';
		}
		
		if ( isset($_REQUEST['clearcache']) ) {
			$cache_location = get_template_directory() . '/library/cache';
			if ( !$dh = @opendir($cache_location) ) return false;
			while ( false !== ($obj = readdir($dh)) ) {
				if($obj == '.' || $obj == '..') continue;
				@unlink(trailingslashit($cache_location) . $obj);
			}
			closedir($dh);
			$notices = '<div class="updated"><p>' . __('Thumbnail cache has been cleared.', 'arras') . '</p></div>';
		}
		
		$nonce = wp_create_nonce('arras-admin'); // create nonce token for security
		include 'templates/options_page.php';
	}
}

function arras_guide() {
	include 'templates/usage_page.php';	
}

function arras_admin_scripts() {
	wp_enqueue_script('jquery-ui-tabs', null, 'jquery-ui-core');
	wp_enqueue_script('farbtastic', get_template_directory_uri() . '/js/farbtastic.js');
	wp_enqueue_script('arras-admin-js', get_template_directory_uri() . '/js/admin.js');
}

function arras_admin_styles() {
?> <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/admin.css" type="text/css" /> <?php
}

/* End of file admin.php */
/* Location: ./library/admin/admin.php */
