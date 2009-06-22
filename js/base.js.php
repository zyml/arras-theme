jQuery(document).ready(function($) {

	<?php if (!function_exists('pixopoint_menu')) : ?>
	$('.sf-menu').superfish({autoArrows: false, speed: 'fast'});
	<?php endif ?>

	<?php if (is_singular()) : ?>
	$('#commentform').validate();
	<?php endif ?>
	
	<?php if (is_home() || is_front_page()) : ?>
	$('.featured').hover( 
		function() {
			$('#featured-slideshow').cycle('pause');
			$('#controls').fadeIn();
		}, 
		function() {
			$('#featured-slideshow').cycle('resume');
			$('#controls').fadeOut();
		}
	);
	$('#featured-slideshow').cycle({
		fx: 'fade',
		speed: 250,
		next: '#controls .next',
		prev: '#controls .prev',
		timeout: 6000
	});
	
	<?php endif ?>
	
});