<?php

define ( 'ARRAS_CHILD', is_child_theme() );
define ( 'ARRAS_VERSION' , '1.5.3' );
define ( 'ARRAS_LIB', TEMPLATEPATH . '/library' );

do_action('arras_init');

/**
 * Theme setup function - to be run during 'after_setup_theme' action hook.
 * @since 1.6
 */
add_action( 'after_setup_theme', 'arras_setup' );

if ( !function_exists('arras_setup') ) :

function arras_setup() {
	/* Load theme options (to be revamped) */
	require_once ARRAS_LIB . '/admin/options.php';
	require_once ARRAS_LIB . '/admin/templates/functions.php';
	arras_flush_options();
	
	/* Load theme library files */
	require_once ARRAS_LIB . '/actions.php';
	require_once ARRAS_LIB . '/deprecated.php';
	require_once ARRAS_LIB . '/filters.php';
	require_once ARRAS_LIB . '/tapestries.php';
	require_once ARRAS_LIB . '/template.php';
	require_once ARRAS_LIB . '/thumbnails.php';
	require_once ARRAS_LIB . '/styles.php';
	require_once ARRAS_LIB . '/slideshow.php';
	require_once ARRAS_LIB . '/widgets.php';
	
	if ( is_admin() ) {
		require_once ARRAS_LIB . '/admin/admin.php';
	}
	
	//require_once ARRAS_LIB . '/admin/background.php';
	
	/* Post meta fields */
	define( 'ARRAS_REVIEW_SCORE', 'score' );
	define( 'ARRAS_REVIEW_PROS', 'pros' );
	define( 'ARRAS_REVIEW_CONS', 'cons' );
	
	define( 'ARRAS_CUSTOM_FIELDS', false );
	
	/* Langauge support */
	load_theme_textdomain( 'arras', TEMPLATEPATH . '/language' );
	
	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );
	
	/* Theme support */
	add_theme_support('post-thumbnails');
	add_theme_support('nav-menus');
	add_theme_support('automatic-feed-links');
	add_theme_support('custom-background');
	
	/* Menus locations */
	register_nav_menus(array(
		'main-menu'	=> __('Main Menu', 'arras'),
		'top-menu'	=> __('Top Menu', 'arras')
	));
	
	/* Thumbnail sizes */
	arras_add_default_thumbnails();
	
	/* Register sidebars */
	arras_add_sidebars();
	
	/* Custom layouts & styles */
	if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
		add_action( 'arras_custom_styles', 'arras_layout_styles' );
	}
	
	if ( !defined('ARRAS_INHERIT_LAYOUT') || ARRAS_INHERIT_LAYOUT == true ) {
		// Alternate Styles & Layouts
		register_alternate_layout( '1c-fixed', __('1 Column Layout (No Sidebars)', 'arras') );
		register_alternate_layout( '2c-r-fixed', __('2 Column Layout (Right Sidebar)', 'arras') );
		register_alternate_layout( '2c-l-fixed', __('2 Column Layout (Left Sidebar)', 'arras') );
		register_alternate_layout( '3c-fixed', __('3 Column Layout (Left & Right Sidebars)', 'arras') );
		register_alternate_layout( '3c-r-fixed', __('3 Column Layout (Right Sidebars)', 'arras') );
		
		register_style_dir( TEMPLATEPATH . '/css/styles/' );
	}
	
	/* Header actions */
	remove_action( 'wp_head', 'pagenavi_css' );
	
	add_action( 'arras_head', 'arras_override_styles' );
	
	add_action( 'arras_custom_styles', 'arras_add_custom_logo' );
	add_action( 'arras_custom_styles', 'arras_constrain_footer_sidebars' );
	
	add_action( 'arras_beside_nav', 'arras_social_nav' );
	
	add_action( 'wp_head', 'arras_load_styles', 1 );
	add_action( 'wp_head', 'arras_head' );
	
	add_action( 'wp_head', 'arras_add_facebook_share_meta' );
	
	add_action( 'wp_head', 'arras_add_header_js' );
	add_action( 'wp_footer', 'arras_add_footer_js' );
	
	/* Filters */
	add_filter( 'arras_postheader', 'arras_post_taxonomies' );
	add_filter( 'gallery_style', 'remove_gallery_css' );
	
	if ( defined('ARRAS_CUSTOM_FIELDS') && ARRAS_CUSTOM_FIELDS == true ) {
		add_filter( 'arras_postheader', 'arras_postmeta' );
	}
	
	/* Admin actions */
	if (is_admin()) {
		add_action( 'admin_menu', 'arras_addmenu' );
	}
	
	/* Max image size */
	$max_image_size = arras_get_single_thumbs_size();
	$content_width = $max_image_size[0];
	
	/* For child themes overrides */
	do_action( 'arras_setup' );
	
	// print_r($arras_options);
}

endif;

/**
 * Sidebar setup function.
 * @since 1.6
 */
function arras_add_sidebars() {
	
	/* Default sidebars */
	register_sidebar( array(
		'name' => 'Primary Sidebar',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Secondary Sidebar #1',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Bottom Content #1',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	register_sidebar( array(
		'name' => 'Bottom Content #2',
		'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
		'after_widget' => '</li>',
		'before_title' => '<h5 class="widgettitle">',
		'after_title' => '</h5>'
	) );
	
	/* Footer sidebars (Up to 4 sidebars based on user preference) */
	$footer_sidebars = arras_get_option('footer_sidebars');
	if ($footer_sidebars == '') $footer_sidebars = 1;
	
	for( $i = 1; $i < $footer_sidebars + 1; $i++ ) {
		register_sidebar( array(
			'name' => 'Footer Sidebar #' . $i,
			'before_widget' => '<li id="%1$s" class="%2$s widgetcontainer clearfix">',
			'after_widget' => '</li>',
			'before_title' => '<h5 class="widgettitle">',
			'after_title' => '</h5>'
		) );
	}
			
}
 
/* End of file functions.php */
/* Location: ./functions.php */