<?php

/**
 * Containers for storing thumbnail types and its default sizes.
 * @since 1.4.4
 */
$arras_image_sizes = array();
$arras_custom_image_sizes = arras_get_option('custom_thumbs');

/**
 * Function to add image size into both theme system.
 * @since 1.4.4
 */
function arras_add_image_size($id, $name, $default_width, $default_height) {
	global $arras_image_sizes, $arras_custom_image_sizes;
	
	// Check from options if a custom width and height has been specified, else use defaults
	if ($arras_custom_image_sizes && $arras_custom_image_sizes[$id]) {
		$width = $arras_custom_image_sizes[$id]['w'];
		$height = $arras_custom_image_sizes[$id]['h'];
	} else {
		$width = $default_width;
		$height = $default_height;
	}
	
	$arras_image_sizes[$id] = array(
		'name' 	=> $name, 
		'w' 	=> $width, 
		'h' 	=> $height,
		'dw' 	=> $default_width,
		'dh' 	=> $default_height
	);
	
	add_image_size($id, $width, $height, true);
}

/**
 * Function to remove image size into both theme system.
 * @since 1.4.4
 */
function arras_remove_image_size($id) {
	global $arras_image_sizes, $_wp_additional_image_sizes;
	
	unset($arras_images_sizes[$id]);
	unset($_wp_additional_image_sizes[$id]);
}

/**
 * Function to get image size's name, width and height, default or custom.
 * @since 1.4.4
 */
function arras_get_image_size($id) {
	global $arras_image_sizes;
	return $arras_image_sizes[$id];
}


/**
 * Helper function to grab and display thumbnail from specified post
 * @since 1.4.0
 */
function arras_get_thumbnail($size = 'thumbnail', $id = NULL) {
	global $post, $arras_image_sizes;
	
	if ($post) $id = $post->ID;
	
	// get post thumbnail (WordPress 2.9)
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail($id)) {
			return get_the_post_thumbnail( $id, $size, array(
				'alt' 	=> get_the_excerpt(), 
				'title' => get_the_title()
			) );
		}
	}
	
	// go back to legacy (phpThumb or timThumb)
	$thumbnail = get_post_meta($id, ARRAS_POST_THUMBNAIL, true);
	
	if ($thumbnail != '') {
		
		if (!$arras_image_sizes[$size]) return false;
		
		$w = $arras_image_sizes[$size]['w'];
		$h = $arras_image_sizes[$size]['h'];
		
		return '<img src="' . get_bloginfo('template_directory') . '/library/timthumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1" alt="' . get_the_excerpt() . '" title="' . get_the_title() . '" />';
	}
	
	return '<img src="' . get_bloginfo('template_directory') . '/images/thumbnail.png" alt="' . get_the_excerpt() . '" title="' . get_the_title() . '" />';	
}

/* End of file thumbnails.php */
/* Location: ./library/thumbnails.php */
