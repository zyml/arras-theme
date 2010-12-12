<?php
define('HEADER_IMAGE', '');
define('HEADER_IMAGE_WIDTH', 970);
define('HEADER_IMAGE_HEIGHT', 150);
define('HEADER_TEXTCOLOR', 'FFFFFF');

function header_style() {
?>
	<style type="text/css">
		#nav  { width: 980px; min-width: 980px !important; margin: 0 auto; }
		#header  { width: 970px; min-width: 970px !important; border: 5px solid #333 !important; margin: 20px auto 0; height: 150px; background: url(<?php header_image() ?>) no-repeat !important; }
		#header .logo  { max-width: 960px; width: 960px; margin: 0; padding: 0; }
		#header .blog-name  { font-size: 22px; margin: 100px 0 0; display: block; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; float: left; }
		#header .blog-name a { text-decoration: none; display: inline-block; background: #000; padding: 10px; opacity: 0.8; }
		#header .blog-description  { margin: 100px 0 0; font-size: 11px; font-weight: bold; color: #AAA; padding: 10px; background: #000; display: inline-block; opacity: 0.8; float: right; }
	</style>
<?php
}

function admin_header_style() {
?>
	<style type="text/css">
	#headimg { width: 980px; margin: 20px 0; padding: 0; background: #1E1B1A; font-family: 'Segoe UI', Arial, Helvetica, sans-serif; line-height: 1em; }
	#headimg h1 { font-size: 22px; margin: 100px 0 0; display: block; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; float: left; }
	#headimg h1 a { text-decoration: none; display: inline-block; background: #000; padding: 15px; opacity: 0.8; }
	#headimg #desc { margin: 100px 0 0; font-size: 11px; font-weight: bold; color: #AAA; padding: 10px; background: #000; display: inline-block; opacity: 0.8; float: right; }
	</style>
<?php
}

if (arras_get_option('header_mode') == 'custom-header') {
	add_custom_image_header('header_style', 'admin_header_style');
}