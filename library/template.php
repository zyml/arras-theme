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

<style type="text/css">
<?php
$featured_thumb_w = arras_get_option('featured_thumb_w');
$featured_thumb_h = arras_get_option('featured_thumb_h');
?>
#index-featured .posts-default .post	{ width: <?php echo $featured_thumb_w ?>px; }
#index-featured .posts-default img, #index-featured .entry-thumbnails-link	{ width: <?php echo $featured_thumb_w ?>px; height: <?php echo $featured_thumb_h ?>px; }
#index-featured .entry-thumbnails	{ width: <?php echo $featured_thumb_w ?>px; height: <?php echo $featured_thumb_h ?>px; }
#index-featured .posts-default .entry-meta, #index-featured .posts-quick .entry-meta	{ width: <?php echo $featured_thumb_w ?>px; }
#index-featured .posts-quick .entry-meta	{ margin: <?php echo $featured_thumb_h - 25 ?>px 0 0 -<?php echo $featured_thumb_w + 15 ?>px; }
<?php
$news_thumb_w = arras_get_option('news_thumb_w');
$news_thumb_h = arras_get_option('news_thumb_h');
?>
#index-news .posts-default .post, #archive-posts .posts-default .post	{ width: <?php echo $news_thumb_w ?>px; }
#index-news .posts-default img, #index-news .entry-thumbnails-link, #archive-posts .posts-default img, #archive-posts .entry-thumbnails-link	{ width: <?php echo $news_thumb_w ?>px; height: <?php echo $news_thumb_h ?>px; }
#index-news .entry-thumbnails, #archive-posts .entry-thumbnails	{ width: <?php echo $news_thumb_w ?>px; }
#index-news .posts-default .entry-meta, #index-news .posts-quick .entry-meta, #archive-posts .posts-default .entry-meta, #archive-posts .posts-quick .entry-meta	{ width: <?php echo $news_thumb_w ?>px; }
#index-news .posts-quick .entry-meta, #archive-posts .posts-quick .entry-meta	{ margin: <?php echo $news_thumb_h - 25 ?>px 0 0 -<?php echo $news_thumb_w + 15 ?>px; }

<?php $layout = arras_get_option('layout') ?>

<?php if (strpos($layout, '1c') !== false) : ?>
.featured, .featured-article { height: 300px; }
.featured-article { width: 940px; }
#controls { width: 920px; padding-top: 120px; }
.featured-entry	{ height: 100px; top: 200px; }
<?php elseif (strpos($layout, '3c') !== false) : ?>
.featured, .featured-article { height: 225px; }
.featured-article { width: 490px; }
#controls { width: 470px; padding-top: 70px; }
.featured-entry	{ height: 100px; top: 125px; }
<?php endif ?>

</style>

<?php
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
 * Generates semantic classes for BODY element.
 * Sandbox's version was removed from 1.4 onwards.
 */
function arras_body_class() {
	if ( function_exists('body_class') ) {
		return body_class( array('layout-' . arras_get_option('layout'), 'style-' . arras_get_option('style')) );
	}
}

function arras_get_thumbnail($size = 'thumbnail', $id = 1) {
	global $post;	
	if ($post) $id = $post->ID;
	
	// get post thumbnail (WordPress 2.9+)
	if ( function_exists('has_post_thumbnail') && has_post_thumbnail($id) ) {
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size );
		return $image_src[0];
	} else {
	// go back to legacy (phpThumb or timThumb)
		$thumbnail = get_post_meta($id, ARRAS_POST_THUMBNAIL, true);
		
		if (!$thumbnail) {
			return false;
		} else {
		
			switch($size) {
				case 'sidebar-thumb':
					$w = 36;
					$h = 36;
					break;
				case 'featured-slideshow-thumb':
					$w = 640;
					$h = 250;
					break;
				case 'featured-post-thumb':
					$w = arras_get_option('featured_thumb_w');
					$h = arras_get_option('featured_thumb_h');
					break;
				case 'news-post-thumb':
					$w = arras_get_option('news_thumb_w');
					$h = arras_get_option('news_thumb_h');				
					break;
				default:
					$w = get_option('thumbnail_size_w');
					$h = get_option('thumbnail_size_h');
			}
			
			return get_bloginfo('template_directory') . '/library/timthumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1';
		}
		
	}
	
}

function arras_get_posts($page_type, $query = null) {
	global $post, $wp_query;
	
	if ($page_type == 'archive') $page_type = 'news';
	
	if (!$query) $query = $wp_query;
	if ( $query->have_posts() ) : ?>

<?php if (arras_get_option($page_type . '_display') == 'traditional') : ?>
	<div class="traditional hfeed">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<div <?php arras_single_post_class() ?>>
        <?php arras_postheader() ?>
		<div class="entry-content"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
		<?php arras_postfooter() ?>
    </div>
	<?php endwhile; ?>
	</div><!-- .traditional -->
<?php elseif (arras_get_option($page_type . '_display') == 'line') : ?>
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
	<ul class="hfeed posts-<?php echo arras_get_option($page_type . '_display') ?> clearfix">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<li <?php arras_post_class() ?>>
		
		<?php arras_newsheader($page_type) ?>
		<div class="entry-summary">
			<?php 
			if ( arras_get_option($page_type . '_display') == 'default' ) {
				//echo arras_strip_content(get_the_excerpt(), 20);
				echo get_the_excerpt();
			} else {
				echo get_the_excerpt();
				?>
				<p class="quick-read-more"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>">
				<?php _e('Read More', 'arras') ?>
				</a></p>
				<?php
			}
			?>
		</div>
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
			<div class="comment-controls">
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</div>
			<div class="comment-author vcard">
			<?php echo get_avatar($comment, $size = 48) ?>
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
