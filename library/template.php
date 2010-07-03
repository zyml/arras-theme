<?php

function arras_get_page_no() {
	if ( get_query_var('paged') ) print ' | Page ' . get_query_var('paged');
}

function arras_document_title() {
	if ( function_exists('seo_title_tag') ) {
		seo_title_tag();
	} else if ( class_exists('All_in_One_SEO_Pack') || class_exists('HeadSpace2_Admin') || class_exists('Platinum_SEO_Pack') ) {
		if(is_front_page() || is_home()) {
			echo get_bloginfo('name') . ' | ' . get_bloginfo('description');
		} else {
			wp_title('');
		}
	} else {
		if ( is_attachment() ) { bloginfo('name'); print ' | '; single_post_title(''); }
		elseif ( is_single() ) { single_post_title(); }
        elseif ( is_home() ) { bloginfo('name'); print ' | '; bloginfo('description'); arras_get_page_no(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s); arras_get_page_no(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
        else { bloginfo('name'); wp_title(' | '); arras_get_page_no(); }
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
		$body_class = array('layout-' . arras_get_option('layout'), 'no-js');
		
		if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
			$body_class[] = 'style-' . arras_get_option('style');
		}	
		
		return body_class( apply_filters('arras_body_class', $body_class) );
	}
}

function arras_render_posts($args = null, $display_type = 'default', $page_type = 'news') {
	global $post, $wp_query, $arras_tapestries;
	
	if (!$args) {
		$query = $wp_query;
	} else {
		$query = new WP_Query($args);
	}
	
	if ($query->have_posts()) {	
		arras_get_tapestry_callback($display_type, $query, $page_type);
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
	return post_class( apply_filters('arras_post_class', 'clearfix') );
}

function arras_single_post_class() {
	return post_class( apply_filters('arras_single_post_class', array('clearfix', 'single-post')) );
}

function arras_parse_single_custom_fields() {
	if (arras_get_option('single_custom_fields') == '') return false;
	
	$arr = explode( ',', arras_get_option('single_custom_fields') );
	$final = array();
	
	if ( !is_array($arr) ) return false;
	
	foreach ( $arr as $val ) {
		$field_arr = explode(':', $val);
		$final[ $field_arr[1] ] = $field_arr[0];
	}
	
	return $final;
}

function arras_excerpt_more($excerpt) {
	return str_replace(' [...]', '...', $excerpt);
}
add_filter('excerpt_more', 'arras_excerpt_more');

function arras_excerpt_length($length) {
	if (!arras_get_option('excerpt_limit')) $limit = 30;
	else $limit = arras_get_option('excerpt_limit');
	
	return $limit;
}
add_filter('excerpt_length', 'arras_excerpt_length');

function arras_parse_query($list, $count, $offset = null) {
	$query = '';
	
	if ((array)$list === $list) {
	
		if ( in_array('-5', $list) ) {
			$stickies = get_option('sticky_posts');
			rsort($stickies);
			if (count($stickies) > 0) {
				$s = implode(',', $stickies);
				$query .= 'p=' . $s . '&';
			} else {
				// if no sticky posts are available, return empty value
				return false;
			}
			
			$key = array_search('-5', $list);
			unset($list[$key]);
		}
		
		$c = implode(',', $list);
		if ($c) $query .= 'cat=' . $c . '&';
	}
	
	$query .= 'showposts=' . $count;
	
	if ($offset > 0) $query .= '&offset=' . $offset;
	
	return $query;
}

function arras_social_nav() {
	$feed = arras_get_option('feed_url');
	$comments_feed = arras_get_option('comments_feed_url');
?>
	<ul class="quick-nav clearfix">
		<?php if ($feed == '') : ?>
			<li><a id="rss" title="<?php printf( __( '%s RSS Feed', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php bloginfo('rss2_url'); ?>"><?php _e('RSS Feed', 'arras') ?></a></li>
		<?php else : ?>
			<li><a id="rss" title="<?php printf( __( '%s RSS Feed', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $feed; ?>"><?php _e('RSS Feed', 'arras') ?></a></li>
		<?php endif; ?>
		
		<?php $twitter_username = arras_get_option('twitter_username'); ?>
		<?php if ($twitter_username != '') : ?>
			<li><a id="twitter" title="<?php printf( __( '%s Twitter', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="http://www.twitter.com/<?php echo $twitter_username ?>/" target="_blank"><?php _e('Twitter', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php $facebook_profile = arras_get_option('facebook_profile'); ?>
		<?php if ($facebook_profile != '') : ?>
			<li><a id="facebook" title="<?php printf( __( '%s Facebook', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" href="<?php echo $facebook_profile ?>" target="_blank"><?php _e('Facebook', 'arras') ?></a></li>
		<?php endif ?>
		
		<?php do_action('arras_quick_nav'); // hook to include additional social icons, etc. ?>
	</ul>
<?php
}

function arras_add_searchbar() {
	?><div id="searchbar"><?php get_search_form() ?></div><?php
}


/* End of file template.php */
/* Location: ./library/template.php */
