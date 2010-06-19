<?php get_header(); ?>

<?php 
$stickies = get_option('sticky_posts');
rsort($stickies);

$slideshow_cat	= arras_get_option('slideshow_cat');
$featured_cat 	= arras_get_option('featured_cat');
$news_cat 		= arras_get_option('news_cat');

$slideshow_count	= (int)arras_get_option('slideshow_count');
$featured_count 	= (int)arras_get_option('featured_count');
?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php if (!$paged) : ?>

<?php if ( $featured_cat !== '' && arras_get_option('enable_featured') ) : ?>
<?php arras_above_index_featured_post() ?>
<!-- Featured Articles -->
<div id="index-featured">
<?php if ( arras_get_option('featured_title') != '' ) : ?>
	<div class="home-title"><?php _e( arras_get_option('featured_title'), 'arras' ) ?></div>
<?php endif ?>
	<?php
	$featured_offset = 0;
	if ( arras_get_option('featured_offset') && arras_get_option('slideshow_cat') == $featured_cat ) {
		$featured_offset = $slideshow_count;
	}
	$query2 = arras_parse_query($featured_cat, $featured_count, $featured_offset);
	arras_render_posts( apply_filters('arras_featured_query', $query2), arras_get_option('featured_display'), 'featured' );
	?>
</div><!-- #index-featured -->
<?php endif; ?>

<?php if ( arras_get_option('enable_news') ) : ?>
<?php arras_above_index_news_post() ?>
<!-- News Articles -->
<div id="index-news">
<?php if ( arras_get_option('news_title') != '' ) : ?>
<div class="home-title"><?php _e( arras_get_option('news_title') ) ?></div>
<?php endif ?>
<?php
$news_offset = 0;
if ( arras_get_option('news_offset') ) {
	if ($slideshow_cat == $news_cat) {
		$news_offset += $slideshow_count;
	}
	if ($featured_cat == $news_cat) {
		$news_offset += $featured_count;
	}
	$news_offset;
}

$news_query = arras_parse_query($news_cat, ( (arras_get_option('index_count') == 0 ? get_option('posts_per_page') : arras_get_option('index_count')) ), $news_offset);

$news_query .= '&paged=' . $paged;

query_posts( apply_filters('arras_news_query', $news_query) );
arras_render_posts(null, arras_get_option('news_display'), 'news'); ?>

<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
	<div class="navigation clearfix">
		<div class="floatleft"><?php next_posts_link( __('Older Entries', 'arras') ) ?></div>
		<div class="floatright"><?php previous_posts_link( __('Newer Entries', 'arras') ) ?></div>
	</div>
<?php } ?>
</div><!-- #index-news -->
<?php arras_below_index_news_post() ?>
<?php endif; ?>

<?php $sidebars = wp_get_sidebars_widgets(); ?>

<div id="bottom-content-1">
	<?php if ( isset($sidebars['sidebar-4']) ) : ?>
	<ul class="clearfix xoxo">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Content #1') ) : ?>
		<li></li>
        <?php endif; ?>
	</ul>
	<?php endif; ?>
</div>

<div id="bottom-content-2">
	<?php if ( isset($sidebars['sidebar-5']) ) : ?>
	<ul class="clearfix xoxo">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Bottom Content #2') ) : ?>
		<li></li>
        <?php endif; ?>
	</ul>
	<?php endif; ?>
</div>

<?php else: ?>

<div class="home-title"><?php _e('Latest Headlines', 'arras') ?></div>

<div id="archive-posts">
	<?php arras_render_posts(null, arras_get_option('archive_display'), 'archive') ?>    
 
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    	<div class="navigation clearfix">
			<div class="floatleft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
			<div class="floatright"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
		</div>
    <?php } ?>
</div><!-- #archive-posts -->

<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>