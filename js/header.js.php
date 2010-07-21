jQuery(document).ready(function($) {

$('.multi-sidebar').tabs();

<?php if (!function_exists('pixopoint_menu')) : ?>
$('.sf-menu').superfish({autoArrows: true, speed: 'fast', dropShadows: 'true'});
<?php endif ?>

<?php if (is_singular()) : ?>
$('#commentform').validate();
<?php endif ?>

<?php do_action('arras_custom_scripts') ?>

});