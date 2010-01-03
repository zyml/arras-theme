<?php
/**
 * This file will eventually place the codes for theme widgets that is
 * compatible with WordPress 2.8.
 */
 
class Arras_Tabbed_Sidebar extends WP_Widget {

	// Constructor
	function Arras_Tabbed_Sidebar() {
		$widget_args = array(
			'classname'		=> 'arras_tabbed_sidebar',
			'description'	=> __('Sidebar containing tabs that displays posts, comments and tags.', 'arras'),
		);
		$this->WP_Widget('arras_tabbed_sidebar', __('Tabbed Sidebar', 'arras'), $widget_args);
	}
	
	function widget($args, $instance) {
		global $wpdb;		
		extract($args, EXTR_SKIP);
		
		if (!$instance['order']) $instance['order'] = array('featured', 'latest', 'comments', 'tags');
		if ($instance['display_home'] && !is_home()) return;
		
		$featured = arras_get_option('featured_cat');
		?>
		<li id="multi-sidebar-container">
		<div id="multi-sidebar" class="clearfix">
		<ul class="tabs clearfix">
		<?php $this->render_sidebar_tabs($instance['order'], is_numeric($featured)) ?>
		</ul>
		<?php
		
		foreach( $instance['order'] as $tab ) {
			switch($tab) {
				case 'featured':
				
				if (is_numeric($featured)) {
					echo '<div id="s-featured" class="widgetcontainer clearfix">';
					$f = new WP_Query('showposts=8&cat=' . $featured);
					if (!$f->have_posts()) {
						echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
					} else {
						echo '<ul>';
						while ($f->have_posts()) {
							$f->the_post();
							?>
							<li class="clearfix">
							<?php if (function_exists('the_post_thumbnail')) the_post_thumbnail('sidebar-thumb') ?>
							<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
							<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
							<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
							</li>
							<?php
						}
						echo '</ul>';
					}
					echo '</div><!-- #s-featured -->';
				}
				
				break;
				
				case 'latest':
				
				echo '<div id="s-latest" class="widgetcontainer clearfix">';
				$f = new WP_Query('showposts=8');
				if (!$f->have_posts()) {
					echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
				} else {
					echo '<ul>';
					while ($f->have_posts()) {
						$f->the_post();
						?>
						<li class="clearfix">
						<?php if (function_exists('get_the_post_thumbnail')) echo get_the_post_thumbnail( get_the_ID(), 'sidebar-thumb' ) ?>
						<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
						<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
						<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
						</li>
						<?php
					}
					echo '</ul>';
				}
				echo '</div><!-- #s-latest -->';
				
				break;
				
				case 'comments':
				
				echo '<div id="s-comments" class="widgetcontainer clearfix">';
				$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 8");
				
				if ($comments) {
					echo '<ul id="recentcomments">';
					foreach ($comments as $comment) {
						echo '<li class="recentcomments clearfix">';
						echo get_avatar($comment->user_id, 36);
						echo '<strong>' . $comment->comment_author . '</strong><br />';
						echo '<a href="' . clean_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>';
						echo '</li>';
					}
					echo '</ul>';
				}
				
				echo '</div><!-- #s-comments -->';
				
				break;
				
				case 'tags':
				
				echo '<div id="s-tags" class="widgetcontainer clearfix">';
				wp_tag_cloud('smallest=8&largest=18');
				echo '</div><!-- #s-tags -->';
				
				break;
				
				case 'popular':
				
				echo '<div id="s-popular" class="widgetcontainer clearfix">';
				if ( function_exists('akpc_most_popular') ) akpc_most_popular();
				echo '</div><!-- #s-popular -->';
				
				break;
			}
		}
		
		?>
		</div>
		</li>
		<?php
		
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['order'] = $new_instance['order'];
		$instance['display_home'] = $new_instance['display_home'];
		
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array( 'order' => array('featured', 'latest', 'comments', 'tags'), 'display_home' => true ) );
		$order = $instance['order'];
		?>
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('display_home') ?>" <?php if ($instance['display_home']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('display_home') ?>"><?php _e('Display in homepage?', 'arras') ?></label>
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('order') ?>"><?php _e('Tabbed Sidebar Order:', 'arras') ?></label><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[0]"><?php $this->get_tabbed_opts( $order[0], 'featured'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[1]"><?php $this->get_tabbed_opts( $order[1], 'latest'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[2]"><?php $this->get_tabbed_opts( $order[2], 'comments'); ?></select><br />
		<select style="width: 200px" name="<?php echo $this->get_field_name('order') ?>[3]"><?php $this->get_tabbed_opts( $order[3], 'tags'); ?></select>
		</p>
		<p><?php _e('The popular posts option is only enabled when the plugin <a href="http://wordpress.org/extend/plugins/popularity-contest/">Popularity Contest</a> is enabled.', 'arras') ?></p>
		<?php
	}
	
	function get_tabbed_opts($selected, $default) {
		$opts = array(
			'none' 		=> __('None', 'arras'),
			'featured' 	=> __('Featured Posts', 'arras'),
			'latest' 	=> __('Latest Posts', 'arras'),
			'comments' 	=> __('Recent Comments', 'arras'),
			'tags' 		=> __('Tag Cloud', 'arras')
		);
		
		if ( function_exists('akpc_most_popular') ) {
			$opts['popular'] = __('Popular Posts', 'arras');
		}
		
		if (!$selected) $selected = $default;
		
		foreach ( $opts as $id => $val ) {
			echo '<option value="' . $id . '" ';
			if ($selected == $id) echo 'selected="selected"';
			echo '>';
			
			echo $val;
			echo '</option>';
		}
	}
	
	function render_sidebar_tabs($order, $show_featured) {
		$order = array_unique($order);
		$list = array(
			'latest'	=> __('Latest', 'arras'),
			'comments'	=> __('Comments', 'arras'),
			'tags'		=> __('Tag Cloud', 'arras'),
			'popular'	=> __('Popular', 'arras')
		);
		
		$count = 0;
		if ($show_featured) $list['featured'] = __('Featured', 'arras');
		
		foreach ($order as $t) {
			if (!$show_featured) {
				if ($t == 'featured') continue;
			}
			if ($t != 'none') {
				?><li><a href="#s-<?php echo $t ?>"><span><?php echo apply_filters('widget_title', $list[$t]) ?></span></a></li><?php
			}
			$count++;
		}
	}
	
}

class Arras_Featured_Stories extends WP_Widget {
	
	// Constructor
	function Arras_Featured_Stories() {
		$widget_args = array(
			'classname'		=> 'arras_featured_stories',
			'description'	=> __('Featured stories containing post thumbnails and the excerpt.', 'arras'),
		);
		$this->WP_Widget('arras_featured_stories', __('Featured Stories', 'arras'), $widget_args);
	}
	
	function widget($args, $instance) {
		global $wpdb;		
		extract($args, EXTR_SKIP);
		
		if ($instance['no_display_in_home'] && is_home()) return;
		
		$title = apply_filters('widget_title', $instance['title']);
		$cat = (int)strip_tags($instance['featured_cat']);
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		
		$r = new WP_Query( array('showposts' => $instance['postcount'], 'cat' => $cat) );
		if ($r->have_posts()) {
		
		echo '<ul class="featured-stories">';
		while ($r->have_posts()) : $r->the_post();
		?>
		<li class="clearfix">
			<?php if (function_exists('the_post_thumbnail')) the_post_thumbnail( 'sidebar-thumb', get_the_ID() ) ?>
			<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
			<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
			<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
			
			<?php if ($instance['show_excerpts']) : ?>
			<p class="excerpt">
			<?php echo get_the_excerpt() ?>
			</p>
			<a class="sidebar-read-more" href="<?php the_permalink() ?>"><?php _e('Read More', 'arras') ?></a>
			<?php endif ?>
			
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
		$instance['featured_cat'] = strip_tags($new_instance['featured_cat']);
		$instance['postcount'] = (int)strip_tags($new_instance['postcount']);
		$instance['no_display_in_home'] = strip_tags($new_instance['no_display_in_home']);
		$instance['show_excerpts'] = strip_tags($new_instance['show_excerpts']);
		
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array(
			'title' 				=> __('Featured Stories', 'arras'), 
			'featured_cat' 			=> 0, 
			'postcount' 			=> 5, 
			'no_display_in_home' 	=> true, 
			'show_excerpts' 		=> true 
		) );
		
		$cats = array('0' => __('All Categories', 'arras') );
		foreach( get_categories('hide_empty=0') as $c ) {
			$cats[(string)$c->cat_ID] = $c->cat_name;
		}
		
		?>
		<p><label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title:', 'arras') ?></label><br />
		<input type="text" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" size="33" value="<?php echo strip_tags($instance['title']) ?>" />
		</p>
		<p><label for="<?php echo $this->get_field_id('featured_cat') ?>"><?php _e('Featured Category:', 'arras') ?></label><br />
		<select class="widefat" id="<?php echo $this->get_field_id('featured_cat') ?>" name="<?php echo $this->get_field_name('featured_cat') ?>">
			<?php foreach ($cats as $id => $name) : ?>
			<option value="<?php echo $id ?>"<?php if ($id == $instance['featured_cat']) : ?> selected="selected"<?php endif ?>>
			<?php echo $name ?>
			</option>
			<?php endforeach ?>
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
		<label for="<?php echo $this->get_field_id('no_display_in_home') ?>"><?php _e('Don\'t display in homepage?', 'arras') ?></label>
		</p>
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('show_excerpts') ?>" <?php if ($instance['show_excerpts']) : ?> checked="checked" <?php endif ?> />
		<label for="<?php echo $this->get_field_id('show_excerpts') ?>"><?php _e('Show post excerpts?', 'arras') ?></label>
		</p>
		<?php
	}
	
}

// Register Widgets
register_widget('Arras_Tabbed_Sidebar');
register_widget('Arras_Featured_Stories');
	
/* End of file widgets.php */
/* Location: ./library/widgets.php */
?>
