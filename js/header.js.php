jQuery(document).ready(function($) {

$('#multi-sidebar').tabs();

<?php if (!function_exists('pixopoint_menu')) : ?>
$('.sf-menu').superfish({autoArrows: false, speed: 'fast', dropShadows: 'true'});
<?php endif ?>

<?php if (is_singular()) : ?>
$('#commentform').validate();
<?php endif ?>

$('.posts-default').equalHeights();
$('#footer ul').equalHeights();

});