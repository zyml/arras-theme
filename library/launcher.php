<?php

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
add_action('arras_head', 'arras_override_styles');

// Footer Actions
add_action('wp_footer', 'arras_js_footer');

// Options
if (is_admin()) {
	add_action('admin_menu', 'arras_addmenu');
}

// Alternate Styles & Layouts
if (!ARRAS_CHILD) {
	//register_alternate_layout( '1c-fixed', __('1 Column Layout (No Sidebars)', 'arras') );
	register_alternate_layout( '2c-r-fixed', __('2 Column Layout (Right Sidebar)', 'arras') );
	register_alternate_layout( '2c-l-fixed', __('2 Column Layout (Left Sidebar)', 'arras') );
	register_alternate_layout( '3c-fixed', __('3 Column Layout (Left & Right Sidebars)', 'arras') );
	register_alternate_layout( '3c-r-fixed', __('3 Column Layout (Right Sidebars)', 'arras') );
}

// Filters
add_filter('comments_template', 'legacy_comments');
add_filter('gallery_style', 'remove_gallery_css');


/* End of file launcher.php */
/* Location: ./library/launcher.php */
