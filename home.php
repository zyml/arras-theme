<?php get_header(); ?>

<?php 
$stickies = get_option('sticky_posts');
rsort($stickies);

$slideshow_cat	= arras_get_option('slideshow_cat');
$featured1_cat 	= arras_get_option('featured1_cat');
$featured2_cat 	= arras_get_option('featured2_cat');
$news_cat 		= arras_get_option('news_cat');

$slideshow_count	= (int)arras_get_option('slideshow_count');
$featured1_count 	= (int)arras_get_option('featured1_count');
$featured2_count 	= (int)arras_get_option('featured2_count');

$post_blacklist = array();
?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php if (!$paged) : ?>

<?php if ( $featured1_cat !== '' && arras_get_option('enable_featured1') ) : ?>
<?php arras_above_index_featured1_post() ?>
<!-- Featured Articles #1 -->
<div id="index-featured1">
<?php if ( arras_get_option('featured1_title') != '' ) : ?>
	<div class="home-title"><?php _e( arras_get_option('featured1_title'), 'arras' ) ?></div>
<?php endif ?>
	<?php
	$query2 = arras_parse_query($featured1_cat, $featured1_count, array_unique($post_blacklist), arras_get_option('featured1_posttype'), arras_get_option('featured1_tax'));
	arras_render_posts( apply_filters('arras_featured1_query', $query2), arras_get_option('featured1_display'), arras_get_option('featured1_tax') );
	?>
</div><!-- #index-featured1 -->
<?php endif; ?>

<?php if ( $featured2_cat !== '' && arras_get_option('enable_featured2') ) : ?>
<?php arras_above_index_featured2_post() ?>
<!-- Featured Articles #2 -->
<div id="index-featured2">
<?php if ( arras_get_option('featured2_title') != '' ) : ?>
	<div class="home-title"><?php _e( arras_get_option('featured2_title'), 'arras' ) ?></div>
<?php endif ?>
	<?php
	$query3 = arras_parse_query($featured2_cat, $featured2_count, array_unique($post_blacklist), arras_get_option('featured2_posttype'), arras_get_option('featured2_tax'));
	arras_render_posts( apply_filters('arras_featured2_query', $query3), arras_get_option('featured2_display'), arras_get_option('featured2_tax') );
	?>
</div><!-- #index-featured2 -->
<?php endif; ?>

<?php if ( arras_get_option('enable_news') ) : ?>
<?php arras_above_index_news_post() ?>
<!-- News Articles -->
<div id="index-news">
<?php if ( arras_get_option('news_title') != '' ) : ?>
<div class="home-title"><?php _e( arras_get_option('news_title') ) ?></div>
<?php endif ?>
<?php
$news_query = arras_parse_query($news_cat, ( (arras_get_option('index_count') == 0 ? get_option('posts_per_page') : arras_get_option('index_count')) ), array_unique($post_blacklist), arras_get_option('news_posttype'), arras_get_option('news_tax'));

$news_query['paged'] = $paged;

query_posts( apply_filters('arras_news_query', $news_query) );
arras_render_posts( null, arras_get_option('news_display'), arras_get_option('news_tax') ); ?>
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
	<?php arras_render_posts(null, arras_get_option('archive_display')) ?>    
 
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    	<div class="navigation clearfix">
			<div class="floatleft"><?php next_posts_link( __('Older Entries', 'arras') ) ?></div>
			<div class="floatright"><?php previous_posts_link( __('Newer Entries', 'arras') ) ?></div>
		</div>
    <?php } ?>
</div><!-- #archive-posts -->

<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->
    
<?php get_sidebar(); ?>
<?php get_footer(); ?>