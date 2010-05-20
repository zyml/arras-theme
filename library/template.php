<?php

function arras_get_page_no() {
	if ( get_query_var('paged') ) print ' | Page ' . get_query_var('paged');
}

function arras_document_title() {
	if ( function_exists('seo_title_tag') ) {
		seo_title_tag();
	} else if ( class_exists('All_in_One_SEO_Pack') || class_exists('HeadSpace2_Admin') || class_exists('Platinum_SEO_Pack') ) {
		if(is_front_page() || is_home()) {
			echo get_bloginfo('name') . ': ' . get_bloginfo('description');
		} else {
			wp_title('');
		}
	} else {
		if ( is_attachment() ) { bloginfo('name'); print ' | '; single_post_title(''); }
		elseif ( is_single() ) { single_post_title(); }
        elseif ( is_home() ) { bloginfo('name'); print ' | '; bloginfo('description'); arras_get_page_no(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . wp_specialchars($s); arras_get_page_no(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title('|'); arras_get_page_no(); }
	}
}

function arras_document_description() {
	if ( !class_exists('All_in_One_SEO_Pack') || !class_exists('Platinum_SEO_Pack') ) {
		echo '<meta name="description" content="' . get_bloginfo('description') . '" />';
	}
}

/**
 * Generates semantic classes for BODY element.
 * Sandbox's version was removed from 1.4 onwards.
 */
function arras_body_class() {
	if ( function_exists('body_class') ) {
		return body_class( array('layout-' . arras_get_option('layout'), 'style-' . arras_get_option('style'), 'no-js') );
	}
}

function arras_get_thumbnail($size = 'thumbnail', $id = NULL) {
	global $post;
	if ($post) $id = $post->ID;
	
	// get post thumbnail (WordPress 2.9)
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail($id)) {
			return get_the_post_thumbnail($id, $size);
		}
	}
	
	// go back to legacy (phpThumb or timThumb)
	$thumbnail = get_post_meta($id, ARRAS_POST_THUMBNAIL, true);
	
	if ($thumbnail != '') {
		switch($size) {
			case 'sidebar-thumb':
				$sidebar_thumb_size = arras_get_sidebar_thumb_size();
				$w = $sidebar_thumb_size[0];
				$h = $sidebar_thumb_size[1];
				break;
			case 'featured-slideshow-thumb':
				$slideshow_thumb_size = arras_get_slideshow_thumb_size();
				$w = $slideshow_thumb_size[0];
				$h = $slideshow_thumb_size[1];
				break;
			case 'featured-post-thumb':
				$w = arras_get_option('featured_thumb_w');
				$h = arras_get_option('featured_thumb_h');
				break;
			case 'news-post-thumb':
				$w = arras_get_option('news_thumb_w');
				$h = arras_get_option('news_thumb_h');				
				break;
			case 'archive-post-thumb':
				$w = arras_get_option('news_thumb_w');
				$h = arras_get_option('news_thumb_h');				
				break;
			default:
				$w = get_option('thumbnail_size_w');
				$h = get_option('thumbnail_size_h');
		}
		
		return '<img src="' . get_bloginfo('template_directory') . '/library/timthumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
	}
	
	return '<img src="' . get_bloginfo('template_directory') . '/images/thumbnail.png" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';	
}


function arras_render_posts($args = null, $display_type = 'default', $page_type = 'news') {
	global $post, $wp_query, $arras_tapestries;
	
	if (!$args) {
		$query = $wp_query;
	} else {
		$query = new WP_Query($args);
	}
	
	if ($query->have_posts()) {	
		call_user_func_array( $arras_tapestries[$display_type]['callback'], array($query, $page_type) );
	}
	
	wp_reset_query();
}

function arras_list_trackbacks($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID() ?>">
		<div id="trackback-<?php comment_ID(); ?>">
		<?php echo get_comment_author_link() ?>
		</div>
<?php
}

function arras_list_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div class="comment-node" id="comment-<?php comment_ID(); ?>">
			<div class="comment-controls">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<div class="comment-author vcard">
			<?php echo get_avatar($comment, $size = 32) ?>
			<cite class="fn"><?php echo get_comment_author_link() ?></cite>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="comment-moderation"><?php _e('Your comment is awaiting moderation.', 'arras') ?></span>	
			<?php endif; ?>
			<div class="comment-meta commentmetadata">
				<?php printf( __('Posted %1$s at %2$s', 'arras'), '<abbr class="comment-datetime" title="' . get_comment_time( __('c', 'arras') ) . '">' . get_comment_time( __('F j, Y', 'arras') ), get_comment_time( __('g:i A', 'arras') ) . '</abbr>' ); ?>
			</div>
			<div class="comment-content"><?php comment_text() ?></div>
		</div>
<?php	
}

function arras_post_class() {
	if ( function_exists('post_class') )
		return post_class('clearfix');
	else return 'class="clearfix"';
}

function arras_single_post_class() {
	if ( function_exists('post_class') )
		return post_class(array('clearfix', 'single-post'));
	else return 'class="single-post clearfix"';
}

function arras_parse_single_custom_fields() {
	$arr = explode( ',', arras_get_option('single_custom_fields') );
	$final = array();
	
	if ( !is_array($arr) ) return false;
	
	foreach ( $arr as $val ) {
		$field_arr = explode(':', $val);
		$final[ $field_arr[1] ] = $field_arr[0];
	}
	
	return $final;
}

function arras_strip_content($content, $limit) {
	$content = apply_filters('the_content', $content);
	
	$content = strip_tags($content);
	$content = str_replace(']]>', ']]&gt;', $content);
	
	$words = explode(' ', $content, ($limit + 1));
	if(count($words) > $limit) {
		array_pop($words);
		//add a ... at last article when more than limit word count
		return implode(' ', $words) . '...'; 
	} else {
		//otherwise
		return implode(' ', $words); 
	}
}

function arras_get_sidebar_thumb_size() {
	$_default_size = array(36, 36);
	return apply_filters('arras_sidebar_thumb_size', $_default_size);
}

function arras_excerpt_more($excerpt) {
	return str_replace(' [...]', '...', $excerpt);
}
add_filter('excerpt_more', 'arras_excerpt_more');

function arras_excerpt_length($length) {
	return 45;
}
add_filter('excerpt_length', 'arras_excerpt_length');

/* End of file template.php */
/* Location: ./library/template.php */
