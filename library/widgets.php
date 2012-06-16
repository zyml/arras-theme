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
		
		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( &$this, 'load_js' ) );
			add_action( 'arras_custom_js-footer', array( &$this, 'do_js' ) );
		}
	}
	
	function load_js() {
		wp_enqueue_script( 'jquery-ui-tabs', null, array( 'jquery-ui-core', 'jquery' ), null, false ); 
	}
	
	function do_js() {
		?>
		$('.multi-sidebar').tabs();
		<?php
	}
	
	function get_tabs() {
		$_default_tabs = array(
			'featured'		=> __('Featured', 'arras'), 
			'latest'		=> __('Latest', 'arras'),
			'comments'		=> __('Comments', 'arras'), 
			'tags'			=> __('Tags', 'arras')
		);
		
		if ( function_exists('WPPP_show_popular_posts') ) {
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
		$this->display_thumbs = $instance['display_thumbs'];
		
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
				$list = arras_get_option('slideshow_cat');
				$post_type = arras_get_option('slideshow_posttype');
				$taxonomy = arras_get_option('slideshow_tax');
				break;
			case 'featured1':
				$list = arras_get_option('featured1_cat');
				$post_type = arras_get_option('featured1_posttype');
				$taxonomy = arras_get_option('featured1_tax');
				break;
			case 'featured2':
				$list = arras_get_option('featured2_cat');
				$post_type = arras_get_option('featured2_posttype');
				$taxonomy = arras_get_option('featured2_tax');
				break;
			default:
				$list = arras_get_option('news_cat');
				$post_type = arras_get_option('news_posttype');
				$taxonomy = arras_get_option('news_tax');
		}
		
		arras_widgets_post_loop('sidebar-featured', array(
			'list'				=> $list,
			'taxonomy'			=> $taxonomy,
			'show_thumbs'		=> $this->display_thumbs,
			'show_excerpt'		=> false,
			'query'				=> array(
				'posts_per_page'	=> $this->postcount,
				'post_type'			=> $post_type
			)
		) );
	}
	
	function latest_tab() {
		arras_widgets_post_loop('sidebar-latest', array(
			'show_thumbs'		=> $this->display_thumbs,
			'show_excerpt'		=> false,
			'query'				=> array(
				'posts_per_page'	=> $this->postcount
			)
		) );
	}
	
	function comments_tab() {
		$comments = get_comments( array('status' => 'approve', 'number' => $this->commentcount) );	
		if ($comments) {
			echo '<ul class="sidebar-comments">';
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
		if ( function_exists('WPPP_show_popular_posts') ) {
			WPPP_show_popular_posts( "title=&number=" . $this->postcount . "&format=<a href='%post_permalink%' title='%post_title_attribute%'>%post_title%</a><br /><span class='sub'>%post_time%</span>&time_format=d F Y g:i A" );
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['order'] = $new_instance['order'];
		$instance['display_home'] = (boolean)($new_instance['display_home']);
		$instance['display_thumbs'] = (boolean)($new_instance['display_thumbs']);
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
		<p style="font-size:11px"><?php _e('The popular posts option is only enabled when the plugin <a href="http://wordpress.org/extend/plugins/wordpresscom-popular-posts/">WordPress.com Popular Posts</a> is enabled.', 'arras') ?></p>
		
		<p><label for="<?php echo $this->get_field_id('postcount') ?>"><?php _e('Post Count:', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('postcount') ?>" name="<?php echo $this->get_field_name('postcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php selected($i, $instance['postcount']) ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select><br />
		
		<label for="<?php echo $this->get_field_id('commentcount') ?>"><?php _e('Comments Count:', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('commentcount') ?>" name="<?php echo $this->get_field_name('commentcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php selected($i, $instance['commentcount']) ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select>
		</p>
		
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('display_home') ?>" <?php checked($instance['display_home'], 1) ?> />
		<label for="<?php echo $this->get_field_id('display_home') ?>"><?php _e('Display only in homepage', 'arras') ?></label><br />
		<input type="checkbox" name="<?php echo $this->get_field_name('display_thumbs') ?>" <?php checked($instance['display_thumbs'], 1) ?> />
		<label for="<?php echo $this->get_field_id('display_thumbs') ?>"><?php _e('Display thumbnails', 'arras') ?></label>
		</p>
		<?php
	}
	
	function get_tabbed_opts($selected, $default) {
		$opts = $this->get_tabs();
		
		if (!$selected) $selected = $default;
		
		foreach ( $opts as $id => $val ) {
			echo '<option value="' . $id . '" ';
			selected($selected, $id);
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
		
		arras_widgets_post_loop('featured-stories', array(
			'list'				=> $instance['featured_cat'],
			'show_thumbs'		=> $instance['show_thumbs'],
			'show_excerpt'		=> $instance['show_excerpts'],
			'query'				=> array(
				'posts_per_page'	=> $instance['postcount']
			)
		) );
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['featured_cat'] = $new_instance['featured_cat'];
		$instance['postcount'] = (int)strip_tags($new_instance['postcount']);
		$instance['no_display_in_home'] = (boolean)($new_instance['no_display_in_home']);
		$instance['show_excerpts'] = (boolean)($new_instance['show_excerpts']);
		$instance['show_thumbs'] = (boolean)($new_instance['show_thumbs']);
		
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
			<option<?php selected( in_array( 0, $instance['featured_cat'] ), true ) ?> value="0"><?php _e('All Categories', 'arras') ?></option>
		<?php
		foreach( get_categories('hide_empty=0') as $c ) {
			$selected = '';
			echo '<option' . selected( in_array($c->cat_ID, $instance['featured_cat']), true ) . ' value="' . $c->cat_ID . '">' . $c->cat_name . '</option>';
		}
		?>
		</select>
		</p>
		
		<p><label for="<?php echo $this->get_field_id('postcount') ?>"><?php _e('How many items would you like to display?', 'arras') ?></label>
		<select id="<?php echo $this->get_field_id('postcount') ?>" name="<?php echo $this->get_field_name('postcount') ?>">
			<?php for ($i = 1; $i <= 20; $i++ ) : ?>
			<option value="<?php echo $i ?>"<?php selected($i, $instance['postcount']) ?>><?php echo $i ?>
			</option>
			<?php endfor; ?>
		</select>
		</p>
		
		<p>
		<input type="checkbox" name="<?php echo $this->get_field_name('no_display_in_home') ?>" <?php checked($instance['no_display_in_home'], 1) ?> />
		<label for="<?php echo $this->get_field_id('no_display_in_home') ?>"><?php _e('Do not display in homepage', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_excerpts') ?>" <?php checked($instance['show_excerpts'], 1) ?> />
		<label for="<?php echo $this->get_field_id('show_excerpts') ?>"><?php _e('Show post excerpts', 'arras') ?></label>
		<br />
		<input type="checkbox" name="<?php echo $this->get_field_name('show_thumbs') ?>" <?php checked($instance['show_thumbs'], 1) ?> />
		<label for="<?php echo $this->get_field_id('show_thumbs') ?>"><?php _e('Show thumbnails', 'arras') ?></label>
		</p>
		<?php
	}
	
}

class Arras_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud {
	function Arras_Widget_Tag_Cloud() {
		parent::__construct();
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
					$title = __('Tags', 'arras');
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
			$title = apply_filters('widget_title', empty($instance['title']) ? __('Tags', 'arras') : $instance['title']);

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
		$widget_ops = array('classname' => 'widget_search', 'description' => __( "A search form for your site", 'arras' ) );
		$this->WP_Widget('search', __('Search', 'arras'), $widget_ops);
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

function arras_widgets_post_loop( $id, $args = array() ) {
	global $wp_query, $post;
	
	$_defaults = array(
		'taxonomy'			=> 'category',
		'show_thumbs'		=> true,
		'show_excerpt'		=> true,
		'query'				=> array(
			'post_type'			=> 'post',
			'posts_per_page'	=> 5,
			'orderby'			=> 'date',
			'order'				=> 'DESC'
		)
	);
	
	$args['query'] = wp_parse_args($args['query'], $_defaults['query']);
	$args = wp_parse_args($args, $_defaults);
	
	$q = new WP_Query( arras_prep_query($args) );
	
	if ( $q->have_posts() ) {
		echo '<ul class="' . $id . '">';
		while( $q->have_posts() ) {
			$q->the_post();
			
			// hack for plugin authors who love to use $post = $wp_query->post
			$wp_query->post = $q->post;
			setup_postdata($post);
			
			?> <li class="clearfix"> <?php
			if ($args['show_thumbs']) {
				echo '<a rel="bookmark" href="' . get_permalink() . '" class="thumb">' . arras_get_thumbnail( 'sidebar-thumb', get_the_ID() ) . '</a>';
			}
			?>
			<a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
			<span class="sub"><?php printf( __( 'Posted %s', 'arras' ), arras_posted_on( false ) ); ?> | 
			<a href="<?php comments_link() ?>"><?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></a>
			</span>
			
			<?php if ($args['show_excerpt']) : ?>
			<p class="excerpt">
			<?php echo get_the_excerpt() ?>
			</p>
			<a class="sidebar-read-more" href="<?php the_permalink() ?>"><?php _e('Read More', 'arras') ?></a>
			<?php endif ?>
			
			</li>
			<?php
		}
		echo '</ul>';
	} else {
		echo '<span class="textCenter sub">' . __('No posts at the moment. Check back again later!', 'arras') . '</span>';
	}
	
	wp_reset_query();
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