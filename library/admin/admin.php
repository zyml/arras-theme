<?php
$forum_contributors = array(
	'Giovanni' => 'http://www.animeblog.nl/',
	'dgodfather' => 'http://trusupremekillaz.com/tskgaming',
	'Charles' => 'http://www.claireraborar.com/travel',
	'Nedrago' => 'http://www.nedrago.com/',
	'Dan' => 'http://www.techunfolding.com/'
);
$translators = array(
	'Celso Azevedo (Portuguese)' => '',
	'Nolog (French)' => 'http://pookiecookie.fr/',
	'kokaz84 (French)' => 'http://micromanga.free.fr/',
	'er_mejor (Spanish)' => 'http://www.teusoft.com/',
	'AddVariety (Dutch)' => 'http://www.addvariety.com/',
	'Fredik Arvidsson (Swedish)' => 'http://www.fredrikarvidsson.com/',
	'Michael Wenzl (German)' => 'http://www.michaelwenzl.de/',
	'Michalis Pissas (Greek)' => '',
	'chaibi (Norwegian)' => '',
	'cngamers (Chinese)' => '',
	'lesta (Romanian)' => ''
);
$notices = ''; // store notices here so that options_page.php will echo it out later

function arras_addmenu() {
	$options_page = add_menu_page( '', __('Arras', 'arras'), 'switch_themes', 'arras-options', 'arras_admin', get_template_directory_uri() . '/images/icon.png', 63);
	add_submenu_page( 'arras-options', __('Arras Options', 'arras'), __('Theme Options', 'arras'), 'switch_themes', 'arras-options', 'arras_admin' );
	
	$posttax_page = add_submenu_page( 'arras-options', __('Post Types & Taxonomies', 'arras'), __('Post Types & Tax.', 'arras'), 'switch_themes', 'arras-posttax', 'arras_posttax' );
	
	$custom_background_page = add_submenu_page( 'arras-options', __('Custom Background', 'arras'), __('Custom Background', 'arras'), 'switch_themes', 'arras-custom-background', 'arras_custom_background' );

	add_action('admin_print_scripts-'. $options_page, 'arras_admin_scripts');
	add_action('admin_print_styles-'. $options_page, 'arras_admin_styles');
	
	add_action('admin_print_scripts-' . $posttax_page, 'arras_admin_scripts');
	add_action('admin_print_styles-' . $posttax_page, 'arras_admin_styles');
	
	add_action('admin_print_scripts-' . $custom_background_page, 'arras_custom_background_scripts');
	add_action('admin_print_styles-' . $custom_background_page, 'arras_custom_background_styles');
}

function arras_admin() {
	global $arras_options, $arras_image_sizes, $notices;

	if ( isset($_GET['page']) && $_GET['page'] == 'arras-options' ) {
		//print_r($_POST);
		
		if ( isset($_REQUEST['save']) ) {
			arras_admin_save();
		}
		
		if ( isset($_REQUEST['reset']) ) {
			arras_admin_reset();
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
		
		if ( isset($_REQUEST['arras-regen-thumbs']) ) {
			check_admin_referer('arras-admin');
			
			echo '<div class="wrap clearfix">';
			screen_icon('themes');
			?> <h2 id="arras-header"><?php _e('Arras Theme Options', 'arras') ?></h2> <?php
			arras_regen_thumbs_process();
			echo '</div>';
			
		} else {
			$arras_image_sizes = array();
			arras_add_default_thumbnails();
			include 'templates/options_page.php';
		}
	}
}

function arras_admin_save() {
	global $arras_options, $arras_image_sizes, $notices;
	check_admin_referer('arras-admin');
	
	if ( isset($_REQUEST['arras-tools-import']) && $_REQUEST['arras-tools-import'] != '' ) {
		$new_arras_options = maybe_unserialize(json_decode($_REQUEST['arras-tools-import']));
		
		if (is_a($new_arras_options, 'Options')) {
			$arras_options = $new_arras_options;
			arras_update_options();
			$notices = '<div class="updated fade"><p>' . __('Your settings have been successfully imported.', 'arras') . '</p></div>';
		}
	} else {
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
		
		// Hack!
		$arras_options->layout = (string)$_POST['arras-layout-col'];
		$arras_image_sizes = array();
		arras_add_default_thumbnails();
		
		$arras_custom_image_sizes = array();
		foreach ($arras_image_sizes as $id => $args) {
			if ( isset($_POST['arras-reset-thumbs']) && $_POST['arras-reset-thumbs'] ) {
				$arras_custom_image_sizes[$id]['w'] = $arras_image_sizes[$id]['dw'];
				$arras_custom_image_sizes[$id]['h'] = $arras_image_sizes[$id]['dh'];
			} else {
				$arras_custom_image_sizes[$id]['w'] = (int)($_POST['arras-' . $id . '-w']);
				$arras_custom_image_sizes[$id]['h'] = (int)($_POST['arras-' . $id . '-h']);
			}
		}
		
		$arras_options->custom_thumbs = $arras_custom_image_sizes;
		$arras_options->save_options();
		arras_update_options();
		
		do_action('arras_admin_save');
		
		$notices = '<div class="updated fade"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
	}
}

function arras_admin_reset() {
	global $notices;
	check_admin_referer('arras-admin');
	
	delete_option('arras_options');
	arras_flush_options();
	
	do_action('arras_admin_reset');
	
	$notices = '<div class="updated fade"><p>' . __('Your settings have been reverted to the defaults.', 'arras') . '</p></div>';
}

function arras_posttax() {
	global $arras_options, $notices;
	
	if ( isset($_GET['page']) && $_GET['page'] == 'arras-posttax' ) {
		if ( isset($_REQUEST['save']) ) {
			
			if ( isset($_REQUEST['type']) && $_REQUEST['type'] == 'posttype' ) {
				$arras_options->save_posttypes();
				arras_update_options();
				do_action('arras_admin_posttype_save');
				$notices = '<div class="updated fade"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
			}
			
			if ( isset($_REQUEST['type']) && $_REQUEST['type'] == 'taxonomy' ) {
				$arras_options->save_taxonomies();
				arras_update_options();
				do_action('arras_admin_taxonomy_save');
				$notices = '<div class="updated fade"><p>' . __('Your settings have been saved to the database.', 'arras') . '</p></div>';
			}
			
		}
	
		if ( isset($_REQUEST['type']) && $_REQUEST['type'] == 'taxonomy' ) {
			include 'templates/taxonomy_page.php';
		} else {
			include 'templates/posttype_page.php';
		}
	}
}

function arras_admin_scripts() {
	wp_enqueue_script('jquery-ui-custom', get_template_directory_uri() . '/js/jquery-ui-1.8.2.custom.min.js', null, 'jquery');
	wp_enqueue_script('arras-admin-js', get_template_directory_uri() . '/js/admin.js');
	wp_enqueue_script('jquery-multiselect', get_template_directory_uri() . '/js/jquery.multiselect.min.js', null, 'jquery');
}

function arras_admin_styles() {
?> 
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/smoothness/jquery-ui-1.8.2.custom.css" type="text/css" /> 
<?php
	if ( is_rtl() ) {
		echo '<link rel="stylesheet" href="' . get_bloginfo('template_directory') . '/css/admin-rtl.css" type="text/css" />';
	} else {
		echo '<link rel="stylesheet" href="' . get_bloginfo('template_directory') . '/css/admin.css" type="text/css" />';
	}
}

function get_remote_array($url) {
	if ( function_exists('wp_remote_request') ) {	
		$options = array();
		$options['headers'] = array(
			'User-Agent' => 'Arras Feed Grabber' . ARRAS_VERSION . '; (' . get_bloginfo('url') .')'
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

function arras_right_col() {
	global $forum_contributors, $translators;
	?>
	<div id="arras-right-col">
		<div class="postbox">
			<h3><span><?php _e('Helpful Links', 'arras') ?></span></h3>
			<ul>
				<li><a href="http://www.arrastheme.com/wiki/doku.php/quick_start_guide"><?php _e('Quick Start Guide', 'arras') ?></a></li>
				<li><a href="http://www.arrastheme.com/forums/"><?php _e('Community Forums', 'arras') ?></a></li>
				<li><a href="http://arras-theme.googlecode.com/"><?php _e('Bug Tracker / Repository', 'arras') ?></a></li>
			</ul>
		</div>
		
		<div class="postbox">
			<h3><span><?php _e('Recommended Plugins', 'arras') ?></span></h3>
			<ul>
				<li><a href="http://lesterchan.net/portfolio/programming/php/#wp-pagenavi">WP-PageNavi</a></li>
				<li><a href="http://blog.moskis.net/downloads/plugins/fancybox-for-wordpress/">FancyBox for WordPress</a></li>
				<li><a href="http://sexybookmarks.net/">SexyBookmarks</a></li>
				<li><a href="http://mitcho.com/code/yarpp/">Yet Another Related Posts Plugin</a></li>
				<li><a href="http://www.dev4press.com/plugins/gd-taxonomies-tools/">GD Custom Posts &amp; Taxonomies Tools</a></li>
			</ul>
		</div>
		
		<?php if ( !arras_get_option('donate') ) : ?>
		<div class="postbox">
			<h3><span><?php _e('How to Support?', 'arras') ?></span></h3>
			<p><?php _e('There are many ways you can support this theme:', 'arras') ?></p>
			<ul>
				<li><?php _e('Share other about the theme', 'arras') ?></li>
				<li><?php _e('Report bugs / Send patches', 'arras') ?></li>
				<li><?php _e('Contribute to the forums / wiki', 'arras') ?></li>
				<li><?php _e('Translate the theme', 'arras') ?></li>
				<li><strong><?php _e('Send in a donation!', 'arras') ?></strong></li>
			</ul>
			<p><a class="button-primary" href="http://www.arrastheme.com/donate/"><?php _e('Donate using PayPal', 'arras') ?></a></p>
		</div>
		<?php endif; ?>
		
		<?php if ( !arras_get_option('donate') ) : ?>
		<div class="postbox">
			<h3><span><?php _e('Thanks!', 'arras') ?></span></h3>
			<p><?php _e('Many thanks to those who have contributed to the theme:', 'arras') ?></p>
			<p><strong><?php _e('Forum Contributors', 'arras') ?></strong><br />
			<?php arras_get_contributors($forum_contributors) ?></p>
			<p><strong><?php _e('Translators', 'arras') ?></strong><br />
			<?php arras_get_contributors($translators) ?></p>
			<div id="donors-list">
			</div>
		</div>
		<?php endif; ?>
		
		<?php do_action('arras_admin_right_col'); ?>

	</div>
	<?php
}

function arras_posttype_blacklist() {
	$_default = array('revision', 'nav_menu_item');
	return apply_filters('arras_posttype_blacklist', $_default);
}

function arras_taxonomy_blacklist() {
	$_default = array();
	return apply_filters('arras_taxonomy_blacklist', $_default);
}

/* End of file admin.php */
/* Location: ./library/admin/admin.php */
