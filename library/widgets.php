<?php
/**
 * This file will eventually place the codes for theme widgets that is
 * compatible with WordPress 2.8.
 */
 
class Arras_Tabbed_Sidebar extends WP_Widget {
	var $display_thumbs, $query_source;
	var $commentcount, $postcount;

	// Constructor
	function Arras_Tabbed_Sidebar() {
		$widget_args = array(
			'classname'		=> 'arras_tabbed_sidebar',
			'description'	=> __('Sidebar containing tabs that displays posts, comments and tags.', 'arras'),
		);
		$this->WP_Widget('arras_tabbed_sidebar', __('Tabbed Sidebar', 'arras'), $widget_args);
		
		add_action('arras_tabbed_sidebar_tab-featured', array(&$this, 'featured_tab'));
		add_action('arras_tabbed_sidebar_tab-latest', array(&$this, 'latest_tab'));
		add_action('arras_tabbed_sidebar_tab-comments', array(&$this, 'comments_tab'));
		add_action('arras_tabbed_sidebar_tab-tags', array(&$this, 'tags_tab'));
		add_action('arras_tabbed_sidebar_tab-popular', array(&$this, 'popular_tab'));
	}
	
	function get_tabs() {
		$_default_tabs = array(
			'featured'		=> __('Featured', 'arras'), 
			'latest'		=> __('Latest', 'arras'),
			'comments'		=> __('Comments', 'arras'), 
			'tags'			=> __('Tags', 'arras')
		);
		
		if ( function_exists('akpc_most_popular') ) {
			$_default_tabs['popular'] = __('Popular', 'arras');
		}
		
		return apply_filters('arras_tabbed_sidebar_tabs', $_default_tabs);
	}
	
	function widget($args, $instance) {
		global $wpdb;		
		extract($args, EXTR_SKIP);
		
		$this->query_source = $instance['query'];
		$this->postcount = $instance['postcount'];
		$this->commentcount = $instance['commentcount'];
		$this->display_thumbs = isset($instance['display_thumbs']);
		
		if (!$instance['order']) $instance['order'] = $this->get_tabs();
		
		if ($instance['display_home'] && !is_home()) {
			return false;
		}
		?>
		<li class="multi-sidebar-container">
		<div class="multi-sidebar clearfix">
		<ul class="tabs clearfix">
		<?php $this->render_sidebar_tabs($instance['order']) ?>
		</ul>
		<?php
		foreach ($instance['order'] as $tab) {
			echo '<div id="s-' . $tab . '" class="widgetcontainer clearfix">';
			do_action('arras_tabbed_sidebar_tab-' . $tab);
			echo '</div><!-- #s-' . $tab . ' -->';
		}
		?>
		</div>
		</li>
		<?php
		
	}
	
	function featured_tab() {
		
		switch ($this->query_source) {
			case 'slideshow':
				$q = arras_parse_query( 
					arras_get_option('slideshow_cat'),
					$this->postcount, 
					0, 
					arras_get_option('slideshow_posttype'), 
					arras_get_option('slideshow_tax')
				);
				break;
			case 'featured2':
				$q = arras_parse_query( 
					arras_get_option('featured2_cat'),
					$this->postcount, 
					0, 
					arras_get_option('featured2_posttype'), 
					arras_get_option('featured2_tax')
				);
				break;
			default:
				$q = arras_parse_query( 
					arras_get_option('featured1_cat'),
					$this->postcount, 
					0, 
					arras_get_option('featured1_posttype'), 
					arras_get_option('featured1_tax')
				);
		}
		
		$f = new WP_Query($q);
		if (!$f->have_posts()) {
			echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
		} else {
			echo '<ul>';
			while ($f->have_posts()) {
				$f->the_post();
				?>
				<li class="clearfix">
				<?php if ($this->display_thumbs) : ?>
				<span class="thumb"><?php echo arras_get_thumbnail('sidebar-thumb') ?></span>
				<?php endif ?>
				<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
				<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
				<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
				</li>
				<?php
			}
			echo '</ul>';
		}
	}
	
	function latest_tab() {
		$f = new WP_Query('showposts=' . $this->postcount);
		if (!$f->have_posts()) {
			echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
		} else {
			echo '<ul>';
			while ($f->have_posts()) {
				$f->the_post();
				?>
				<li class="clearfix">
				<?php if ($this->display_thumbs) : ?>
				<span class="thumb"><?php echo arras_get_thumbnail('sidebar-thumb',get_the_ID()) ?></span>
				<?php endif ?>
				<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
				<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
				<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
				</li>
				<?php
			}
			echo '</ul>';
		}
	}
	
	function comments_tab() {
		$comments = get_comments( array('status' => 'approve', 'number' => $this->commentcount) );	
		if ($comments) {
			echo '<ul id="recentcomments">';
			foreach ($comments as $comment) {
				echo '<li class="recentcomments clearfix">';
				if ($this->display_thumbs) echo get_avatar($comment->user_id, 36);
				echo '<span class="author">' . $comment->comment_author . '</span><br />';
				echo '<a href="' . get_permalink($comment->comment_post_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}
	}
	
	function tags_tab() {
		echo '<div class="tags">';
		if (function_exists('wp_cumulus_insert')) {
			$args = array(
				'width'		=> 280,
				'height'	=> 280
			);
			wp_cumulus_insert($args);
		} else {
			wp_tag_cloud('smallest=9&largest=16');
		}
		echo '</div>';
	}
	
	function popular_tab() {
		if ( function_exists('akpc_most_popular') ) {
			echo '<ul>';
			akpc_most_popular(10, '<li>', '</li>');
			echo '</ul>';
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['order'] = $new_instance['order'];
		$instance['display_home'] = $new_instance['display_home'];
		$instance['display_thumbs'] = $new_instance['display_thumbs'];
		$instance['query'] = $new_instance['query'];
		$instance['postcount'] = $new_instance['postcount'];
		$instance['commentcount'] = $new_instance['commentcount'];
		
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array( 
			'order' => array('featured', 'latest', 'comments', 'tags'), 
			'display_home' => true, 
			'display_thumbs' => true, 
			'query' => 'slideshow',
			'postcount' => 8,
			'commentcount' => 8
		) );
		$order = $instance['order'];

		?>
		<p>
		<label for="<?php echo $this->get_field_id('featured_cat') ?>"><?php _e('Retrieve Posts from:', 'arras') ?></label><br />
		<select style="width: 200px;" name="<?php echo $this->get_field_name('query') ?>">
			<option<?php if ($instance['query'] == 'slideshow') echo ' selected="selected" ' ?> value="slideshow"><?php _e('Slideshow', 'arras') ?></option>
			<option<?php if ($instance['query'] == 'featured1') echo ' selected="selected" ' ?> value="featured1"><?php _e('Featured Posts #1', 'arras') ?></option>
			<option<?php if ($instance['query'] == 'featured2') echo ' selected="selected" ' ?> value="featured2"><?php _e('Featured Posts #2', 'arras') ?></option>
		</select>
		</p>

		<p>
		<label for="<?php echo $this->get_field_id('order') ?>"><?php _e('Tabbed Sidebar Order:', 'arras') ?></label><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[0]"><?php $this->get_tabbed_opts( $order[0], 'featured'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[1]"><?php $this->get_tabbed_opts( $order[1], 'latest'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[2]"><?php $this->get_tabbed_opts( $order[2], 'comments'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[3]"><?php $this->get_tabbed_opts( $order[3], 'tags'); ?></select>
		</p>
		<p style="font-size:11px"><?php _e('The popular posts option is only enabled when the plugin <a href="http://wordpress.org/extend/plugins/popularity-contest/">Popularity Contest</a> is enabled.', 'arras') ?></p>
		
		<p><label for="<?php echo $this->get_field_id('postcount') ?>"><?php _e('Post Count:', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('postcount') ?>" name="<?php echo $this->get_field_name('postcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php if ($i == $instance['postcount']) : ?> selected="selected"<?php endif ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select><br />
		
		<label for="<?php echo $this->get_field_id('commentcount') ?>"><?php _e('Comments Count:', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('commentcount') ?>" name="<?php echo $this->get_field_name('commentcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php if ($i == $instance['commentcount']) : ?> selected="selected"<?php endif ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select>
		</p>
		
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('display_home') ?>" <?php if ($instance['display_home']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('display_home') ?>"><?php _e('Display only in homepage', 'arras') ?></label><br />
		<input type="checkbox" name="<?php echo $this->get_field_name('display_thumbs') ?>" <?php if ($instance['display_thumbs']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('display_thumbs') ?>"><?php _e('Display thumbnails', 'arras') ?></label>
		</p>
		<?php
	}
	
	function get_tabbed_opts($selected, $default) {
		$opts = $this->get_tabs();
		
		if (!$selected) $selected = $default;
		
		foreach ( $opts as $id => $val ) {
			echo '<option value="' . $id . '" ';
			if ($selected == $id) echo 'selected="selected"';
			echo '>';
			
			echo $val;
			echo '</option>';
		}
	}
	
	function render_sidebar_tabs($order) {
		$order = array_unique($order);
		$list = $this->get_tabs();
		
		foreach ($order as $t) {
			?><li><a href="#s-<?php echo $t ?>"><span><?php echo $list[$t] ?></span></a></li><?php
		}
	}
	
}

class Arras_Featured_Stories extends WP_Widget {
	
	// Constructor
	function Arras_Featured_Stories() {
		$widget_args = array(
			'classname'		=> 'arras_featured_stories',
			'description'	=> __('Featured stories containing post thumbnails and the excerpt based on categories.', 'arras'),
		);
		$this->WP_Widget('arras_featured_stories', __('Featured Stories', 'arras'), $widget_args);
	}
	
	function widget($args, $instance) {
		global $wpdb;		
		extract($args, EXTR_SKIP);
		
		if ($instance['no_display_in_home'] && is_home()) {
			return false;
		}
		
		$title = apply_filters('widget_title', $instance['title']);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		
		$q = arras_parse_query($instance['featured_cat'], $instance['postcount']);
		$r = new WP_Query($q);
		if ($r->have_posts()) {
		
		echo '<ul class="featured-stories">';
		while ($r->have_posts()) : $r->the_post();
		?>
		<li class="clearfix">
			<?php if ( isset($instance['show_thumbs']) ) : ?><div class="thumb"><?php echo arras_get_thumbnail('sidebar-thumb', get_the_ID()) ?></div><?php endif ?>
			<div class="featured-stories-summary">
			<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
			<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
			<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
			
			<?php if ($instance['show_excerpts']) : ?>
			<p class="excerpt">
			<?php echo get_the_excerpt() ?>
			</p>
			<a class="sidebar-read-more" href="<?php the_permalink() ?>"><?php _e('Read More', 'arras') ?></a>
			<?php endif ?>
			</div>
		</li>
		<?php
		endwhile;
		echo '</ul>';
		}
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['featured_cat'] = $new_instance['featured_cat'];
		$instance['postcount'] = (int)strip_tags($new_instance['postcount']);
		$instance['no_display_in_home'] = strip_tags($new_instance['no_display_in_home']);
		$instance['show_excerpts'] = strip_tags($new_instance['show_excerpts']);
		$instance['show_thumbs'] = strip_tags($new_instance['show_thumbs']);
		
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> __('Featured Stories', 'arras'), 
			'featured_cat' 			=> 0, 
			'postcount' 			=> 5, 
			'no_display_in_home' 	=> true, 
			'show_excerpts' 		=> true,
			'show_thumbs'			=> true
		) );
		
		if (!is_array($instance['featured_cat'])) $instance['featured_cat'] = array(0);
		
		?>
		<p><label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title:', 'arras') ?></label><br />
		<input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" size="33" value="<?php echo strip_tags($instance['title']) ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('featured_cat') ?>"><?php _e('Featured Categories:', 'arras') ?></label><br />
		<select multiple="multiple" style="width: 200px; height: 75px" name="<?php echo $this->get_field_name('featured_cat') ?>[]">
			<option<?php if (in_array(0, $instance['featured_cat'])) echo ' selected="selected" ' ?> value="0"><?php _e('All Categories', 'arras') ?></option>
		<?php
		foreach( get_categories('hide_empty=0') as $c ) {
			$selected = '';
			if (in_array($c->cat_ID, $instance['featured_cat'])) $selected = ' selected="selected"';
			echo '<option' . $selected . ' value="' . $c->cat_ID . '">' . $c->cat_name . '</option>';
		}
		?>
		</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('postcount') ?>"><?php _e('How many items would you like to display?', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('postcount') ?>" name="<?php echo $this->get_field_name('postcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php if ($i == $instance['postcount']) : ?> selected="selected"<?php endif ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select>
		</p>
		
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('no_display_in_home') ?>" <?php if ($instance['no_display_in_home']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('no_display_in_home') ?>"><?php _e('Do not display in homepage', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_excerpts') ?>" <?php if ($instance['show_excerpts']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('show_excerpts') ?>"><?php _e('Show post excerpts', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_thumbs') ?>" <?php if ($instance['show_thumbs']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('show_thumbs') ?>"><?php _e('Show thumbnails', 'arras') ?></label>
		</p>
		<?php
	}
	
}

class Arras_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud {
	function Arras_Widget_Tag_Cloud() {
		$this->WP_Widget_Tag_Cloud();
	}
	
	function widget( $args, $instance ) {
		extract($args);
		
		// for WordPress 3.0+
		if ( function_exists('_get_current_taxonomy') ) {
			$current_taxonomy = $this->_get_current_taxonomy($instance);
			if ( !empty($instance['title']) ) {
				$title = $instance['title'];
			} else {
				if ( 'post_tag' == $current_taxonomy ) {
					$title = __('Tags');
				} else {
					$tax = get_taxonomy($current_taxonomy);
					$title = $tax->label;
				}
			}
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			echo '<div class="widget-tag-cloud tags">';
			wp_tag_cloud( apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy, 'smallest' => 9, 'largest' => 16) ) );
			echo "</div>\n";
			echo $after_widget;
		} else {
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Tags') : $instance['title']);

			echo $before_widget;
			if ( $title )
				echo $before_title . $title . $after_title;
			echo '<div class="widget-tag-cloud tags">';
			wp_tag_cloud(apply_filters('widget_tag_cloud_args', array()));
			echo "</div>\n";
			echo $after_widget;
		}
	}
}

class Arras_Widget_Search extends WP_Widget {

	function Arras_Widget_Search() {
		$widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for your site") );
		$this->WP_Widget('search', __('Search'), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract($args);
		
		// Use current theme search form if it exists
		echo '<li class="widgetcontainer clearfix"><div class="widgetcontent">';
		get_search_form();
		echo '</div></li>';
	}

	function form( $instance ) {
		
	}

	function update( $new_instance, $old_instance ) {

	}

}

// Register Widgets
function arras_widgets_init() {
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_Search');

	register_widget('Arras_Tabbed_Sidebar');
	register_widget('Arras_Featured_Stories');
	register_widget('Arras_Widget_Tag_Cloud');
	register_widget('Arras_Widget_Search');
}

add_action('widgets_init', 'arras_widgets_init', 1);	
/* End of file widgets.php */
/* Location: ./library/widgets.php */
?>
