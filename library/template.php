<?php

function arras_get_page_no() {
	if ( get_query_var('paged') ) print ' | Page ' . get_query_var('paged');
}

function arras_document_title() {
	if ( function_exists('seo_title_tag') ) {
		seo_title_tag();
	} else if ( class_exists('All_in_One_SEO_Pack') || class_exists('HeadSpace2_Admin') ) {
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

function arras_override_styles() {
?>

<?php global $arras_registered_alt_layouts; if ( count($arras_registered_alt_layouts) > 0 ) : ?>
<link rel="stylesheet" href="<?php bloginfo('template_url') ?>/css/layouts/<?php echo arras_get_option('layout') ?>.css" type="text/css" />
<?php endif; ?>

<?php
	$bg_exists = file_exists(TEMPLATEPATH . '/images/bg/' . arras_get_option('background'));
	if ($bg_exists || arras_get_option('background_color')) {
		echo '<style type="text/css">';
		echo 'body {';
		if ($bg_exists) echo 'background: url(' . get_bloginfo('stylesheet_directory') . '/images/bg/' . arras_get_option('background') . ') ' . arras_get_option('background_tiling') . ' top center;';
		if (arras_get_option('background_color')) echo 'background-color: ' . arras_get_option('background_color') . ';';
		echo '}';
		echo '</style>';
	}
}

function arras_alternate_style() {
	global $theme_data, $arras_registered_alt_styles;
	
	if (ARRAS_CHILD && count($arras_registered_alt_styles) > 0) {
		echo '<link rel="stylesheet=" href="' . get_bloginfo('stylesheet_url') . '" type="text/css" media="screen, projector" />';
	} else {
		echo '
<link rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/blueprint/screen.css" type="text/css" media="screen,projector" />
<link rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/blueprint/print.css" type="text/css" media="print" />
<!--[if IE 6]>
<link rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/blueprint/ie.css" type="text/css" media="screen,projector" />
<![endif]-->
		';

	
		$scheme = arras_get_option('style');
		if ( $scheme != 'default' )
			echo '
<link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/css/styles/' . $scheme . '.css" type="text/css" media="screen,projector" />
			';
		else
			echo '
<link rel="stylesheet" href="' . get_bloginfo('stylesheet_directory') . '/css/styles/default.css" type="text/css" media="screen,projector" />
			';
		
		if (!ARRAS_CHILD) {
			echo '
<link rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/user.css" type="text/css" media="screen,projector" />
';
		}
	}
}

/**
 * Generates semantic classes for BODY element. Based on Sandbox.
 */
function arras_body_class() {
	if ( function_exists('body_class') ) {
		return body_class( array('layout-' . arras_get_option('layout'), 'style-' . arras_get_option('style')) );
	}
	
	global $wp_query, $current_user;
	
	// It's surely a WordPress blog, right?
	$c = array('wordpress');
	
	// Applies the time- and date-based classes (below) to BODY element
	arras_date_classes( time(), $c );

	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
	is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
	is_archive()     ? $c[] = 'archive'    : null;
	is_date()        ? $c[] = 'date'       : null;
	is_search()      ? $c[] = 'search'     : null;
	is_paged()       ? $c[] = 'paged'      : null;
	is_attachment()  ? $c[] = 'attachment' : null;
	is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			arras_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug;
	}

	// Page author for BODY on 'pages'
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages("child_of=$pageID&echo=0");
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$c[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
		if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
			$c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	}

	// Search classes for results or no results
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$c[] = 'search-results';
		} else {
			$c[] = 'search-no-results';
		}
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
		$c[] = 'paged-' . $page;
		if ( is_single() ) {
			$c[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$c[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$c[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$c[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$c[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$c[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$c[] = 'search-paged-' . $page;
		}
	}
	
	// Get current layout
	$c[] = 'layout-' . arras_get_option('layout');
	$c[] = 'style-' . arras_get_option('style');

	// Separates classes with a single space, collates classes for BODY
	$c = join( ' ', apply_filters( 'arras_body_class',  $c ) ); // Available filter: body_class

	// And tada!
	echo 'class="' . $c . '"';
}

function arras_date_classes($t, &$c, $p = '') {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}

function arras_get_thumbnail($w = 630, $h = 250) {
	global $post;
	$thumbnail = get_post_meta($post->ID, ARRAS_POST_THUMBNAIL, true);
	
	if (!$thumbnail) {
		return false;
	} else {
		if (ARRAS_THUMB == 'phpthumb') {
			return get_bloginfo('template_directory') . '/library/phpthumb/phpThumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1';
		} else {
			return get_bloginfo('template_directory') . '/library/timthumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1';
		}
	}
}

function arras_get_posts($page_type, $query = null) {
	global $post, $wp_query;
	if (!$query) $query = $wp_query;
	if ( $query->have_posts() ) : ?>

<?php if (arras_get_option($page_type . '_news_display') == 'traditional') : ?>
	<div class="traditional hfeed">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<div <?php arras_single_post_class() ?>>
        <?php arras_postheader() ?>
		<div class="entry-content"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
		<?php arras_postfooter() ?>
    </div>
	<?php endwhile; ?>
	</div><!-- .traditional -->
<?php elseif (arras_get_option($page_type . '_news_display') == 'line') : ?>
	<ul class="hfeed posts-line clearfix">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<li <?php arras_post_class() ?>>
	
		<?php if(!is_archive()) : ?>
		<span class="entry-cat">
			<?php $cats = get_the_category(); 
			if (arras_get_option('news_cat')) echo $cats[1]->cat_name;
			else echo $cats[0]->cat_name; ?>
		</span>
		<?php endif ?>
		
		<h3 class="entry-title"><a rel="bookmark" href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>"><?php the_title() ?></a></h3>
		<span class="entry-comments"><?php comments_number() ?></span>
	</li>
	<?php endwhile; ?>
	</ul>
<?php else : ?>
	<ul class="hfeed posts-<?php echo arras_get_option($page_type . '_news_display') ?> clearfix">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<li <?php arras_post_class() ?>>
		
		<?php arras_newsheader($page_type) ?>
		<div class="entry-summary"><?php echo arras_strip_content(get_the_excerpt(), 20); ?></div>
		<?php arras_newsfooter($page_type) ?>		
	</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

<?php endif; ?>

<?php
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
			<div class="comment-author vcard">
			<?php echo get_avatar($comment, $size = 24) ?>
			<cite class="fn"><?php echo get_comment_author_link() ?></cite>
			</div>
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<span class="comment-moderation"><?php _e('Your comment is awaiting moderation.', 'arras') ?></span>	
			<?php endif; ?>
			<div class="comment-meta commentmetadata">
				<?php printf( __('Posted %1$s at %2$s', 'arras'), '<abbr class="comment-datetime" title="' . get_comment_time( __('c', 'arras') ) . '">' . get_comment_time( __('F j, Y', 'arras') ), get_comment_time( __('g:i A', 'arras') ) . '</abbr>' ); ?>
			</div>
			<div class="comment-content"><?php comment_text() ?></div>
			<div class="comment-controls">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
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

function arras_js_footer() {
?>

<script type="text/javascript">
jQuery(document).ready(function($) {

<?php if (is_home() || is_front_page()) : ?>
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

<?php endif ?>
	
});
</script>
	
<?php
}

/* End of file template.php */
/* Location: ./library/template.php */
