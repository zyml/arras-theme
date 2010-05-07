<?php

class Options {
	
	// General Settings
	var $version, $donate, $feed_url, $comments_feed_url, $twitter_username, $facebook_profile, $footer_title, $footer_message;
	// Categories
	var $slideshow_cat, $featured_cat, $news_cat;
	// Navigation
	var $topnav_home, $topnav_display, $topnav_linkcat;
	// Layout
	var $slideshow_full_width, $slideshow_count, $featured_count, $index_count;
	var $featured_title, $news_title;
	var $featured_display, $news_display, $index_news_thumbs;
	var $archive_display, $archive_news_thumbs;
	var $display_author, $single_meta_pos, $single_custom_fields;
	var $node_based_limit_words;
	
	// added in 1.3.4
	var $post_author, $post_date, $post_cats, $post_tags, $postbar_footer, $single_thumbs;
	
	// Thumbnail Sizes - added in 1.4.0
	var $featured_thumb_w, $featured_thumb_h, $news_thumb_w, $news_thumb_h;
	
	// Design
	var $layout, $style, $logo;
	
	
	function __construct() {
		$this->default_options();
	}
	
	function Options() {
		return $this->__construct();
	}
	
	function default_options() {
		$this->version = ARRAS_VERSION;
		$this->donate = false;
		
		$this->feed_url = get_bloginfo('rss2_url');
		$this->comments_feed_url = get_bloginfo('comments_rss2_url');
		
		$this->footer_title = __('Copyright', 'arras');
		$this->footer_message = '<p>' . sprintf( __('Copyright %s. All Rights Reserved.', 'arras'), get_bloginfo('name') ) . '</p>';
		
		$this->featured_cat = 0;
		
		$this->topnav_home = __('Home', 'arras');
		$this->topnav_display = 'categories';
		$this->topnav_linkcat = 0;
		
		$this->featured_title = __('Featured Stories', 'arras');
		$this->news_title = __('Latest Headlines', 'arras');
		
		$this->slideshow_full_width = false;
		$this->slideshow_count = 4;
		$this->featured_count = 3;
		
		$this->index_count = get_option('posts_per_page');
		
		$this->featured_display = 'default';	
		$this->news_display = 'line';
		$this->archive_display = 'quick';
		
		$this->display_author = true;
		
		$this->post_author = true;
		$this->post_date = true;
		$this->post_cats = true;
		$this->post_tags = true;
		$this->single_thumbs = false;
		
		$this->single_meta_pos = 'top';
		$this->single_custom_fields = 'Score:score,Pros:pros,Cons:cons';
		
		$this->node_based_limit_words = 30;
		
		$this->layout = '2c-r-fixed';
		$this->style = 'default';
		
		$this->featured_thumb_w = 195;
		$this->featured_thumb_h = 110;
		
		$this->news_thumb_w = 155;
		$this->news_thumb_h = 155;
	}
	
	function save_options() {
		$this->version = ARRAS_VERSION;
		$this->donate = !isset($_POST['arras-credits']);
		
		$this->feed_url = (string)$_POST['arras-rss-feed-url'];
		$this->comments_feed_url = (string)$_POST['arras-rss-comments-url'];
		$this->twitter_username = (string)$_POST['arras-twitter'];
		$this->facebook_profile = (string)$_POST['arras-facebook'];
		$this->footer_title = (string)stripslashes($_POST['arras-footer-title']);
		$this->footer_message = (string)($_POST['arras-footer-message']);
		
		$this->slideshow_cat = (int)$_POST['arras-cat-featured1'];
		$this->featured_cat = (int)$_POST['arras-cat-featured2'];
		$this->news_cat = (int)$_POST['arras-cat-news'];
		
		if ( !function_exists('wp_nav_menu') ) {
			$this->topnav_home = (string)$_POST['arras-nav-home'];
			$this->topnav_display = (string)$_POST['arras-nav-display'];
			$this->topnav_linkcat = (int)$_POST['arras-nav-linkcat'];
		}
		
		$this->node_based_limit_words = (int)$_POST['arras-layout-limit-words'];
		
		$this->slideshow_full_width = isset($_POST['arras-slideshow-fullwidth']);
		$this->slideshow_count = (int)stripslashes($_POST['arras-layout-featured1-count']);
		$this->featured_count = (int)stripslashes($_POST['arras-layout-featured2-count']);
		
		$this->index_count = (int)stripslashes($_POST['arras-layout-index-count']);
		
		$this->featured_title = (string)$_POST['arras-layout-featured-title'];
		$this->news_title = (string)$_POST['arras-layout-news-title'];
		
		$this->featured_display = (string)$_POST['arras-layout-featured2-display'];
		$this->news_display = (string)$_POST['arras-layout-index-newsdisplay'];
		$this->archive_display = (string)$_POST['arras-layout-archive-newsdisplay'];
		
		$this->display_author = isset($_POST['arras-layout-single-author']);
		
		$this->post_author = isset($_POST['arras-layout-post-author']);
		$this->post_date = isset($_POST['arras-layout-post-date']);
		$this->post_cats = isset($_POST['arras-layout-post-cats']);
		$this->post_tags = isset($_POST['arras-layout-post-tags']);
		$this->single_thumbs = isset($_POST['arras-layout-single-thumbs']);
		
		$this->single_meta_pos = (string)$_POST['arras-layout-metapos'];
		$this->single_custom_fields = (string)$_POST['arras-single-custom-fields'];
		
		$this->layout = (string)$_POST['arras-layout-col'];
		$this->style = (string)$_POST['arras-style'];
		
		$this->featured_thumb_w = (int)$_POST['arras-featured-thumb-w'];
		$this->featured_thumb_h = (int)$_POST['arras-featured-thumb-h'];
		
		$this->news_thumb_w = (int)$_POST['arras-news-thumb-w'];
		$this->news_thumb_h = (int)$_POST['arras-news-thumb-h'];
	}

}


function arras_flush_options() {
	global $arras_options;
	
	$opts = maybe_unserialize( get_option('arras_options') );
	if (is_a($opts, 'Options')) {
		$arras_options = $opts;
	} else {
		$arras_options = new Options();
	}
	
	return $arras_options;
}

function arras_update_options() {
	global $arras_options;
	update_option('arras_options', maybe_serialize($arras_options));
}

function arras_get_option($name) {
	global $arras_options;
	
	if (!is_object($arras_options) )
		arras_flush_options();
	
	return $arras_options->$name;
}

/* End of file options.php */
/* Location: ./admin/options.php */
