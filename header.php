<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php arras_document_title() ?></title>
<?php arras_document_description() ?>

<?php if ( is_search() || is_author() ) : ?>
<meta name="robots" content="noindex, nofollow" />
<?php endif ?>

<?php if ( ($feed = arras_get_option('feed_url') ) == '' ) : ?>
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" />
<?php else : ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $feed ?>" title="<?php printf( __( '%s latest posts', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" />
<?php endif; ?>

<?php if ( ($comments_feed = arras_get_option('comments_feed_url') ) == '' ) : ?>
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" />
<?php else : ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $comments_feed ?>" title="<?php printf( __( '%s latest comments', 'arras' ), esc_html( get_bloginfo('name'), 1 ) ) ?>" />
<?php endif; ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( !file_exists(ABSPATH . 'favicon.ico') ) : ?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />
<?php else: ?>
<link rel="shortcut icon" href="<?php echo get_bloginfo('url') ?>/favicon.ico" />
<?php endif; ?>

<?php
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-tabs', null, array('jquery-ui-core', 'jquery'), null, false); 

if ( is_home() || is_front_page() ) {
	wp_enqueue_script('jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.min.js', 'jquery', null, true);
}

if ( !function_exists('pixopoint_menu') ) {
	wp_enqueue_script('hoverintent', get_template_directory_uri() . '/js/superfish/hoverIntent.js', 'jquery', null, false);
	wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish/superfish.js', 'jquery', null, false);
}

if ( is_singular() ) {
	wp_enqueue_script('comment-reply');
	wp_enqueue_script('jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', 'jquery', null, false);
}

?>

<?php wp_head(); ?>
</head>

<body <?php arras_body_class() ?>>
<script type="text/javascript">
//<![CDATA[
(function(){
var c = document.body.className;
c = c.replace(/no-js/, 'js');
document.body.className = c;
})();
//]]>
</script>
<?php arras_body() ?>

<div id="top-menu" class="clearfix">
<?php arras_above_top_menu() ?>
	<?php 
	if ( function_exists('wp_nav_menu') ) {
		wp_nav_menu( array( 
			'sort_column' => 'menu_order', 
			'menu_class' => 'sf-menu menu clearfix', 
			'theme_location' => 'top-menu',
			'container_id' => 'top-menu-content'
		) );
	}
	?>
<?php arras_below_top_menu() ?>
</div><!-- #top-menu -->

<div id="header">
	<div id="branding" class="clearfix">
	<div class="logo">
		<?php if ( is_home() || is_front_page() ) : ?>
		<h1 class="blog-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 class="blog-description"><?php bloginfo('description'); ?></h2>
		<?php else: ?>
		<span class="blog-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span>
		<span class="blog-description"><?php bloginfo('description'); ?></span>
		<?php endif ?>
	</div>
	<div id="searchbar"><?php get_search_form() ?></div>
	</div><!-- #branding -->
</div><!-- #header -->

<?php arras_above_nav() ?>
<div id="nav">
	<div id="nav-content" class="clearfix">
	<?php 
	if ( function_exists('pixopoint_menu') ) {
		pixopoint_menu();
	} elseif ( function_exists('wp_nav_menu') ) {
		wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'sf-menu menu clearfix', 'theme_location' => 'main-menu', 'fallback_cb' => 'arras_nav_fallback_cb' ) );
	} else { ?>
		<ul class="sf-menu menu clearfix">
			<li><a href="<?php bloginfo('url') ?>"><?php _e( arras_get_option('topnav_home') ); ?></a></li>
			<?php 
			if (arras_get_option('topnav_display') == 'pages') {
				wp_list_pages('sort_column=menu_order&title_li=');
			} else if (arras_get_option('topnav_display') == 'linkcat') {
				wp_list_bookmarks('category='.arras_get_option('topnav_linkcat').'&hierarchical=0&show_private=1&hide_invisible=0&title_li=&categorize=0&orderby=id'); 
			} else {
				wp_list_categories('hierarchical=1&orderby=id&hide_empty=1&title_li=');	
			}
			?>
		</ul>
	<?php } ?>
	<?php arras_beside_nav() ?>
	</div><!-- #nav-content -->
</div><!-- #nav -->
<?php arras_below_nav() ?>

<div id="wrapper">
	
	<?php arras_above_main() ?>
  
	<div id="main" class="clearfix">
    <div id="container" class="clearfix">
