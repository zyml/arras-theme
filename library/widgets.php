<?php

class AR_Widget_Articles extends WP_Widget {
	
	function AR_Widget_Articles() {
		$widget_ops = array( 'classname' => 'widget_arras_articles', 'description' => __('Latest articles based on category', 'arras') );
		$this->WP_Widget( 'arras_articles', __('Latest Articles', 'arras'), $widget_ops );
	}
	
	function widget($args, $instance) {
		extract($args);
		
		$title 		= isset($instance['title']) ?  apply_filters('widget_title', $instance['title']) : __('Latest Articles', 'arras');
		$count		= isset($instance['count']) ? (int) $instance['count'] : 10;
		$category	= isset($instance['category']) ? (int) $instance['category'] : 1;
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		
		echo '<div class="widget-articles clearfix">';
		
		$r = new WP_Query('showposts=' . $count . '&cat=' . $category);
		if ( $r->have_posts() ) : $r->the_post();
			echo '<div class="clearfix"><h3 class="entry-title"><a href="' . get_permalink() .'" rel="bookmark">' . get_the_title() . '</a></h3>';
			echo '<img class="entry-photo" src="' . arras_get_thumbnail(95,50) .'" alt="' . get_the_title() . '" title="' . get_the_title() . '" />';
			echo '<div class="entry-summary">';
			if ( arras_get_option('post_preview') == 'content' ) the_content_rss('', true, '', 20, 2);
			else the_excerpt();
			echo '</div></div>';
			
			echo '<ul class="hfeed clearfix">';
			while ($r->have_posts()) : $r->the_post();
			echo '<li><a href="' . get_permalink() . '" rel="bookmark">' . get_the_title() . '</a></li>';
			endwhile;
			echo '</ul>';
		endif;
		
		echo '</div>';
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$new_instance = wp_parse_args( (array) $instance, array('title' => __('Latest Articles', 'arras'), 'count' => 10, 'category' => 1) );
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = (int) $new_instance['category'];
		$instance['count'] = (int) $new_instance['count'];
		
		return $instance;
	}
	
	function form($instance) {
		$cats = get_categories();
		$instance = wp_parse_args( (array) $instance, array('title' => __('Latest Articles', 'arras'), 'count' => 10, 'category' => 1) );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'arras') ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attr($instance['title']); ?>" />
		</label></p>
		
		<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category:', 'arras') ?>
		<select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
		<?php foreach ( $cats as $opt ) : ?>
			<option <?php echo ($opt->cat_ID == $instance['category'] ? 'selected="selected"' : '' ) ?> value="<?php echo $opt->cat_ID ?>"><?php echo $opt->name ?></option>
        <?php endforeach; ?>
		</select>
		</label></p>
		
		<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Number of articles to show:', 'arras') ?>
		<select class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>">
		<?php for ($i = 1; $i <= 15; $i++) : ?>
			<option <?php echo ($i == $instance['count'] ? 'selected="selected"' : '' ) ?> value="<?php echo $i ?>"><?php echo $i ?></option>
        <?php endfor; ?>
		</select>
		</label></p>
		<?php
	}
	
}

/*
function arras_widget_tabbed_sidebar($args) {
	global $wp_registered_sidebars, $wp_registered_widgets;
	
	$sidebars_widgets = wp_get_sidebars_widgets();
	$sidebar = $wp_registered_sidebars['tabbed-sidebar'];
	
	echo '<div id="multi-sidebar" class="clearfix">';
	
	echo '<ul class="tabs clearfix">';
	foreach ($sidebars_widgets['tabbed-sidebar'] as $id) {
		$widget = $wp_registered_widgets[$id];
		echo '<li><a href="#s-' . $widget['id'] . '">' . $widget['name'] . '</a></li>';
	}
	echo '</ul>';
	
	foreach ($sidebars_widgets['tabbed-sidebar'] as $id) {
		$widget = $wp_registered_widgets[$id];
		
		//$params = array_merge( array('widget_id' => $id, 'widget_name' => $widget['name']), (array) $widget['params'] );
		$params = array_merge(
			array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => '') ) ),
			(array) $wp_registered_widgets[$id]['params']
		);
		$params = apply_filters('dynamic_sidebar_params', $params);
		
		echo '<div id="s-' . $widget['id'] . '" class="widgetcontainer clearfix">';
		if ( is_callable($widget['callback']) ) {
			call_user_func_array($widget['callback'], $params);
		}
		echo '</div>';	
	}
	
	echo '</div>';
}
*/

function arras_register_widgets() {
	unregister_widget('WP_Widget_Search');
	register_widget('AR_Widget_Articles');	
}
add_action('widgets_init', 'arras_register_widgets');
	
/* End of file widgets.php */
/* Location: ./library/widgets.php */
?>
