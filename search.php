<?php get_header(); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php if (have_posts()) : ?>
<div class="search-results">
    <h2><?php _e('Search Results', 'arras') ?></h2>
    <div class="search-results-content clearfix">
	<p><?php printf( __('Search Results for <strong>&#8216;' . '%s' . '&#8217;</strong></p>', 'arras'), wp_specialchars($s, 1) ) ?>
    <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div>
</div>

<?php arras_get_posts('archive') ?>

<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    <div class="navigation">
		<div class="floatRight"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
		<div class="floatLeft"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
    </div>
<?php } ?>

<?php else: ?>

<div class="search-results">
    <h2>Search Results</h2>
    <div class="search-results-content clearfix">
    <p><?php _e('<strong>Sorry, we couldn\'t find any results based on your search query.</strong>', 'arras') ?></p>
    <?php include (TEMPLATEPATH . '/searchform.php'); ?>
    </div>
</div> 

<h2 class="feed-title"><?php _e('Blog Archive', 'arras') ?></h2>
<?php query_posts(''); ?>
<?php arras_get_posts('archive') ?>
    
<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    <div class="navigation clearfix">
		<div class="floatLeft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
		<div class="floatRight"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
    </div>
<?php } ?>  
<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>