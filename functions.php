<?php
wp_enqueue_script('jquery');

// Translate Arras.Theme, if possible
if (class_exists('xili_language')) {
	define('THEME_TEXTDOMAIN', 'arras');
	define('THEME_LANGS_FOLDER', '/language');
} else {
	load_theme_textdomain('arras', get_template_directory() . '/language');
}

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/language/$locale.php";
if ( is_readable( $locale_file ) ) require_once( $locale_file );

// Remove filter on theme options if qTranslate is enabled
if (function_exists('qtrans_init')) {
	remove_filter('option_arras_options', 'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage', 0);	
}

$parent_data = get_theme_data(TEMPLATEPATH . '/style.css');
$child_data = get_theme_data(STYLESHEETPATH . '/style.css');
define( 'ARRAS_CHILD', (boolean)($child_data['Template'] != '') );

// Define post meta fields
define( 'ARRAS_POST_THUMBNAIL', 'thumb' );
define( 'ARRAS_REVIEW_SCORE', 'score' );
define( 'ARRAS_REVIEW_PROS', 'pros' );
define( 'ARRAS_REVIEW_CONS', 'cons' );

// Define PHP file constants
define( 'ARRAS_DIR', TEMPLATEPATH );
define( 'ARRAS_LIB', ARRAS_DIR . '/library' );
define( 'ARRAS_VERSION', $parent_data['Version'] );

// Thumbnail generator (legacy)
define( 'ARRAS_THUMB', 'timthumb' );

// Add support for custom fields
define( 'ARRAS_CUSTOM_FIELDS', false );

// Load library files
require_once ARRAS_LIB . '/admin/options.php';
require_once ARRAS_LIB . '/admin/templates/functions.php';
arras_flush_options();

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
	require_once ARRAS_LIB . '/admin/thumbnails.php';
}

require_once ARRAS_LIB . '/admin/background.php';
require_once ARRAS_LIB . '/launcher.php';

// Max. Image Size
$max_image_size = arras_get_single_thumbs_size();
$content_width = $max_image_size[0];

do_action('arras_init');

/* End of file functions.php */
/* Location: ./functions.php */