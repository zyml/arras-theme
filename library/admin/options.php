<?php

class Options {
	
	// General Settings
	var $version, $donate, $feed_url, $comments_feed_url, $twitter_username, $facebook_profile, $footer_title, $footer_message;
	// Navigation
	var $topnav_home, $topnav_display, $topnav_linkcat;
	// Home
	var $enable_slideshow, $slideshow_cat, $slideshow_count;
	var $enable_featured1, $featured1_title, $featured1_cat, $featured1_display, $featured1_count, $featured1_offset;
	var $enable_featured2, $featured2_title, $featured2_cat, $featured2_display, $featured2_count, $featured2_offset;
	var $enable_news, $news_title, $news_cat, $news_display, $index_count, $news_offset;
	// Layout
	var $archive_display;
	var $display_author, $single_meta_pos, $single_custom_fields;
	var $excerpt_limit;
	
	// added in 1.3.4
	var $post_author, $post_date, $post_cats, $post_tags, $postbar_footer, $single_thumbs;
	
	// Thumbnail Sizes - added in 1.4.0
	var $auto_thumbs, $custom_thumbs;
	
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

		$this->topnav_home = __('Home', 'arras');
		$this->topnav_display = 'categories';
		$this->topnav_linkcat = 0;
		
		$this->enable_slideshow = true;
		$this->slideshow_cat = 0;
		$this->slideshow_count = 4;
		
		$this->enable_featured1 = true;
		$this->featured1_title = __('Featured Stories', 'arras');
		$this->featured1_cat = 0;
		$this->featured1_display = 'default';
		$this->featured1_count = 3;
		$this->featured1_offset = false;
		
		$this->enable_featured2 = true;
		$this->featured2_title = __("Editors' Picks", 'arras');
		$this->featured2_cat = 0;
		$this->featured2_display = 'quick';
		$this->featured2_count = 3;
		$this->featured2_offset = false;
		
		$this->enable_news = true;
		$this->news_title = __('Latest Headlines', 'arras');
		$this->news_cat = 0;
		$this->news_display = 'line';
		$this->index_count = get_option('posts_per_page');
		$this->news_offset = false;

		$this->archive_display = 'quick';
		
		$this->display_author = true;
		
		$this->post_author = true;
		$this->post_date = true;
		$this->post_cats = true;
		$this->post_tags = true;
		$this->single_thumbs = false;
		
		$this->single_meta_pos = 'top';
		$this->single_custom_fields = 'Score:score,Pros:pros,Cons:cons';
		
		$this->excerpt_limit = 30;
		
		$this->layout = '2c-r-fixed';
		$this->style = 'default';
		
		$this->auto_thumbs = true;
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
		
		if ( !function_exists('wp_nav_menu') ) {
			$this->topnav_home = (string)$_POST['arras-nav-home'];
			$this->topnav_display = (string)$_POST['arras-nav-display'];
			$this->topnav_linkcat = (int)$_POST['arras-nav-linkcat'];
		}
		
		$this->enable_slideshow = isset($_POST['arras-enable-slideshow']);
		$this->slideshow_cat = $_POST['arras-cat-slideshow'];
		$this->slideshow_count = (int)stripslashes($_POST['arras-layout-slideshow-count']);
		
		$this->enable_featured1 = isset($_POST['arras-enable-featured1']);
		$this->featured1_title = (string)$_POST['arras-layout-featured1-title'];
		$this->featured1_cat = $_POST['arras-cat-featured1'];
		$this->featured1_display = (string)$_POST['arras-layout-featured1-display'];
		$this->featured1_count = (int)stripslashes($_POST['arras-layout-featured1-count']);
		$this->featured1_offset = isset($_POST['arras-layout-featured1-offset']);
		
		$this->enable_featured2 = isset($_POST['arras-enable-featured2']);
		$this->featured2_title = (string)$_POST['arras-layout-featured2-title'];
		$this->featured2_cat = $_POST['arras-cat-featured2'];
		$this->featured2_display = (string)$_POST['arras-layout-featured2-display'];
		$this->featured2_count = (int)stripslashes($_POST['arras-layout-featured2-count']);
		$this->featured2_offset = isset($_POST['arras-layout-featured2-offset']);
		
		$this->enable_news = isset($_POST['arras-enable-news']);
		$this->news_title = (string)$_POST['arras-layout-news-title'];
		$this->news_cat = $_POST['arras-cat-news'];
		$this->news_display = (string)$_POST['arras-layout-index-newsdisplay'];
		$this->index_count = (int)stripslashes($_POST['arras-layout-index-count']);
		$this->news_offset = isset($_POST['arras-layout-news-offset']);
		
		$this->excerpt_limit = (int)$_POST['arras-layout-limit-words'];
		
		$this->archive_display = (string)$_POST['arras-layout-archive-newsdisplay'];

		$this->display_author = isset($_POST['arras-layout-single-author']);
		
		$this->post_author = isset($_POST['arras-layout-post-author']);
		$this->post_date = isset($_POST['arras-layout-post-date']);
		$this->post_cats = isset($_POST['arras-layout-post-cats']);
		$this->post_tags = isset($_POST['arras-layout-post-tags']);
		$this->single_thumbs = isset($_POST['arras-layout-single-thumbs']);
		
		$this->single_meta_pos = (string)$_POST['arras-layout-metapos'];
		$this->single_custom_fields = (string)$_POST['arras-single-custom-fields'];
		
		if ( !defined('ARRAS_INHERIT_LAYOUT') || ARRAS_INHERIT_LAYOUT == true ) {
			$this->layout = (string)$_POST['arras-layout-col'];
		}
		
		if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
			$this->style = (string)$_POST['arras-style'];
		}
		
		$this->auto_thumbs = isset($_POST['arras-thumbs-auto']);
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
	
	if ($arras_options->version != ARRAS_VERSION) {
		arras_upgrade_options();
	}
	
	return $arras_options;
}

function arras_update_options() {
	global $arras_options;
	update_option('arras_options', maybe_serialize($arras_options));
}

function arras_upgrade_options() {
	$custom_thumbs = $arras_options->custom_thumbs;
	$custom_thumbs['node-based-thumb']['w'] = $arras_options->featured_thumb_w;
	$custom_thumbs['node-based-thumb']['h'] = $arras_options->featured_thumb_h;
	$custom_thumbs['quick-preview-thumb']['w'] = $arras_options->news_thumb_w;
	$custom_thumbs['quick-preview-thumb']['h'] = $arras_options->news_thumb_h;
	
	$arras_options->custom_thumbs = $custom_thumbs;
	$arras_options->version = ARRAS_VERSION;
	arras_update_options();
}

function arras_get_option($name) {
	global $arras_options;
	
	if (!is_object($arras_options) )
		arras_flush_options();
	
	return $arras_options->$name;
}

/* End of file options.php */
/* Location: ./admin/options.php */
