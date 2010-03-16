<?php get_header(); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<?php 
if ( arras_get_option('single_meta_pos') == 'bottom' ) add_filter('arras_postfooter', 'arras_postmeta');
else add_filter('arras_postheader', 'arras_postmeta');
?>

<?php if (have_posts()) : the_post(); ?>
	<?php arras_above_post() ?>
	<div id="post-<?php the_ID() ?>" <?php arras_single_post_class() ?>>

        <?php arras_postheader() ?>

		<div class="entry-content single-post-attachment"><?php the_attachment_link($post->post_ID, false) ?></div>
		<?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?>	
        </div>
        <?php wp_link_pages(array('before' => __('<p><strong>Pages:</strong> ', 'arras'), 
			'after' => '</p>', 'next_or_number' => 'number')); ?>
        
		<?php arras_postfooter() ?>

       <?php if ( arras_get_option('display_author') ) : ?>
        <div class="about-author clearfix">
        	<h4><?php _e('About the Author', 'arras') ?></h4>
            <?php echo get_avatar(get_the_author_email(), 48); ?>
            <?php the_author_meta('description'); ?>
        </div>
        <?php endif; ?>
    </div>
    
	<?php arras_below_post() ?>
	<a name="comments"></a>
    <?php comments_template('', true); ?>
	<?php arras_below_comments() ?>
    
<?php else: ?>

<?php arras_post_notfound() ?>

<?php endif; ?>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php get_sidebar('sidebar-single'); ?>
<?php get_footer(); ?>