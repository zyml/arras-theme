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
function arras_add_tapestry($id, $name, $callback) {
	global $arras_tapestries;
	
	if ( is_callable($callback) ) {
		$arras_tapestries[$id] = array('name' => $name, 'callback' => $callback);
	}
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
 * Traditional tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_traditional')) {
	function arras_tapestry_traditional($query, $page_type) {
		echo '<div class="traditional hfeed">';
		while ($query->have_posts()) {
			$query->the_post();
			?>
			<div <?php arras_single_post_class() ?>>
				<?php arras_postheader() ?>
				<div class="entry-content"><?php the_content( __('<p>Read the rest of this entry &raquo;</p>', 'arras') ); ?></div>
				<?php arras_postfooter() ?>
			</div>
			<?php
		}
		echo '</div><!-- .traditional -->';
	}
	arras_add_tapestry('traditional', __('Traditional', 'arras'), 'arras_tapestry_traditional');
}

/**
 * Per Line tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_line')) {
	function arras_tapestry_line($query, $page_type) {
		echo '<ul class="hfeed posts-line clearfix">';
		while ($query->have_posts()) {
			$query->the_post();
			?>
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
			<?php
		}
		echo '</ul><!-- .posts-line -->';
	}
	arras_add_tapestry('line', __('Per Line', 'arras'), 'arras_tapestry_line');
}

/**
 * Node Based tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_default')) {
	function arras_tapestry_default($query, $page_type) {
		echo '<ul class="hfeed posts-default clearfix">';
		while ($query->have_posts()) {
			$query->the_post();
			?>
			<li <?php arras_post_class() ?>>
				<?php arras_newsheader($page_type) ?>
				<div class="entry-summary">
					<?php echo arras_strip_content( get_the_excerpt(), arras_get_option('node_based_limit_words') ); ?>
				</div>
				<?php arras_newsfooter($page_type) ?>		
			</li>
			<?php
		}
		echo '</ul><!-- .posts-default -->';
	}
	arras_add_tapestry('default', __('Node Based', 'arras'), 'arras_tapestry_default');
}

/**
 * Quick Preview tapestry callback function.
 * @since 1.4.3
 */
if (!function_exists('arras_tapestry_quick')) {
	function arras_tapestry_quick($query, $page_type) {
		echo '<ul class="hfeed posts-quick clearfix">';
		while ($query->have_posts()) {
			$query->the_post();
			?>
			<li <?php arras_post_class() ?>>
				<?php arras_newsheader($page_type) ?>
				<div class="entry-summary">
					<?php echo get_the_excerpt() ?>
					<p class="quick-read-more"><a href="<?php the_permalink() ?>" title="<?php printf( __('Permalink to %s', 'arras'), get_the_title() ) ?>">
					<?php _e('Read More', 'arras') ?>
					</a></p>
				</div>
				<?php arras_newsfooter($page_type) ?>		
			</li>
			<?php
		}
		echo '</ul><!-- .posts-quick -->';
	}
	arras_add_tapestry('quick', __('Quick Preview', 'arras'), 'arras_tapestry_quick');
}
 
/* End of file tapestries.php */
/* Location: ./library/tapestries.php */