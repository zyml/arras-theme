<?php get_header(); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php is_tag(); if ( have_posts() ) : ?>
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

	<?php if ( is_category() ) : ?>
        <h1 class="feed-title"><?php printf( __('%s Archive', 'arras'), single_cat_title() ) ?></h1>
    <?php elseif ( is_tag() ) : ?>
        <h1 class="feed-title"><?php printf( __('%s Archive', 'arras'), single_tag_title() ) ?></h1>
    <?php elseif ( is_day() ) : ?>
        <h1 class="feed-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('F jS, Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_month() ) : ?>
        <h1 class="feed-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('F, Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_year() ) : ?>
        <h1 class="feed-title"><?php printf( __('Archive for %s', 'arras'), get_the_time( __('Y', 'arras') ) ) ?></h1>
    <?php elseif ( is_author() ) : ?>
        <h1 class="feed-title"><?php _e('Author Archive', 'arras') ?></h1>
    <?php else : ?>
        <h1 class="feed-title"><?php _e('Archives', 'arras') ?></h1>
    <?php endif; ?>
    
	<?php arras_get_posts('archive') ?>    
 
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    	<div class="navigation clearfix">
			<div class="floatLeft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
			<div class="floatRight"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
		</div>
    <?php } ?>  
<?php else : ?>
	<?php arras_post_notfound() ?>
<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>