jQuery(document).ready(function($) {
	$('#multi-sidebar').tabs();
	
	$('#commentform').validate();
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
});