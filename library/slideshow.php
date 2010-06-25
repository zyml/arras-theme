<?php 

function arras_add_slideshow() {
	if (!is_home()) return false;
	
	$slideshow_cat = arras_get_option('slideshow_cat');
	
	if (arras_get_option('enable_slideshow') == false) return false;
	
	$query = arras_parse_query($slideshow_cat, arras_get_option('slideshow_count'));
	
	$q = new WP_Query( apply_filters('arras_slideshow_query', $query) );
	if ($q->have_posts()) :
	?> 
	<!-- Featured Slideshow -->
	<div class="featured clearfix">
		<div id="controls">
			<a href="" class="prev"><?php _e('Prev', 'arras') ?></a>
			<a href="" class="next"><?php _e('Next', 'arras') ?></a>
		</div>
		<div id="featured-slideshow">
			<?php $count = 0; ?>
		
			<?php while ($q->have_posts()) : $q->the_post(); ?>
			<div <?php if ($count != 0) echo 'style="display: none"'; ?>>

				<a class="featured-article" href="<?php the_permalink(); ?>" rel="bookmark">
				<?php echo arras_get_thumbnail('featured-slideshow-thumb'); ?>
				<span class="featured-entry">
					<span class="entry-title"><?php the_title(); ?></span>
					<span class="entry-summary"><?php the_excerpt() ?></span>
					<span class="progress"></span>
				</span>
				</a>
			</div>
			<?php $count++; endwhile; ?>
		</div>
	</div>
	<?php endif;
}

add_action('arras_above_content', 'arras_add_slideshow');

function arras_add_slideshow_js() {
?>
<script type="text/javascript">
jQuery(document).ready(function($) {

<?php if (is_home() || is_front_page()) : ?>
$('#featured-slideshow').cycle({
	fx: 'fade',
	speed: 250,
	next: '#controls .next',
	prev: '#controls .prev',
	timeout: 6000,
	pause: 1
});
<?php endif ?>
	
});
</script>
<?php
}
add_action('arras_footer', 'arras_add_slideshow_js');

function arras_get_slideshow_thumb_size($layout = '') {
	if (!$layout) {
		$layout = arras_get_option('layout');
	}
	
	if ( strpos($layout, '1c') !== false ) {
		$size = array(940, 300);
	} else if ( strpos($layout, '3c') !== false ) {
		$size = array(490, 225);
	} else {
		$size = array(640, 250);
	}
	
	return apply_filters('arras_slideshow_thumb_size', $size);
}

/* End of file slideshow.php */
/* Location: ./library/slideshow.php */