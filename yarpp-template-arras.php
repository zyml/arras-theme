<?php
/*
Template for Arras WP Theme
This template returns the related posts, Arras way.
Author: zy (Melvin Lee)
*/

if ( $related_query->have_posts() ) {
	echo '<ul class="related-posts">';
	while ( $related_query->have_posts() ) {
		$related_query->the_post();
		?>
			<li class="clearfix">
				<?php the_post_thumbnail( 'sidebar-thumb', get_the_ID() ) ?>
				<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
				<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
				<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
				<p class="excerpt">
				<?php echo get_the_excerpt() ?>
				</p>
				<a class="sidebar-read-more" href="<?php the_permalink() ?>"><?php _e('Read More', 'arras') ?></a>
			</li>
		<?php
	}
	echo '</ul>';
} else {
	echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
}