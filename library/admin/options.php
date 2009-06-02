<?php

class Options {
	
	// General Settings
	var $version, $donate, $feed_url, $comments_feed_url, $footer_title, $footer_message;
	// Categories
	var $featured_cat1, $featured_cat2, $news_cat;
	// Navigation
	var $topnav_home, $topnav_display, $topnav_linkcat;
	// Layout
	var $featured1_count, $featured2_count, $index_count;
	var $featured2_news_display, $index_news_display, $index_news_thumbs;
	var $archive_news_display, $archive_news_thumbs;
	var $display_author, $single_thumbs, $single_meta_pos, $single_custom_fields;
	
	// added in 1.3.4
	var $post_author, $post_date, $post_cats, $post_tags, $postbar_header, $postbar_footer;
	
	// Design
	var $layout, $style, $background, $background_type, $background_tiling;
	
	
	function default_options() {
		$this->version = ARRAS_VERSION;
		$this->donate = false;
		
		$this->feed_url = get_bloginfo('rss2_url');
		$this->comments_feed_url = get_bloginfo('comments_rss2_url');
		$this->footer_title = __('Copyright', 'arras');
		$this->footer_message = sprintf( __('Copyright %s. All Rights Reserved.', 'arras'), get_bloginfo('name') );
		
		$this->featured_cat = 0;
		
		$this->topnav_home = __('Home', 'arras');
		$this->topnav_display = 'categories';
		$this->topnav_linkcat = 0;
		
		$this->featured1_count = 4;
		$this->featured2_count = 3;
		
		$this->index_count = get_option('posts_per_page');
		
		$this->featured2_news_display = 'default';
		
		$this->index_news_display = 'line';
		
		$this->archive_news_display = 'line';
		
		$this->display_author = true;
		$this->single_thumbs = true;
		
		$this->post_author = true;
		$this->post_date = true;
		$this->post_cats = true;
		$this->post_tags = true;
		$this->postbar_header = true;
		$this->postbar_footer = true;
		
		$this->layout = '2c-r-fixed';
		$this->style = 'default';
		
		$this->background = 'none';
		$this->background_type = 'custom';
		$this->background_tiling = 'none';
		
		$this->single_meta_pos = 'top';
		$this->single_custom_fields = 'Score:score,Pros:pros,Cons:cons';
	}
	
	function get_options() {		
		$saved_options = unserialize(get_option('arras_options'));
		if (!empty($saved_options) && is_object($saved_options)) {
			foreach($saved_options as $name => $value) {
				// Apply filters if qTranslate is enabled
				if ( function_exists('qtrans_init') && (!isset($_GET['page']) || $_GET['page'] != 'arras-options') ) 
					$value = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($value);
					
				$this->$name = $value;
			}	
		}
	}
	
	function save_options() {
		$this->version = ARRAS_VERSION;
		
		$this->feed_url = (string)$_POST['arras-rss-feed-url'];
		$this->comments_feed_url = (string)$_POST['arras-rss-comments-url'];
		$this->footer_title = (string)stripslashes($_POST['arras-footer-title']);
		$this->footer_message = (string)($_POST['arras-footer-message']);
		
		$this->featured_cat1 = (int)$_POST['arras-cat-featured1'];
		$this->featured_cat2 = (int)$_POST['arras-cat-featured2'];
		$this->news_cat = (int)$_POST['arras-cat-news'];
		
		$this->topnav_home = (string)$_POST['arras-nav-home'];
		$this->topnav_display = (string)$_POST['arras-nav-display'];
		$this->topnav_linkcat = (int)$_POST['arras-nav-linkcat'];
		
		$this->featured1_count = (int)stripslashes($_POST['arras-layout-featured1-count']);
		$this->featured2_count = (int)stripslashes($_POST['arras-layout-featured2-count']);
		
		$this->index_count = (int)stripslashes($_POST['arras-layout-index-count']);
		
		$this->featured2_news_display = (string)$_POST['arras-layout-featured2-display'];
		$this->index_news_display = (string)$_POST['arras-layout-index-newsdisplay'];
		$this->archive_news_display = (string)$_POST['arras-layout-archive-newsdisplay'];
		
		$this->display_author = (boolean)$_POST['arras-layout-single-author'];
		$this->single_thumbs = (boolean)$_POST['arras-layout-single-thumb'];
		
		$this->post_author = (boolean)$_POST['arras-layout-post-author'];
		$this->post_date = (boolean)$_POST['arras-layout-post-date'];
		$this->post_cats = (boolean)$_POST['arras-layout-post-cats'];
		$this->post_tags = (boolean)$_POST['arras-layout-post-tags'];
		$this->postbar_header = (boolean)$_POST['arras-layout-post-barheader'];
		$this->postbar_footer = (boolean)$_POST['arras-layout-post-barfooter'];
		
		$this->single_meta_pos = (string)$_POST['arras-layout-metapos'];
		$this->single_custom_fields = (string)$_POST['arras-single-custom-fields'];
		
		$this->layout = (string)$_POST['arras-layout-col'];
		$this->style = (string)$_POST['arras-style'];
		
		$this->background = (string)$_POST['arras-background'];
		$this->background_type = (string)$_POST['arras-background-type'];
		$this->background_tiling = (string)$_POST['arras-background-tiling'];
		$this->background_color = (string)$_POST['arras-background-color'];	
	}

}

function arras_flush_options() {
	global $arras_options;
	
	$arras_options = new Options;
	$arras_options->get_options();
	
	if ( !get_option('arras_options') ) $arras_options->default_options();
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
