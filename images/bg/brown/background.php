<?php

$backgrounds = array(
	'default/bars.jpg'		=> 'background: #252221 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/bars.jpg) no-repeat top center',
	'default/metallic.gif'	=> 'background: #252221 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/metallic.gif) repeat-x top center',
	'default/gradient.jpg'	=> 'background: #252221 url(' .get_bloginfo('template_url'). '/images/bg/' .arras_get_option('style'). '/gradient.jpg) repeat-x top center'
);

echo 'body { ' .$backgrounds[ urldecode(arras_get_option('background')) ]. '; }';
