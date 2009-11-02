<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php arras_document_title() ?></title>
<meta name="description" content="<?php bloginfo('description') ?>" />
<?php if ( is_search() || is_author() ) : ?>
<meta name="robots" content="noindex, nofollow" />
<?php endif ?>

<?php arras_alternate_style() ?>

<?php if ( ($feed = arras_get_option('feed_url') ) == '' ) : ?>
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'arras' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
<?php else : ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $feed ?>" title="<?php printf( __( '%s latest posts', 'arras' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
<?php endif; ?>

<?php if ( ($comments_feed = arras_get_option('comments_feed_url') ) == '' ) : ?>
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'arras' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
<?php else : ?>
<link rel="alternate" type="application/rss+xml" href="<?php echo $comments_feed ?>" title="<?php printf( __( '%s latest comments', 'arras' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
<?php endif; ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />

<?php
if ( $wp_version != '2.8') {
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-1.3.2.min.js', null, '1.3.2', false);
	wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui-1.7.1.min.js', 'jquery', '1.7.1', false);
} else {
	wp_enqueue_script('jquery-ui-tabs', null, array('jquery', 'jquery-ui-core'), '1.7.1', false);
}

if ( is_home() || is_front_page() ) {
	wp_enqueue_script('jquery-cycle', get_template_directory_uri() . '/js/jquery.cycle.lite.min.js', 'jquery', null, true);
}

if ( !function_exists('pixopoint_menu') ) {
	wp_enqueue_script('hoverintent', get_template_directory_uri() . '/js/superfish/hoverIntent.js', 'jquery', null, false);
	wp_enqueue_script('superfish', get_template_directory_uri() . '/js/superfish/superfish.js', 'jquery', null, false);
}

if ( is_singular() ) {
	wp_enqueue_script('comment-reply');
	wp_enqueue_script('jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', 'jquery', null, false);
}

wp_head();
arras_head();
?>
<script type="text/javascript">
<?php @include 'js/header.js.php'; ?>
</script>

<!--[if IE 6]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie6.css" type="text/css" media="screen, projector" />
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.supersleight.min.js"></script>
<script type="text/javascript">
	$('#controls').supersleight( {shim: '<?php bloginfo('template_url') ?>/images/x.gif'} );
	$('.featured-article').supersleight( {shim: '<?php bloginfo('template_url') ?>/images/x.gif'} );
</script>
<![endif]-->
</head>

<body <?php arras_body_class() ?>>
<?php arras_body() ?>
<div id="wrapper">

    <div id="header">
    	<div id="branding" class="clearfix">
        <div class="logo clearfix">
        	<?php if ( is_home() || is_front_page() ) : ?>
            <h1 class="blog-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
            <h2 class="blog-description"><?php bloginfo('description'); ?></h2>
            <?php else: ?>
            <span class="blog-name"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span>
            <span class="blog-description"><?php bloginfo('description'); ?></span>
            <?php endif ?>
        </div>
        <div id="searchbar">
            <?php include (TEMPLATEPATH . '/searchform.php'); ?>  
        </div>
        </div><!-- #branding -->
    </div><!-- #header -->
	
	<?php arras_above_nav() ?>
    <div id="nav">
    	<div id="nav-content" class="clearfix">
		<?php if ( function_exists('pixopoint_menu') ): ?>
		<?php pixopoint_menu(); ?>
		<?php else : ?>
			<ul class="sf-menu menu clearfix">
				<li><a href="<?php bloginfo('url') ?>"><?php echo arras_get_option('topnav_home') ?></a></li>
				<?php 
				if (arras_get_option('topnav_display') == 'pages') {
					wp_list_pages('sort_column=menu_order&title_li=');
				} else if (arras_get_option('topnav_display') == 'linkcat') {
					wp_list_bookmarks('category='.arras_get_option('topnav_linkcat').'&hierarchical=0&show_private=1&hide_invisible=0&title_li=&categorize=0&orderby=id'); 
				} else {
					wp_list_categories('number=11&hierarchical=1&orderby=id&hide_empty=1&title_li=');	
				}
				?>
			</ul>
		<?php endif ?>
			<ul class="rss clearfix">
				<?php if ($feed == '') : ?>
					<li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Posts', 'arras') ?></a></li>
				<?php else : ?>
					<li><a href="<?php echo $feed; ?>"><?php _e('Posts', 'arras') ?></a></li>
				<?php endif; ?>
				<?php if ($comments_feed == '') : ?>
					<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments', 'arras') ?></a></li>
				<?php else : ?>
					<li><a href="<?php echo $comments_feed; ?>"><?php _e('Comments', 'arras') ?></a></li>
				<?php endif; ?>
			</ul>
		</div><!-- #nav-content -->
    </div><!-- #nav -->
	<?php arras_below_nav() ?>
    
	<div id="main">
    <div id="container" class="clearfix">
