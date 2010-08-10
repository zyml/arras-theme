<?php
/* Remove Gallery CSS to make code more compliant */
function remove_gallery_css() {
	return '<div class="gallery">';	
}

/**
 * Called to display post heading for news in single posts
 * @since 1.2.2
 */
function arras_postheader() {
	global $post, $id;
	
	$postheader = '';
	
	if ( is_single() || is_page() ) {
	
		if ( is_attachment() ) {
			$postheader .= '<h1 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h1>';
		} else {
			$postheader .= '<h1 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h1>';
		}
		
	} else {

		if ( is_attachment() ) {
			$postheader .= '<h2 class="entry-title">' . get_the_title() . ' [<a href="' . get_permalink($post->post_parent) . '" rev="attachment">' . get_the_title($post->post_parent) . '</a>]</h2>';
		} else {
			if (!is_page()) $postheader .= '<a class="entry-comments" href="' . get_comments_link() . '">' . get_comments_number() . '</a>';
			$postheader .= '<h2 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h2>';
		}
	}
	
	if ( !is_page() ) {
		$postheader .= '<div class="entry-info">';
	
		if ( arras_get_option('post_author') ) {
			$postheader .= sprintf( __('<div class="entry-author">By %s</div>', 'arras'), '<address class="author vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta('ID') ) . '" title="' . esc_attr(get_the_author()) . '">' . get_the_author() . '</a></address>' );
		}
		
		if ( arras_get_option('post_date') ) {
			$postheader .= ' &ndash; <abbr class="published" title="' . get_the_time('c') . '">' . get_the_time(get_option('date_format')) . '</abbr>';
		}
		
		if (current_user_can('edit_post')) {
			$postheader .= '<a class="post-edit-link" href="' . get_edit_post_link($id) . '" title="' . __('Edit Post', 'arras') . '">' . __('(Edit Post)', 'arras') . '</a>';
		}
		
		if ( !is_attachment() && arras_get_option('post_cats') ) {
			$post_cats = array();
			$cats = get_the_category();
			foreach ($cats as $c) $post_cats[] = '<a href="' . get_category_link($c->cat_ID) . '">' . $c->cat_name . '</a>';
			
			$postheader .= sprintf( __('<span class="entry-cat"><strong>Posted in: </strong>%s</span>', 'arras'), implode(', ', $post_cats) );
		}
		
		$postheader .= '</div>';
	}
	
	if ( arras_get_option('single_thumbs') && has_post_thumbnail($post->ID) ) {
		$postheader .= '<div class="entry-photo">' . arras_get_thumbnail('single-thumb') . '</div>';
	}

	echo apply_filters('arras_postheader', $postheader);
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
				$postmeta .= '<span class="single-post-meta-field single-post-meta-' . $field_id . '">' . $field_name . '</span>';
				$postmeta .= '<span class="single-post-meta-value single-post-meta-' . $field_id . '-value">' . $field_value . '</span>';
				$postmeta .= '</div>';
			}
		}
	}
	
	if ( arras_get_option('single_meta_pos') == 'bottom' ) return $postmeta . $content;
	else return $content . $postmeta;
}

/**
 * Called to display custom taxonomies in single posts (review scores, product information, etc.)
 * @since 1.5
 */
function arras_post_taxonomies($content) {
	global $post;
	$postmeta = '';
	
	if (arras_get_option('single_custom_taxonomies') == '') return $content;
	
	$arr = explode( ',', arras_get_option('single_custom_taxonomies') );
	$final = array();
	
	if ( !is_array($arr) ) return $content;
	
	foreach($arr as $term) {
		$term_list = get_the_term_list($post->ID, $term, '', ', ', '');
		$term_obj = get_taxonomy($term);
		
		if ( !is_wp_error($term_list) && !empty($term_list) ) {
			$postmeta .= '<div class="single-post-meta clearfix">';
			$postmeta .= '<span class="single-post-meta-field single-post-meta-' . $term . '">' . $term_obj->labels->name . ':</span>';
			$postmeta .= '<span class="single-post-meta-value single-post-meta-' . $term . '-value">' . $term_list  . '</span>';
			$postmeta .= '</div>';
		}
	}
	
	return $content . $postmeta;
}


/**
 * Called to display post footer for news in single posts
 * @since 1.2.2
 */
function arras_postfooter() {
	global $id, $post;
	
	$postfooter = '';
	
	if ( arras_get_option('post_tags') && !is_attachment() && is_array(get_the_tags()) )
			$postfooter .= '<div class="tags"><strong>' . __('Tags:', 'arras') . '</strong>' . get_the_tag_list(' ', ', ', ' ') . '</div>';

	echo apply_filters('arras_postfooter', $postfooter);
}

/**
 * Displays when the specified post/archive requested by the user is not found.
 * @since	1.2.2
 */
function arras_post_notfound() {
	$postcontent = '<div class="single-post">';
	$postcontent .= '<h1 class="entry-title">' . __('That \'something\' you are looking for isn\'t here!', 'arras') . '</h2>';
	$postcontent .= '<div class="entry-content"><p>' . __('<strong>We\'re very sorry, but the page that you are looking for doesn\'t exist or has been moved.</strong>', 'arras') . '</p>';
	
	
	$postcontent .= '<form method="get" class="clearfix" action="' . get_bloginfo('url') . '">
	' . __('Perhaps searching for it might help?', 'arras') . '<br />
	<input type="text" value="" name="s" class="s" size="30" onfocus="this.value=\'\'" />
	<input type="submit" class="searchsubmit" value="' . __('Search', 'arras') . '" title="' . sprintf( __('Search %s', 'arras'), wp_specialchars( get_bloginfo('name'), 1 ) ) . '" />
	</form>';
	
	$postcontent .= '<h3>Latest Posts</h3>';
	$postcontent .= '<ul>';
	$postcontent .= wp_get_archives('type=postbypost&limit=10&format=custom&before=<li>&after=</li>&echo=0');
	$postcontent .= '</ul>';
	$postcontent .= '</div></div>';
	
	echo apply_filters('arras_post_notfound', $postcontent);	
}

/**
 * Displays author information after post content. Can be turned off in theme options.
 * @since 1.4.4
 */
function arras_post_aboutauthor() {
	$id = get_the_author_meta('ID');
	
	$output = '
		<div class="about-author clearfix">
			<a href="' . get_author_posts_url($id) . '">' . get_avatar($id, 64) . '</a>
			<div class="author-meta">
				<h4>' . sprintf(__('About %s', 'arras'),  get_the_author_meta('display_name')) . '</h4>
			' . get_the_author_meta('description') . '
			</div>
		</div>
	';
	
	echo apply_filters('arras_post_aboutauthor', $output);
}

/* End of file filters.php */
/* Location: ./library/filters.php */
