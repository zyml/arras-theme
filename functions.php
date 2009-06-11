<?php
wp_enqueue_script('jquery');

// Translate Arras.Theme, if possible
if (class_exists('xili_language')) {
	define('THEME_TEXTDOMAIN', 'arras');
	define('THEME_LANGS_FOLDER', '/language');
} else {
	load_theme_textdomain('arras', get_template_directory() . '/language');
}

// Remove filter on theme options if qTranslate is enabled
if (function_exists('qtrans_init')) {
	remove_filter('option_arras_options', 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage', 0);	
}

$theme_data = get_theme( get_current_theme() );
define( ARRAS_CHILD, (boolean)($theme_data['Parent Theme'] == 'Arras Theme') );

$parent_data = get_theme('Arras Theme');

// Define post meta fields
define( ARRAS_POST_THUMBNAIL, 'thumb' );
define( ARRAS_REVIEW_SCORE, 'score' );
define( ARRAS_REVIEW_PROS, 'pros' );
define( ARRAS_REVIEW_CONS, 'cons' );

// Define thumbnail width and height
define( ARRAS_2COL_MINI_WIDTH, '190' );
define( ARRAS_2COL_MINI_HEIGHT, '100' );

define( ARRAS_2COL_FULL_WIDTH, '630' );
define( ARRAS_2COL_FULL_HEIGHT, '250' );

define( ARRAS_3COL_MINI_WIDTH, '220' );
define( ARRAS_3COL_MINI_HEIGHT, '100' );

define( ARRAS_3COL_FULL_WIDTH, '480' );
define( ARRAS_3COL_FULL_HEIGHT, '225' );

// Define PHP file constants
define( ARRAS_DIR, TEMPLATEPATH );
define( ARRAS_LIB, ARRAS_DIR . '/library' );
define( ARRAS_VERSION, $parent_data['Version'] );

// Thumbnail generator
define( ARRAS_THUMB, 'timthumb' );

// Load library files
require_once ARRAS_LIB . '/actions.php';
require_once ARRAS_LIB . '/filters.php';
require_once ARRAS_LIB . '/template.php';
require_once ARRAS_LIB . '/styles.php';

require_once ARRAS_LIB . '/widgets-legacy.php';

require_once ARRAS_LIB . '/admin/options.php';
arras_flush_options();

if ( is_admin() ) require_once ARRAS_LIB . '/admin/admin.php';

require_once ARRAS_LIB . '/launcher.php';
?>