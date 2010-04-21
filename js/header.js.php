jQuery(document).ready(function($) {

$('.multi-sidebar').tabs();

<?php if (!function_exists('wp_nav_menu') && !function_exists('pixopoint_menu')) : ?>
$('.sf-menu').superfish({autoArrows: false, speed: 'fast', dropShadows: 'true'});
<?php endif ?>

<?php if (is_singular()) : ?>
$('#commentform').validate();
<?php endif ?>

$('.posts-default').equalHeights();
$('#footer-sidebar').equalHeights();

$('.posts-default .entry-thumbnails-link').hover(
	function() {
		$(this).animate({"opacity": "1"}, 'fast');
	},
	function() {
		$(this).animate({"opacity": "0.7"}, 'fast');
	}
);

<?php do_action('arras_custom_scripts') ?>

});