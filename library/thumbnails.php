<?php

/**
 * Containers for storing thumbnail types and its default sizes.
 * @since 1.4.4
 */
$arras_image_sizes = array();

function arras_add_default_thumbnails() {
	
	$single_thumbs = arras_get_single_thumbs_size();
	arras_add_image_size( 'single-thumb', __('Single Post Thumbnail', 'arras'), $single_thumbs[0], $single_thumbs[1] );
	arras_add_image_size( 'sidebar-thumb', __('Sidebar Widgets', 'arras'), 36, 36);	
	
	do_action('arras_add_default_thumbnails');
}

/**
 * Function to add image size into both theme system.
 * @since 1.4.4
 */
function arras_add_image_size($id, $name, $default_width, $default_height) {
	global $arras_image_sizes;
	
	$arras_custom_image_sizes = arras_get_option('custom_thumbs');
	
	// Check from options if a custom width and height has been specified, else use defaults
	if (isset($arras_custom_image_sizes[$id])) {
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
	
	return (isset($arras_image_sizes[$id])) ? $arras_image_sizes[$id] : false;
}


/**
 * Helper function to grab and display thumbnail from specified post
 * @since 1.4.0
 */
function arras_get_thumbnail($size = 'thumbnail', $id = NULL) {
	global $post, $arras_image_sizes;
	
	$empty_thumbnail = '<img src="' . get_template_directory_uri() . '/images/thumbnail.png" alt="' . get_the_excerpt() . '" title="' . get_the_title() . '" />';
	
	if ($post) $id = $post->ID;
	
	// get post thumbnail (WordPress 2.9)
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail($id)) {
			return get_the_post_thumbnail( $id, $size, array(
				'alt' 	=> get_the_excerpt(), 
				'title' => get_the_title()
			) );
		} else {
			// Could it be an attachment?
			if ($post->post_type == 'attachment') {
				return wp_get_attachment_image( $id, $size, false, array(
					'alt' 	=> get_the_excerpt(), 
					'title' => get_the_title()
				) );
			}		
			// Use first thumbnail if auto thumbs is enabled.
			if (arras_get_option('auto_thumbs')) {
				$img_id = arras_get_first_post_image_id();
				if (!$img_id) return $empty_thumbnail;
				
				return wp_get_attachment_image($img_id, $size, false, array(
					'alt' 	=> get_the_excerpt(), 
					'title' => get_the_title()
				) );
			}
		}
	}
	
	return $empty_thumbnail;	
}

/**
 * Function to retrieve the first image ID from post.
 * @since 1.5.0
 */
function arras_get_first_post_image_id($id = NULL) {
	global $post;
	if (!$id) $id = $post->ID;
	
	$attachments = get_children('post_parent=' . $id . '&post_type=attachment&post_mime_type=image');
	if (!$attachments) return false;
	
	$keys = array_reverse(array_keys($attachments));
	return $keys[0];
}

function arras_get_single_thumbs_size() {
	$layout = arras_get_option('layout');

	if ( strpos($layout, '1c') !== false ) {
		$size = array(930, 375);
	} else if ( strpos($layout, '3c') !== false ) {
		$size = array(465, 190);
	} else {
		$size = array(620, 300);
	}
	
	return apply_filters('arras_content_width', $size);
}

/* End of file thumbnails.php */
/* Location: ./library/thumbnails.php */
