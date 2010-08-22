<?php get_header(); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<div class="author-content">
	<?php the_post(); // Get author information ?>

	<h1 class="entry-title"><?php printf( __('About Author: %s', 'arras'), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author_meta('display_name') . '</a></span>' ); ?></h1>

	<div class="entry-content clearfix">
		<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php echo get_avatar(get_the_author_meta('ID'), 96) ?></a>
		<dl>
			<?php if (get_the_author_meta('user_url')) : ?>
				<dt><?php _e('Website', 'arras') ?></dt>
				<dd><a href="<?php the_author_meta('user_url') ?>"><?php the_author_meta('user_url') ?></a></dd>
			<?php endif ?>
			<?php if (get_the_author_meta('description')) : ?>
				<dt><?php _e('Description', 'arras') ?></dt>
				<dd><?php the_author_meta('description') ?></dd>
			<?php endif ?>
		</dl>
	</div>
	
	<h2 class="author-posts-title"><?php printf( __('Posts by %s', 'arras'), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author_meta('display_name') . '</a></span>' ); ?></h2>
	
	<div id="archive-posts">
		<?php arras_render_posts( 'author=' . get_the_author_meta('ID') . '&paged=' . $paged, arras_get_option('archive_display') ) ?> 
	</div>
	
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); else { ?>
    	<div class="navigation clearfix">
			<div class="floatleft"><?php next_posts_link( __('&laquo; Older Entries', 'arras') ) ?></div>
			<div class="floatright"><?php previous_posts_link( __('Newer Entries &raquo;', 'arras') ) ?></div>
		</div>
    <?php } ?>

</div>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>