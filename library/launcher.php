<?php
// Redirect to theme options after activation
if (is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	header( 'Location: ' . admin_url() . 'admin.php?page=arras-options' ) ;
}

// Add Theme Support (WordPress 2.9+)
if ( function_exists('add_theme_support') ) {
	add_theme_support('post-thumbnails');
	add_theme_support('nav-menus');
	
	$slideshow_thumb_size = arras_get_slideshow_thumb_size();
	add_image_size( 'featured-slideshow-thumb', $slideshow_thumb_size[0], $slideshow_thumb_size[1], true );
	
	$sidebar_thumb_size = arras_get_sidebar_thumb_size();
	add_image_size( 'sidebar-thumb', $sidebar_thumb_size[0], $sidebar_thumb_size[1], true );
	
	add_image_size( 'featured-post-thumb', arras_get_option('featured_thumb_w'), arras_get_option('featured_thumb_h'), true );
	add_image_size( 'news-post-thumb', arras_get_option('news_thumb_w'), arras_get_option('news_thumb_h'), true );
	add_image_size( 'archive-post-thumb', arras_get_option('news_thumb_w'), arras_get_option('news_thumb_h'), true );
}

// Remove existing actions
remove_action('wp_head', 'pagenavi_css');

// Register Sidebars
register_sidebar( array(
	'name' => 'Primary Sidebar',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );
register_sidebar( array(
	'name' => 'Secondary Sidebar #1',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );
register_sidebar( array(
	'name' => 'Secondary Sidebar #2',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );
register_sidebar( array(
	'name' => 'Bottom Content #1',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );
register_sidebar( array(
	'name' => 'Bottom Content #2',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );
register_sidebar( array(
	'name' => 'Footer',
	'before_widget' => '<li class="widgetcontainer clearfix">',
	'after_widget' => '</div></li>',
	'before_title' => '<h5 class="widgettitle">',
	'after_title' => '</h5><div class="widgetcontent">'
) );

// Registering widgets have been moved to the respective widget files

// Header Actions
if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
	add_action('arras_head', 'arras_add_blueprint_css');
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
}

add_action('arras_head', 'arras_override_styles');
add_action('arras_custom_styles', 'arras_add_custom_logo');

add_action('wp_head', 'arras_head');
add_action('wp_head', 'arras_add_user_css', 100);

// Options
if (is_admin()) {
	add_action('admin_menu', 'arras_addmenu');
}

// Filters
add_filter('gallery_style', 'remove_gallery_css');


/* End of file launcher.php */
/* Location: ./library/launcher.php */
