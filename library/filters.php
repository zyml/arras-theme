<?php
function legacy_comments($file) {
	if ( function_exists('wp_list_comments') ) 
		return $file;
}

/* Remove Gallery CSS to make code more compliant */
function remove_gallery_css() {
	return '<div class="gallery">';	
}

/**
 * Called to display post heading for news in index and archive pages
 * @since 1.2.2
 */
function arras_newsheader($page_type) {
	global $post;
	
	$postheader = '<div class="entry-thumbnails">';
	$postheader .= '<a class="entry-thumbnails-link" href="' . get_permalink() . '">';

	if ( ($thumbnail = arras_get_thumbnail($page_type . '-post-thumb')) ) {	
		$postheader .= '<img src="' . $thumbnail . '" alt="' . get_the_title() . '" title="' . get_the_title()	. '" />';	
	} else {
		$postheader .= '<span style="display: none">' . get_the_title() . '</span>';
	}
	
	$postheader .= '</a>';
	
	if ( arras_get_option($page_type . '_display_meta_inpic') ) {	
		$postheader .= '<span class="entry-meta"><a href="' . get_permalink() . '"><span class="entry-comments">' . get_comments_number() . '</span></a>';
		$postheader .= '<abbr class="published" title="' . get_the_time('c') . '">' . get_the_time( get_option('date_format') ) . '</abbr></span>';
	}
	
	$postheader .= '</div>';
	
	$postheader .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
	
	echo apply_filters('arras_newsheader', $postheader);
}

/**
 * Called to display post footer for news in index and archive pages
 * @since 1.2.2
 */
function arras_newsfooter($page_type) {
	global $post;
	
	$postfooter = '';
	if ( arras_get_option($page_type . '_news_display') == 'quick' ) {
		$postfooter .= '<p class="quick-read-more"><strong><a href="' . get_permalink() . '">' . __('Read More', 'arras') . '</a></strong></p>';
	}
	echo apply_filters('arras_newsfooter', $postfooter);
}

/**
 * Called to display post heading for news in single posts
 * @since 1.2.2
 */
function arras_postheader() {
	global $post, $id;
	
	if ( is_single() ) {
		if ( is_attachment() ) $postheader .= '<h1 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h1>';
		else $postheader = '<h1 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h1>';
	} else {
		if ( is_attachment() ) $postheader .= '<h2 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h2>';
		else $postheader = '<h2 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h2>';		
	}
	
	$postheader .= '<div class="entry-info">';

	
	if ( !is_page() ) {
		if ( arras_get_option('post_author') ) {
			$postheader .= sprintf( __('<span class="entry-author">By %s</span>', 'arras'), '<address class="author vcard">' . get_the_author() . '</address>' );
		}
		
		if ( arras_get_option('post_date') ) {
			$postheader .= sprintf( __('<strong>Published:</strong> %s', 'arras'), '<abbr class="published" title="' . get_the_time('c') . '">' . get_the_time( get_option('date_format') ) . '</abbr>');
		}
		
		if ( arras_get_option('post_cats') ) {
			$post_cats = array();
			$cats = get_the_category();
			foreach ($cats as $c) $post_cats[] = $c->cat_name;
			
			$postheader .= sprintf( __('<span class="entry-cat"><strong>Posted in: </strong>%s</span>', 'arras'), implode(', ', $post_cats) );
		}
		
		if ( arras_get_option('post_tags') && !is_attachment() )
			$postheader .= '<span class="tags"><strong>' . __('Tags:', 'arras') . '</strong>' . get_the_tag_list(' ', ', ', ' ') . '</span>';
		
		
	}
	
	if (current_user_can('edit_post')) {
		$postheader .= '<a class="post-edit-link" href="' . get_edit_post_link($id) . '" title="' . __('Edit Post', 'arras') . '">' . __('Edit Post', 'arras') . '</a>';
	}
	
	$postheader .= '</div>';
	
	echo apply_filters('arras_postheader', $postheader);
}

/**
 * Called to display post footer for news in single posts
 * @since 1.2.2
 */
function arras_postfooter() {
	global $id, $post;

	echo apply_filters('arras_postfooter', $postfooter);
}

/**
 * Called to display post meta information in single posts (review scores, product information, etc.)
 * @since 1.2.2
 */
function arras_postmeta($content) {
	global $post;

	$postmeta = '';
	
	$custom_fields_list = arras_parse_single_custom_fields();
	
	if ($custom_fields_list) {
		foreach($custom_fields_list as $field_id => $field_name) {
			if ( $field_value = get_post_meta($post->ID, $field_id, true) ) {
				$postmeta .= '<div class="single-post-meta clearfix">';
				$postmeta .= '<span class="single-post-meta-field single-post-meta-' . $field_id . '">' . $field_name . ':</span>';
				$postmeta .= '<span class="single-post-meta-value single-post-meta-' . $field_id . '-value">' . $field_value . '</span>';
				$postmeta .= '</div>';
			}
		}
	}
	
	if ( arras_get_option('single_meta_pos') == 'bottom' ) return $postmeta . $content;
	else return $content . $postmeta;
}

/**
 * Displays when the specified post/archive requested by the user is not found.
 * @since	1.2.2
 */
function arras_post_notfound() {
	$postcontent = '<h2>' . __('That \'something\' you are looking for isn\'t here!', 'arras') . '</h2>';
	$postcontent .= '<p>' . __('<strong>We\'re very sorry, but that page doesn\'t exist or has been moved.</strong><br />Please make sure you have the right URL.', 'arras') . '</p>';
	
	echo apply_filters('arras_post_notfound', $postcontent);	
}

/* End of file filters.php */
/* Location: ./library/filters.php */
