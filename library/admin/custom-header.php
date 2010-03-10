<?php
define('HEADER_IMAGE', '');
define('HEADER_IMAGE_WIDTH', 980);
define('HEADER_IMAGE_HEIGHT', 80);
define('HEADER_TEXTCOLOR', 'FFFFFF');

function header_style() {
?>
	<style type="text/css">
	#branding { background: url(<?php header_image() ?>) no-repeat; }
	<?php if (get_header_textcolor() != 'blank') : ?>
	.blog-name, .blog-name a, .blog-description { color: #<?php header_textcolor() ?> !important; }
	<?php else: ?>
	.blog-name, .blog-name a, .blog-description { display: none; }
	<?php endif; ?>
	.blog-description { opacity: 0.5; zoom: 1; filter: alpha(opacity = 50); }
	</style>
<?php
}

function admin_header_style() {
?>
	<style type="text/css">
	#headimg { width: 980px; margin: 20px 0; padding: 0 0 20px; background: #1E1B1A; }
	#headimg h1 { font-family: 'Segoe UI', Arial, Helvetica, sans-serif; font-size: 22px; margin: 0; padding: 21px 0 3px 10px; line-height: 1em; display: block; text-transform: uppercase; letter-spacing: 1px; font-weight: bold; }
	#headimg h1 a { text-decoration: none; }
	#headimg #desc { font-family: 'Segoe UI', Arial, Helvetica, sans-serif; line-height: 1em; display: block; font-size: 11px; font-weight: bold; color: #7d716d; margin: 0; padding: 3px 0 0 10px; text-transform: uppercase; opacity: 0.5; zoom: 1; filter: alpha(opacity = 50); }
	</style>
<?php
}

if (function_exists('add_custom_image_header')) {
	add_custom_image_header('header_style', 'admin_header_style');
}

?>