<?php
$notices = ''; // store notices here so that options_page.php will echo it out later

function arras_addmenu() {
	$options_page = add_menu_page( '', __('Arras', 'arras'), 'edit_theme_options', 'arras-options', 'arras_admin', get_template_directory_uri() . '/images/icon.png', 63);
	add_submenu_page( 'arras-options', __('Arras Options', 'arras'), __('Theme Options', 'arras'), 'edit_theme_options', 'arras-options', 'arras_admin' );
	
	$posttax_page = add_submenu_page( 'arras-options', __('Post Types & Taxonomies', 'arras'), __('Post Types & Tax.', 'arras'), 'edit_theme_options', 'arras-posttax', 'arras_posttax' );
	
	// $custom_background_page = add_submenu_page( 'arras-options', __('Custom Background', 'arras'), __('Custom Background', 'arras'), 'edit_theme_options', 'arras-custom-background', 'arras_custom_background' );

	add_action('admin_print_scripts-'. $options_page, 'arras_admin_scripts');
	add_action('admin_print_styles-'. $options_page, 'arras_admin_styles');
	
	add_action('admin_print_scripts-' . $posttax_page, 'arras_admin_scripts');
	add_action('admin_print_styles-' . $posttax_page, 'arras_admin_styles');
	
	// add_action('admin_print_scripts-' . $custom_background_page, 'arras_custom_background_scripts');
	// add_action('admin_print_styles-' . $custom_background_page, 'arras_custom_background_styles');
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
		
		if ( isset( $_REQUEST['arras-regen-thumbs'] ) && is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
			check_admin_referer('arras-admin');
			?>
			<script type="text/javascript">
				window.location = '<?php echo admin_url( 'tools.php?page=regenerate-thumbnails' ) ?>';
			</script>
			<?php
		} else {
			if ( !is_plugin_active( 'regenerate-thumbnails/regenerate-thumbnails.php' ) ) {
				$notices = '<div class="error fade"><p>' . __( '<strong>Notice:</strong> Having <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin installed and activated is highly recommended for Arras.', 'arras' ) . '</p></div>';
			}
			
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
	wp_enqueue_script( 'jquery-multiselect', get_template_directory_uri() . '/js/jquery.multiselect.min.js', null, 'jquery' );
	wp_enqueue_script( 'arras-admin-js', get_template_directory_uri() . '/js/admin.js', array('jquery', 'jquery-ui-core', 'jquery-ui-tabs') );
}

function arras_admin_styles() {
	wp_enqueue_style( 'jquery-smoothness', get_template_directory_uri() . '/css/smoothness/jquery-ui-1.8.2.custom.css', false, '2011-12-12', 'all' );
	if ( is_rtl() )
		wp_enqueue_style( 'arras-admin', get_template_directory_uri() . '/css/admin-rtl.css', false, '2011-12-12', 'all' );
	else
		wp_enqueue_style( 'arras-admin', get_template_directory_uri() . '/css/admin.css', false, '2011-12-12', 'all' );
}

function get_remote_array($url) {
	if ( function_exists('wp_remote_request') ) {	
		$options = array();
		$options['headers'] = array(
			'User-Agent' => 'Arras Feed Grabber' . ARRAS_VERSION . '; (' . home_url() .')'
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
	if ( !is_array($arr) ) return false;
	
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
	$forum_contributors = array(
		'Giovanni' => 'http://www.animeblog.nl/',
		'Bobby Clapp' => 'http://profaneentertainment.com/gaming',
		'Charles' => 'http://www.claireraborar.com/travel',
		'Nedrago' => 'http://www.nedrago.com/',
		'Dan' => 'http://www.techunfolding.com/'
	);
	$translators = array(
		'Bestmoose (Dutch)' => 'http://www.arrastheme.com/forums/topic3369-1501-german-translation-deutsche-uebersetzung.html',
		'Drun Ming Haung (Traditional Chinese)' => 'http://www.arrastheme.com/forums/topic2956-1501-chinese-traditional-translation-zhtw.html',
		'carlosmarchi (Brazilian Portuguese)' => 'http://www.arrastheme.com/forums/topic3401-1501-brazilian-portuguese-ptbr-pack.html',
		'PressPlay (Norwegian)' => 'http://www.arrastheme.com/forums/topic3736-1501-norwegian-nb-translation-norsk-bokmal-oversettingnbno.html',
		'Bob Robot (Simplified Chinese)' => 'http://www.arrastheme.com/forums/topic4412-1501-simplified-chinese-translation-zhcn.html',
		'edvind (Swedish)' => 'http://www.arrastheme.com/forums/topic3627-1501-swedish-translation-svensk-oeversaettning.html',
		'Celso Azevedo (Portuguese)' => 'http://www.arrastheme.com/forums/topic3658-1501-portuguese-portugal-translation-traducao-portuguesa.html',
		'Sokac (Croatian)' => 'http://www.arrastheme.com/forums/topic3219-1501-croatian-translation-hrvatski-prijevod.html',
		'Berniru (Russian)' => 'http://www.arrastheme.com/forums/topic3202-1501-russkii-perevod-russian-translation.html',
		'vicsabi (Hungarian)' => 'http://www.arrastheme.com/forums/topic6561-1501-hungarian-translation-magyar-forditas.html',
		'vfenix (Spanish)' => 'http://www.arrastheme.com/forums/topic3549-1501-spanish-translation-traduccion-espanola.html'
	);
	
	?>
	<div id="arras-right-col">
		<div class="postbox">
			<h3><span><?php _e('Helpful Links', 'arras') ?></span></h3>
			<ul>
				<li><a href="http://www.arrastheme.com/wiki/doku.php/quick_start_guide"><?php _e('Quick Start Guide', 'arras') ?></a></li>
				<li><a href="http://www.arrastheme.com/forums/"><?php _e('Community Forums', 'arras') ?></a></li>
				<li><a href="https://github.com/zyml/arras-theme"><?php _e('Arras on GitHub', 'arras') ?></a></li>
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
