<?php

$backgrounds = array(
	'black/bars.jpg'		=> 'background: #191919 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/bars.jpg) no-repeat top center',
	'black/metallic.gif'	=> 'background: #121212 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/metallic.gif) repeat-x top center',
	'black/gradient.jpg'		=> 'background: #151515 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/gradient.jpg) repeat-x top center'
);

echo 'body { ' .$backgrounds[ urldecode(arras_get_option('background')) ]. ' !important; }';
