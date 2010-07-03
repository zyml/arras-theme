<?php

/**
 * Called after wp_head() in the <head> tag
 * @since 1.2.1
 */
function arras_head() {
	do_action('arras_head');
}

/**
 * Called after the <body> tag is declared
 * @since 1.2.2 
 */
function arras_body() {
	do_action('arras_body');	
}

/**
 * Called before any content on the main container
 * @since 1.4.3
 */
function arras_above_main() {
	do_action('arras_above_main');
}

/**
 * Called before any content on the main column
 * @since 1.2.2
 */
function arras_above_content() {
	do_action('arras_above_content');
}

/**
 * Called before any content on the main column
 * @since 1.2.2
 */
function arras_below_content() {
	do_action('arras_below_content');
}

/**
 * Called before the top menus
 * @since 1.5 
 */
function arras_above_top_menu() {
	do_action('arras_above_top_menu');
}

/**
 * Called after the top menus
 * @since 1.5 
 */
function arras_below_top_menu() {
	do_action('arras_below_top_menu');
}

/**
 * Called before the main navigation
 * @since 1.2.1 
 */
function arras_above_nav() {
	do_action('arras_above_nav');
}

/**
 * Called after the main navigation
 * @since 1.2.1 
 */
function arras_below_nav() {
	do_action('arras_below_nav');
}

/**
 * Called before the main sidebar
 * @since 1.2.1 
 */
function arras_above_sidebar() {
	do_action('arras_above_sidebar');
}

/**
 * Called after the main sidebar
 * @since 1.2.1 
 */
function arras_below_sidebar() {
	do_action('arras_below_sidebar');
}

/**
 * Called before the post content, before the title
 * @since 1.2.1 
 */
function arras_above_post() {
	do_action('arras_above_post');
}

/**
 * Called after the post content, before the comments
 * @since 1.2.1 
 */
function arras_below_post() {
	do_action('arras_below_post');
}

/**
 * Called after the comments (form)
 * @since 1.2.1 
 */
function arras_below_comments() {
	do_action('arras_below_comments');
}

/**
 * Called before the footer
 * @since 1.2.1 
 */
function arras_before_footer() {
	do_action('arras_before_footer');
}

/**
 * Called right before the closing <body> tag
 * @since 1.2.1 
 */
function arras_footer() {
	do_action('arras_footer');
}

/**
 * Called before the news posts in the index page
 * @since 1.2.1
 */
function arras_above_index_news_post() {
	do_action('arras_above_index_news_post');	
}

/**
 * Called after the news posts in the index page
 * @since 1.2.1
 */
function arras_below_index_news_post() {
	do_action('arras_below_index_news_post');	
}

/**
 * Called before the featured post (#1) in the index page
 * @since 1.4.3
 */
function arras_above_index_featured_post() {
	arras_above_index_featured1_post();
}

/**
 * Called before the featured post #1 in the index page
 * @since 1.5
 */
function arras_above_index_featured1_post() {
	do_action('arras_above_index_featured1_post');	
}

/**
 * Called before the featured post #2 in the index page
 * @since 1.5
 */
function arras_above_index_featured2_post() {
	do_action('arras_above_index_featured2_post');	
}

/**
 * Called right after the main navigation
 * @since 1.5
 */
function arras_beside_nav() {
	do_action('arras_beside_nav');	
}
/* End of file actions.php */
/* Location: ./library/actions.php */
