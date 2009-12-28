jQuery(document).ready(function($) {

$('#multi-sidebar').tabs();

<?php if (!function_exists('pixopoint_menu')) : ?>
$('.sf-menu').superfish({autoArrows: false, speed: 'fast', dropShadows: 'true'});
<?php endif ?>

<?php if (is_singular()) : ?>
$('#commentform').validate();
<?php endif ?>
	
});

Cufon.replace('.blog-name');