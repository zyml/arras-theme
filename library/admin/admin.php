<?php
function arras_addmenu() {
	$options_page = add_menu_page( '', __('Arras Theme', 'arras'), 'switch_themes', 'arras-options', 'arras_admin', get_template_directory_uri() . '/images/icon.png', 63);
	add_submenu_page( 'arras-options', __('Arras Theme Options', 'arras'), __('Theme Options', 'arras'), 'switch_themes', 'arras-options', 'arras_admin' );
	
	$custom_background_page = add_submenu_page( 'arras-options', __('Custom Background', 'arras'), __('Custom Background', 'arras'), 'switch_themes', 'arras-custom-background', 'arras_custom_background' );

	add_action('admin_print_scripts-'. $options_page, 'arras_admin_scripts');
	add_action('admin_print_styles-'. $options_page, 'arras_admin_styles');
	
	add_action('admin_print_scripts-' . $custom_background_page, 'arras_custom_background_scripts');
	add_action('admin_print_styles-' . $custom_background_page, 'arras_custom_background_styles');
}

function arras_admin() {
	global $arras_options;
	
	$notices = ''; // store notices here so that options_page.php will echo it out later
	
	if ( isset($_GET['page']) && $_GET['page'] == 'arras-options' ) {
		//print_r($_POST);
		
		if ( isset($_REQUEST['save']) ) {
			check_admin_referer('arras-admin');
			
			if (!isset($_POST['arras-delete-logo'])) {
			
				if ($_FILES['arras-logo']['error'] != 4) {
					$overrides = array('test_form' => false);
					$file = wp_handle_upload($_FILES['arras-logo'], $overrides);

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
					$arras_options->logo = wp_insert_attachment($object, $file);
					
					// Force generate the logo thumbnail
					$fullsizepath = get_attached_file($arras_options->logo);
					wp_update_attachment_metadata($arras_options->logo, wp_generate_attachment_metadata($arras_options->logo, $fullsizepath));
				}
			
			} else {
				$arras_options->logo = '';
			}
			
			$arras_options->save_options();
			arras_update_options();
			$notices = '<div class="updated fade"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
		}
		
		if ( isset($_REQUEST['reset']) ) {
			check_admin_referer('arras-admin');
			delete_option('arras_options');
			arras_flush_options();
			$notices = '<div class="updated fade"><p>' . __('Your settings have been reverted to the defaults.', 'arras') . '</p></div>';
		}
		
		if ( isset($_REQUEST['clearcache']) ) {
			check_admin_referer('arras-admin');
			$cache_location = get_template_directory() . '/library/cache';
			if ( !$dh = @opendir($cache_location) ) return false;
			while ( false !== ($obj = readdir($dh)) ) {
				if($obj == '.' || $obj == '..') continue;
				@unlink(trailingslashit($cache_location) . $obj);
			}
			closedir($dh);
			$notices = '<div class="updated fade"><p>' . __('Thumbnail cache has been cleared.', 'arras') . '</p></div>';
		}
		
		include 'templates/options_page.php';
	}
}

function arras_admin_scripts() {
	wp_enqueue_script('jquery-ui-tabs', null, 'jquery-ui-core');
	wp_enqueue_script('arras-admin-js', get_template_directory_uri() . '/js/admin.js');
}

function arras_admin_styles() {
?> <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/admin.css" type="text/css" /> <?php
}

function get_remote_array($url) {
	if ( function_exists('wp_remote_request') ) {	
		$options = array();
		$options['headers'] = array(
			'User-Agent' => 'Arras Theme Feed Grabber' . ARRAS_VERSION . '; (' . get_bloginfo('url') .')'
		 );
		 
		$response = wp_remote_request($url, $options);
		
		if ( is_wp_error( $response ) )
			return false;
	
		if ( 200 != $response['response']['code'] )
			return false;
		
		$content = unserialize($response['body']);

		if (is_array($content)) 
			return $content;
	}
	return false;	
}

function arras_get_contributors($arr) {
	ksort($arr);
	$i = count($arr);
	foreach ($arr as $name => $url)
	{
		if ($url)
			echo "<a href=\"$url\">$name</a>";
		else
			echo $name;
		$i--;
		if ($i == 1)
			echo " & ";
		elseif ($i)
			echo ", ";
	}
}

/* End of file admin.php */
/* Location: ./library/admin/admin.php */
