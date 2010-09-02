<?php
// Redirect to theme options after activation
if (is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	header( 'Location: ' . admin_url() . 'admin.php?page=arras-options' ) ;
}

// Add Theme Support
add_theme_support('post-thumbnails');
add_theme_support('nav-menus');

if ( function_exists('register_nav_menus') ) {
	register_nav_menus(array(
		'main-menu'	=> __('Main Menu', 'arras'),
		'top-menu'	=> __('Top Menu', 'arras')
	));
}

// Add various default thumbnails used by main theme
arras_add_default_thumbnails();

// Remove existing actions
remove_action('wp_head', 'pagenavi_css');

// Register Sidebars
register_sidebar( array(
	'name' => 'Primary Sidebar',
	'before_widget' => '<li id="%1$s" class="widgetcontainer clearfix">',
	'after_widget' => '</li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5>'
) );
register_sidebar( array(
	'name' => 'Secondary Sidebar #1',
	'before_widget' => '<li id="%1$s" class="widgetcontainer clearfix">',
	'after_widget' => '</li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5>'
) );
register_sidebar( array(
	'name' => 'Bottom Content #1',
	'before_widget' => '<li id="%1$s" class="widgetcontainer clearfix">',
	'after_widget' => '</li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5>'
) );
register_sidebar( array(
	'name' => 'Bottom Content #2',
	'before_widget' => '<li id="%1$s" class="widgetcontainer clearfix">',
	'after_widget' => '</li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5>'
) );

$footer_sidebars = arras_get_option('footer_sidebars');
if ($footer_sidebars == '') $footer_sidebars = 1;

for( $i = 1; $i < $footer_sidebars + 1; $i++ ) {
	register_sidebar( array(
		'name' => 'Footer Sidebar #' . $i,
		'before_widget' => '<li id="%1$s" class="widgetcontainer clearfix">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
}

// Header Actions
if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
	add_action('arras_head', 'arras_add_style_css');
	add_action('arras_custom_styles', 'arras_layout_styles');
}

if ( !defined('ARRAS_INHERIT_LAYOUT') || ARRAS_INHERIT_LAYOUT == true ) {
	add_action('arras_head', 'arras_add_layout_css');
	
	// Alternate Styles & Layouts
	register_alternate_layout( '1c-fixed', __('1 Column Layout (No Sidebars)', 'arras') );
	register_alternate_layout( '2c-r-fixed', __('2 Column Layout (Right Sidebar)', 'arras') );
	register_alternate_layout( '2c-l-fixed', __('2 Column Layout (Left Sidebar)', 'arras') );
	register_alternate_layout( '3c-fixed', __('3 Column Layout (Left & Right Sidebars)', 'arras') );
	register_alternate_layout( '3c-r-fixed', __('3 Column Layout (Right Sidebars)', 'arras') );
	
	register_style_dir(TEMPLATEPATH . '/css/styles/');
}

add_action('arras_head', 'arras_override_styles');
add_action('arras_custom_styles', 'arras_add_custom_logo');
add_action('arras_custom_styles', 'arras_constrain_footer_sidebars');

add_action('arras_beside_nav', 'arras_social_nav');

add_action('wp_head', 'arras_head');
add_action('wp_head', 'arras_add_user_css', 20);
add_action('wp_head', 'arras_add_header_js');

add_filter('arras_postheader', 'arras_post_taxonomies');
if ( defined('ARRAS_CUSTOM_FIELDS') && ARRAS_CUSTOM_FIELDS == true ) {
	add_filter('arras_postheader', 'arras_postmeta');
}

// Options
if (is_admin()) {
	add_action('admin_menu', 'arras_addmenu');
	add_action('wp_ajax_regenthumbnail', 'arras_ajax_process_image');
}

// Filters
add_filter('gallery_style', 'remove_gallery_css');

// print_r($arras_options);

/* End of file launcher.php */
/* Location: ./library/launcher.php */
