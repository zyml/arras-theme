<?php
/* Deprecated - use arras_render_posts() instead */ 
function arras_get_posts($page_type, $query = null) {
	global $post, $wp_query;
	
	if (!$query) $query = $wp_query;
	if ( $query->have_posts() ) : ?>

<?php if (arras_get_option($page_type . '_display') == 'traditional') : ?>
	<div class="traditional hfeed">
	<?php while ($query->have_posts()) : $query->the_post() ?>
	<div <?php arras_single_post_class() ?>>
        <?php arras_postheader() ?>
		<div class="entry-content clearfix"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
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

/* End of file deprecated.php */
/* Location: ./library/deprecated.php */