jQuery(document).ready(function($) {

$('.multi-sidebar').tabs();

$('.sf-menu').superfish({autoArrows: true, speed: 'fast', dropShadows: 'true'});

<?php if (is_singular()) : ?>
$('#commentform').validate();
<?php endif ?>

<?php do_action('arras_custom_scripts') ?>

});