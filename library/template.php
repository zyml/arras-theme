<?php

function arras_get_page_no() {
	if ( get_query_var('paged') ) print ' | Page ' . get_query_var('paged');
}

/**
 * SEO-Friendly title tag, based on Thematic Framework, which is based on Tarski :)
 */
function arras_document_title() {
	$site_name = get_bloginfo('name');
	$separator = '|';
	
	if ( is_single() ) {
      $content = single_post_title('', FALSE);
    }
    elseif ( is_home() || is_front_page() ) { 
      $content = get_bloginfo('description');
    }
    elseif ( is_page() ) { 
      $content = single_post_title('', FALSE); 
    }
    elseif ( is_search() ) { 
      $content = __('Search Results for:', 'arras'); 
      $content .= ' ' . esc_html(stripslashes(get_search_query()), true);
    }
    elseif ( is_category() ) {
      $content = __('Category Archives:', 'arras');
      $content .= ' ' . single_cat_title("", false);;
    }
    elseif ( is_tag() ) { 
      $content = __('Tag Archives:', 'arras');
      $content .= ' ' . arras_tag_query();
    }
    elseif ( is_404() ) { 
      $content = __('Not Found', 'arras'); 
    }
    else { 
      $content = get_bloginfo('description');
    }

    if (get_query_var('paged')) {
      $content .= ' ' .$separator. ' ';
      $content .= 'Page';
      $content .= ' ';
      $content .= get_query_var('paged');
    }

    if($content) {
      if ( is_home() || is_front_page() ) {
          $elements = array(
            'site_name' => $site_name,
            'separator' => $separator,
            'content' => $content
          );
      }
      else {
          $elements = array(
            'content' => $content
          );
      }  
    } else {
      $elements = array(
        'site_name' => $site_name
      );
    }

    // Filters should return an array
    $elements = apply_filters('arras_doctitle', $elements);
	
    // But if they don't, it won't try to implode
    if(is_array($elements)) {
      $doctitle = implode(' ', $elements);
    }
    else {
      $doctitle = $elements;
    }
    
	echo $doctitle;
}

function arras_add_header_js() {
	?>
	<script type="text/javascript">
	<?php @include ARRAS_DIR . '/js/header.js.php'; ?>
	</script>
	<?php
}

/**
 * Based on Thematic's thematic_tag_query()
 */
function arras_tag_query() {
	$nice_tag_query = get_query_var('tag'); // tags in current query
	$nice_tag_query = str_replace(' ', '+', $nice_tag_query); // get_query_var returns ' ' for AND, replace by +
	$tag_slugs = preg_split('%[,+]%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of tag slugs
	$tag_ops = preg_split('%[^,+]*%', $nice_tag_query, -1, PREG_SPLIT_NO_EMPTY); // create array of operators

	$tag_ops_counter = 0;
	$nice_tag_query = '';

	foreach ($tag_slugs as $tag_slug) { 
		$tag = get_term_by('slug', $tag_slug ,'post_tag');
		// prettify tag operator, if any
		if ( isset($tag_ops[$tag_ops_counter]) && $tag_ops[$tag_ops_counter] == ',') {
			$tag_ops[$tag_ops_counter] = ', ';
		} elseif ( isset($tag_ops[$tag_ops_counter]) && $tag_ops[$tag_ops_counter] == '+') {
			$tag_ops[$tag_ops_counter] = ' + ';
		} else {
			$tag_ops[$tag_ops_counter] = '';
		}
		// concatenate display name and prettified operators
		$nice_tag_query = $nice_tag_query.$tag->name.$tag_ops[$tag_ops_counter];
		$tag_ops_counter += 1;
	}
	 return $nice_tag_query;
}

/**
 * SEO-Friendly META description, based on Thematic Framework.
 */
function arras_document_description() {
	if ( class_exists('All_in_One_SEO_Pack') || class_exists('Platinum_SEO_Pack') ) return false;
	
	if ( is_single() || is_page() ) {
		if ( have_posts() ) {
			while( have_posts() ) {
				the_post();
				echo '<meta name="description" content="' . get_the_excerpt() . '" />';
			}
		}
	} else {
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

function arras_render_posts($args = null, $display_type = 'default', $taxonomy = 'category') {
	global $post, $wp_query, $arras_tapestries;
	
	if (!$args) {
		$query = $wp_query;
	} else {
		$query = new WP_Query($args);
	}
	
	if ($query->have_posts()) {	
		arras_get_tapestry_callback($display_type, $query, $taxonomy);
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

function arras_parse_query($list, $count, $exclude = null, $post_type = '', $taxonomy = '') {
	$query = array();
	
	if ($post_type == '') $post_type = 'post';
	if ($taxonomy == '') $taxonomy = 'category';
	
	if ($list != false) {
		if ((array)$list !== $list) {
			$list = array($list);
		}
		
		if ( in_array('-5', $list) ) {
			$stickies = get_option('sticky_posts');
			rsort($stickies);
			if (count($stickies) > 0) {
				$query['post__in'] = $stickies;
			} else {
				// if no sticky posts are available, return empty value
				return false;
			}
		
			$key = array_search('-5', $list);
			unset($list[$key]);
		}
	
		switch($taxonomy) {
			case 'category':
				if ( ($zero_cat = array_search('0', $list)) === true )
					unset($list[$zero_cat]);
					
				$query['category__in'] = $list;
				break;
			case 'post_tag':
				$query['tag__in'] = $list;
				break;
			default:
				$list = implode($list, ',');
				$query[$taxonomy] = $list;
		}

	}
	
	$query['post_type'] = $post_type;
	$query['posts_per_page'] = $count;
	
	if (is_home() && arras_get_option('hide_duplicates')) {
		$query['post__not_in'] = $exclude;
	}

	//print_r($query);
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

function arras_blacklist_duplicates() {
	global $post, $post_blacklist;
	if (is_home() && arras_get_option('hide_duplicates')) {
		$post_blacklist[] = $post->ID;
	}
}

function arras_constrain_footer_sidebars() {
	$footer_sidebars = arras_get_option('footer_sidebars');
	if ($footer_sidebars == '') $footer_sidebars = 1;
	
	$width = ceil(920 / $footer_sidebars);
	?>
	.footer-sidebar  { width: <?php echo $width ?>px; }
	<?php
}

function arras_nav_fallback_cb() {
	echo '<ul class="sf-menu menu clearfix">';
	wp_list_categories('hierarchical=1&orderby=id&hide_empty=1&title_li=');	
	echo '</ul>';
}

/* End of file template.php */
/* Location: ./library/template.php */
