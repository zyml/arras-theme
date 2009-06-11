<?php

function arras_widget_search($args) {
	extract($args, EXTR_SKIP);
?>
<?php echo $before_widget; ?>
<?php echo $before_title . __('Search', 'arras') . $after_title; ?>
<form method="get" id="widgetsearch" action="<?php bloginfo('url'); ?>/">
	<input type="text" value="<?php the_search_query(); ?>" name="s" 
			id="s" size="20" onfocus="this.value=''" class="text" />
	<input type="submit" id="searchsubmit" class="submit" value="<?php _e('Search', 'arras') ?>" />
</form>
<?php echo $after_widget; ?>
<?php	
}

function arras_get_tabbed_opts($selected, $default) {
	$opts = array(
		'none' => __('None', 'arras'),
		'featured' => __('Featured Posts', 'arras'),
		'latest' => __('Latest Posts', 'arras'),
		'comments' => __('Recent Comments', 'arras'),
		'tags' => __('Tag Cloud', 'arras')
	);

	if ( function_exists('akpc_most_popular') ) $opts['popular'] = __('Popular Posts', 'arras');
	if ( !$selected ) $selected = $default;
	
	foreach ( $opts as $id => $val ) { ?> 
    <option value="<?php echo $id; ?>" <?php if ( $selected == $id ) echo 'selected="selected"'; ?>>
    <?php echo $val; ?>
    </option>
    <?php }
}

function arras_widget_previews($args) {
	global $allowed_cats;
	
	extract($args, EXTR_SKIP);
	
	$options = get_option('arras_widget_previews');
	if (!$allowed_cats) $allowed_cats = arras_get_option('gaming_cats');
	
	$r = new WP_Query( array('showposts' => 5, 'cat' => $options['cat'] ) );
	if ($r->have_posts()) :
	?>
		<?php echo $before_widget; ?>
        <?php echo $before_title . $options['title'] . $after_title; ?>
        <ul>
        <?php while ($r->have_posts()) : $r->the_post(); ?> 	
            <li>
                <strong><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a></strong>
            </li>
        <?php endwhile; ?>   
        </ul>
        <?php echo $after_widget; ?>
	<?php
	endif;
}

function arras_widget_previews_control() {	
	$cats = get_categories();

	$options = $newoptions = get_option('arras_widget_previews');
	if ( isset($_POST['arras-widget-previews-submit']) ) {
		$newoptions['title'] = strip_tags( stripslashes($_POST['arras-widget-previews-title']) );
		$newoptions['cat'] = (int) $_POST['arras-widget-previews-cat'];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('arras_widget_previews', $options);
	}
	$title = attribute_escape($options['title']);
	if ($title == '') $title = __('Latest Previews', 'arras');
	if ($options['cat'] == 0) $options['cat'] = 1;
?>
	<p><label for="arras-widget-previews-title"><?php _e('Title:'); ?> <input class="widefat" id="arras-widget-previews-title" name="arras-widget-previews-title" type="text" value="<?php echo $title; ?>" /></label></p>
    <p><label for="arras-widget-previews-cat"><?php _e('Previews Category:'); ?> <select class="widefat" id="arras-widget-previews-cat" name="arras-widget-previews-cat">
		<?php foreach ( $cats as $opt ) : ?>
            <option <?php if ( $options['cat'] == $opt->cat_ID ) echo ' selected="selected"'; ?> value="<?php echo $opt->cat_ID; ?>"><?php echo $opt->name; ?></option>     
        <?php endforeach; ?>
        </select></label></p>
	<input type="hidden" id="arras-widget-previews-submit" name="arras-widget-previews-submit" value="1" />
<?php
}

function arras_widget_reviews($args) {
	global $allowed_cats;
	
	extract($args, EXTR_SKIP);
	
	$options = get_option('arras_widget_reviews');
	if (!$allowed_cats) $allowed_cats = arras_get_option('gaming_cats');
	
	$r = new WP_Query( array('showposts' => 5, 'cat' => $options['cat'] ) );
	if ($r->have_posts()) :
	?>
		<?php echo $before_widget; ?>
        <?php echo $before_title . $options['title'] . $after_title; ?>
        <ul>
        <?php while ($r->have_posts()) : $r->the_post(); ?> 	
            <li>
                <strong><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?> </a></strong>
            </li>
        <?php endwhile; ?>   
        </ul>
        <?php echo $after_widget; ?>
	<?php
	endif;
}

function arras_widget_reviews_control() {	
	$cats = get_categories();

	$options = $newoptions = get_option('arras_widget_reviews');
	if ( isset($_POST['arras-widget-reviews-submit']) ) {
		$newoptions['title'] = strip_tags( stripslashes($_POST['arras-widget-reviews-title']) );
		$newoptions['cat'] = (int) $_POST['arras-widget-reviews-cat'];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('arras_widget_reviews', $options);
	}
	$title = attribute_escape($options['title']);
	if ($title == '') $title = 'Latest Reviews';
	if ($options['cat'] == 0) $options['cat'] = 1;
?>
	<p><label for="arras-widget-reviews-title"><?php _e('Title:'); ?> <input class="widefat" id="arras-widget-reviews-title" name="arras-widget-reviews-title" type="text" value="<?php echo $title; ?>" /></label></p>
    <p><label for="arras-widget-reviews-cat"><?php _e('Reviews Category:'); ?> <select class="widefat" id="arras-widget-reviews-cat" name="arras-widget-reviews-cat">
		<?php foreach ( $cats as $opt ) : ?>
            <option <?php if ( $options['cat'] == $opt->cat_ID ) echo ' selected="selected"'; ?> value="<?php echo $opt->cat_ID; ?>"><?php echo $opt->name; ?></option>     
        <?php endforeach; ?>
        </select></label></p>
	<input type="hidden" id="arras-widget-reviews-submit" name="arras-widget-reviews-submit" value="1" />
<?php
}

function arras_widget_tabbed_sidebar($args) {
	global $wpdb;
	
	extract($args, EXTR_SKIP);
	
	$options = get_option('arras_widget_tabbed_sidebar');
	$featured = arras_get_option('featured_cat');
?>
	<li id="multi-sidebar-container">
	<div id="multi-sidebar" class="clearfix">
	<ul class="tabs clearfix">
	<?php render_sidebar_tabs( $options['order'], is_numeric($featured) ) ?>
	</ul>
	
<?php	
	foreach( $options['order'] as $tab ) :
	switch($tab) :
	
	case 'featured':
	if ( is_numeric($featured) ) : ?>
	<div id="s-featured" class="widgetcontainer clearfix">
		<ul>
		<?php
		$f = new WP_Query('showposts=5&cat=' . $featured);
		if (!$f->have_posts()) :
		?> <span class="textCenter sub"><?php _e('No posts at the moment. Check back again later!', 'arras') ?></span> <?php
		else:
		while ($f->have_posts()) : $f->the_post() ?>
			<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
			<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
			<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
			</li>    
		<?php endwhile; endif; ?>
		</ul>
	</div><!-- #s-featured -->
	<?php endif;
	break;
	
	case 'latest':
	?>
	<div id="s-latest" class="widgetcontainer clearfix">
	    <ul>
			<?php $l = new WP_Query('showposts=5') ?>
			<?php if (!$l->have_posts()) : ?>
				<span class="textCenter sub"><?php _e('No posts at the moment. Check back again later!', 'arras') ?></span>
			<?php else : ?>
			<?php while($l->have_posts()) : $l->the_post() ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a><br />
				<span class="sub"><?php the_time( __('d F Y g:i A', 'arras') ); ?> | 
				<?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), __('% Comments', 'arras') ); ?></span>
				</li>
			<?php endwhile; endif; ?>
	    </ul>
	</div><!-- #s-latest -->
	<?php
	break;
	
	case 'comments':
	?>
	<div id="s-comments" class="widgetcontainer clearfix">
		<?php $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT 8"); ?>
		<ul id="recentcomments">
		<?php if($comments) : foreach($comments as $comment) :
		echo  '<li class="recentcomments">' .
		/* translators: comments widget: 1: comment author, 2: post link */ 
		sprintf( __('%1$s on %2$s', 'arras'), $comment->comment_author, '<a href="' . clean_url( get_comment_link($comment->comment_ID) ) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
		endforeach; endif;?>
		</ul>
	</div><!-- #s-comments -->
	<?php
	break;
	
	case 'tags':
	?>
	<div id="s-tags" class="widgetcontainer clearfix">
        <?php wp_tag_cloud('smallest=8&largest=18'); ?>
    </div><!-- #s-tags -->
	<?php
	break;
	
	case 'popular':
	?>
	<div id="s-popular" class="widgetcontainer clearfix">
        <?php if ( function_exists('akpc_most_popular') ) akpc_most_popular(); ?>
    </div><!-- #s-popular -->
	<?php
	break;
	
	endswitch;
	endforeach;
?>
	</div><!-- #multi-sidebar -->
	</li><!-- #multi-sidebar-container -->
<?php
}

function arras_widget_tabbed_sidebar_control() {
	$options = $newoptions = get_option('arras_widget_tabbed_sidebar');
	if ( isset($_POST['arras-widget-tabbed-sidebar-submit']) ) {
		$newoptions['order'] = $_POST['arras-widget-tabbed-sidebar-order'];
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option('arras_widget_tabbed_sidebar', $options);
	}
	$order = $options['order'];
	if( !$order ) $order = array('featured', 'latest', 'comments', 'tags');
?>
	<p>
	<label for="arras-widget-tabbed-sidebar-order"><?php _e('Tabbed Sidebar Order:', 'arras') ?></label>
		<select name="arras-widget-tabbed-sidebar-order[0]" style="width: 200px"><?php arras_get_tabbed_opts( $order[0], 'featured'); ?></select><br />
		<select name="arras-widget-tabbed-sidebar-order[1]" style="width: 200px"><?php arras_get_tabbed_opts( $order[1], 'latest'); ?></select><br />
		<select name="arras-widget-tabbed-sidebar-order[2]" style="width: 200px"><?php arras_get_tabbed_opts( $order[2], 'comments'); ?></select><br />
		<select name="arras-widget-tabbed-sidebar-order[3]" style="width: 200px"><?php arras_get_tabbed_opts( $order[3], 'tags'); ?></select>
	</p>
	<p><?php _e('The popular posts option is only enabled when the plugin <a href="http://wordpress.org/extend/plugins/popularity-contest/">Popularity Contest</a> is enabled.', 'arras') ?></p>
	<input type="hidden" id="arras-widget-tabbed-sidebar-submit" name="arras-widget-tabbed-sidebar-submit" value="1" />
<?php	
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
	if ( $show_featured ) $list['featured'] = __('Featured', 'arras');
	
	foreach ($order as $t) { ?>
		<?php if ( !$show_featured ) if ($t == 'featured') continue; ?>
		<?php if ( $t != 'none' ) : ?><li><a href="#s-<?php echo $t; ?>"><span><?php echo $list[$t]; ?></span></a></li><?php endif ?>
	<?php $count++; }
}

// Register Widgets
function arras_register_widgets() {
	unregister_sidebar_widget('widget_search');
	
	register_sidebar_widget( __('Tabbed Sidebar', 'arras'), 'arras_widget_tabbed_sidebar');
	register_widget_control( __('Tabbed Sidebar', 'arras'), 'arras_widget_tabbed_sidebar_control');
	
	register_sidebar_widget( __('Latest Previews', 'arras'), 'arras_widget_previews');
	register_widget_control( __('Latest Previews', 'arras'), 'arras_widget_previews_control');
	
	register_sidebar_widget( __('Latest Reviews', 'arras'), 'arras_widget_reviews');
	register_widget_control( __('Latest Reviews', 'arras'), 'arras_widget_reviews_control');
	
	register_sidebar_widget( __('Search', 'arras'), 'arras_widget_search');
}
add_action('widgets_init', 'arras_register_widgets');

/* End of file widgets-legacy.php */
/* Location: ./library/widgets-legacy.php */
