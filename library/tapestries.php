<?php

/**
 * Container for storing tapestries and their hook to render them.
 * @since 1.4.3
 */
$arras_tapestries = array();

/**
 * Function to add posts views into the system.
 * @since 1.4.3
 */
function arras_add_tapestry( $id, $name, $callback, $args = array() ) {
	global $arras_tapestries;
	
	if ( !is_callable($callback) ) return false;
	
	$defaults = array(
		'before' => '<div class="hfeed clearfix">',
		'after' => '</div>',
		'allow_duplicates' => true
	);
	$args = wp_parse_args($args, $defaults);
	
	$args['name'] = $name;
	$args['callback'] = $callback;
	
	$arras_tapestries[$id] = (object) $args;
}

/**
 * Function to remove posts views from the system.
 * @since 1.4.3
 */
function arras_remove_tapestry($id) {
	global $arras_tapestries;
	
	unset($arras_tapestries[$id]);
} 

/**
 * Removes all posts display types from the system.
 * @since 1.4.3
 */
function arras_remove_all_tapestries() {
	global $arras_tapestries;
	
	$arras_tapestries = array();
}

/**
 * Gets tapestry callback function
 * @since 1.4.4
 */
function arras_get_tapestry_callback($type, $query, $page_type) {
	global $arras_tapestries;
	
	if ( count($arras_tapestries) == 0 ) return false;
	
	if ( $arras_tapestries[$type] ) {
		$tapestry = $arras_tapestries[$type];
	} else {
		$arr = array_values($arras_tapestries);
		$tapestry = $arr[0];
	}
	
	echo $tapestry->before;
	while ($query->have_posts()) {
		$query->the_post();
		call_user_func_array( $tapestry->callback, array($dep, $page_type) );
		if ($tapestry->allow_duplicates) arras_blacklist_duplicates();
	}
	echo $tapestry->after;
}

/**
 * Traditional tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_traditional')) {
	function arras_tapestry_traditional($dep = '', $page_type) {
		?>
		<div <?php arras_single_post_class() ?>>
			<?php arras_postheader() ?>
			<div class="entry-content"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
			<?php arras_postfooter() ?>
		</div>
		<?php
	}
	arras_add_tapestry( 'traditional', __('Traditional', 'arras'), 'arras_tapestry_traditional', array(
		'before' => '<div class="traditional hfeed">',
		'after' => '</div><!-- traditional -->'
	) );
}

/**
 * Per Line tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_line')) {
	function arras_tapestry_line($dep = '', $page_type) {
		?>
		<li <?php arras_post_class() ?>>
		<?php if(!is_archive()) : ?>
			<span class="entry-cat">
				<?php $cats = get_the_category(); 
				if (arras_get_option('news_cat') && isset($cats[1])) echo $cats[1]->cat_name;
				else echo $cats[0]->cat_name; ?>
			</span>
			<?php endif ?>
			
			<h3 class="entry-title"><a rel="bookmark" href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>"><?php the_title() ?></a></h3>
			<span class="entry-comments"><?php comments_number() ?></span>
		</li>
		<?php
	}
	arras_add_tapestry( 'line', __('Per Line', 'arras'), 'arras_tapestry_line', array(
		'before' => '<ul class="hfeed posts-line clearfix">',
		'after' => '</ul><!-- .posts-line -->'
	) );
}

/**
 * Node Based tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_default')) {
	function arras_tapestry_default($dep = '', $page_type) {
		?>
		<li <?php arras_post_class() ?>>
			<?php echo apply_filters('arras_tapestry_default_postheader', arras_generic_postheader('node-based', true) ) ?>
			<div class="entry-summary">
				<?php the_excerpt() ?>
			</div>	
		</li>
		<?php
	}
	arras_add_tapestry( 'default', __('Node Based', 'arras'), 'arras_tapestry_default', array(
		'before' => '<ul class="hfeed posts-default clearfix">',
		'after' => '</ul><!-- .posts-default -->'
	) );
}

/**
 * Quick Preview tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_quick')) {
	function arras_tapestry_quick($dep = '', $page_type) {
		?>
		<li <?php arras_post_class() ?>>
			<?php echo apply_filters('arras_tapestry_quick_postheader', arras_generic_postheader('quick-preview') ) ?>
			<div class="entry-summary">
				<div class="entry-info">
					<abbr class="published" title="<?php the_time('c') ?>"><?php printf( __('Posted on %s', 'arras'), get_the_time(get_option('date_format')) ) ?></abbr> | <span><?php comments_number() ?></span>
				</div>
				<?php echo get_the_excerpt() ?>
				<p class="quick-read-more"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>">
				<?php _e('Continue Reading...', 'arras') ?>
				</a></p>
			</div>	
		</li>
		<?php
	}
	arras_add_tapestry( 'quick', __('Quick Preview', 'arras'), 'arras_tapestry_quick', array(
		'before' => '<ul class="hfeed posts-quick clearfix">',
		'after' => '</ul><!-- .posts-quick -->'		
	) );
}

/**
 * Helper function to display headers for certain tapestries.
 * @since 1.4.3
 */
function arras_generic_postheader($tapestry, $show_meta = false) {
	global $post;
	
	$postheader = '<div class="entry-thumbnails">';
	$postheader .= '<a class="entry-thumbnails-link" href="' . get_permalink() . '">';
	$postheader .= arras_get_thumbnail($tapestry . '-thumb');
	
	if ($show_meta) {	
		$postheader .= '<span class="entry-meta"><span class="entry-comments">' . get_comments_number() . '</span>';
		$postheader .= '<abbr class="published" title="' . get_the_time('c') . '">' . get_the_time( get_option('date_format') ) . '</abbr></span>';
	}
	
	$postheader .= '</a>';

	$postheader .= '</div>';
	
	$postheader .= '<h3 class="entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
	
	return $postheader;
}

/* End of file tapestries.php */
/* Location: ./library/tapestries.php */