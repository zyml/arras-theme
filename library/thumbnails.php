<?php

function arras_get_thumbnail($size = 'thumbnail', $id = NULL) {
	global $post;
	if ($post) $id = $post->ID;
	
	// get post thumbnail (WordPress 2.9)
	if (function_exists('has_post_thumbnail')) {
		if (has_post_thumbnail($id)) {
			return get_the_post_thumbnail( $id, $size, array(
				'alt' 	=> trim(strip_tags($post->post_excerpt)), 
				'title' => trim(strip_tags($post->post_title))
			) );
		}
	}
	
	// go back to legacy (phpThumb or timThumb)
	$thumbnail = get_post_meta($id, ARRAS_POST_THUMBNAIL, true);
	
	if ($thumbnail != '') {
		switch($size) {
			case 'sidebar-thumb':
				$sidebar_thumb_size = arras_get_sidebar_thumb_size();
				$w = $sidebar_thumb_size[0];
				$h = $sidebar_thumb_size[1];
				break;
			case 'featured-slideshow-thumb':
				$slideshow_thumb_size = arras_get_slideshow_thumb_size();
				$w = $slideshow_thumb_size[0];
				$h = $slideshow_thumb_size[1];
				break;
			case 'featured-post-thumb':
				$w = arras_get_option('featured_thumb_w');
				$h = arras_get_option('featured_thumb_h');
				break;
			case 'news-post-thumb':
				$w = arras_get_option('news_thumb_w');
				$h = arras_get_option('news_thumb_h');				
				break;
			case 'archive-post-thumb':
				$w = arras_get_option('news_thumb_w');
				$h = arras_get_option('news_thumb_h');				
				break;
			default:
				$w = get_option('thumbnail_size_w');
				$h = get_option('thumbnail_size_h');
		}
		
		return '<img src="' . get_bloginfo('template_directory') . '/library/timthumb.php?src=' . $thumbnail . '&amp;w=' . $w . '&amp;h=' . $h . '&amp;zc=1" alt="' . get_the_excerpt() . '" title="' . get_the_title() . '" />';
	}
	
	return '<img src="' . get_bloginfo('template_directory') . '/images/thumbnail.png" alt="' . get_the_excerpt() . '" title="' . get_the_title() . '" />';	
}

function arras_get_sidebar_thumb_size() {
	$_default_size = array(36, 36);
	return apply_filters('arras_sidebar_thumb_size', $_default_size);
}

function arras_add_regenthumbs_menu() {
	$regen_page = add_submenu_page( 'arras-options', __('Regenerate Thumbnails', 'arras'), __('Regen. Thumbnails', 'arras'), 'edit_options', 'arras-regen-thumbs', 'arras_regen_thumbs' );
	
	add_action('admin_print_scripts-'. $regen_page, 'arras_regenthumbs_scripts');
	add_action('admin_print_styles-'. $regen_page, 'arras_regenthumbs_styles');
	
}

function arras_regenthumbs_scripts() {
	wp_enqueue_script('jquery-ui-progressbar', get_template_directory_uri() . '/js/jquery-ui.progressbar.min.js', null, 'jquery');
}

function arras_regenthumbs_styles() {
?> <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/admin.css" type="text/css" /> <?php
}


function arras_regen_thumbs() {
	global $wpdb;
?>
<div class="wrap clearfix">

<?php screen_icon('themes') ?>
<h2 id="arras-header"><?php _e('Arras Theme &ndash; Regenerate Thumbnails', 'arras') ?></h2>

<div id="message" class="updated fade" style="display:none"></div>

<?php
		// If the button was clicked
		if ( !empty($_POST['arras-regen-thumbs']) ) {
			// Capability check
			if ( !current_user_can('manage_options') )
				wp_die( __('Cheatin&#8217; uh?') );

			// Form nonce check
			check_admin_referer( 'regenerate-thumbnails' );


			// Just query for the IDs only to reduce memory usage
			$images = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%'" );

			// Make sure there are images to process
			if ( empty($images) ) {
				echo '	<p>' . sprintf( __( "Unable to find any images. Are you sure <a href='%s'>some exist</a>?", 'arras' ), admin_url('upload.php?post_mime_type=image') ) . "</p>\n\n";
			}

			// Valid results
			else {
				echo '	<p>' . __( "Please be patient while all thumbnails are regenerated. This can take a while if your server is slow (cheap hosting) or if you have many images. Do not navigate away from this page until this script is done or all thumbnails won't be resized. You will be notified via this page when all regenerating is completed.", 'arras' ) . '</p>';

				// Generate the list of IDs
				$ids = array();
				foreach ( $images as $image )
					$ids[] = $image->ID;
				$ids = implode( ',', $ids );

				$count = count( $images );
?>


	<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'arras' ) ?></em></p></noscript>

	<div id="regenthumbsbar" style="position:relative;height:25px;">
		<div id="regenthumbsbar-percent" style="position:absolute;left:50%;top:50%;width:50px;margin-left:-25px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
	</div>

	<script type="text/javascript">
	// <![CDATA[
		jQuery(document).ready(function($){
			var i;
			var rt_images = [<?php echo $ids; ?>];
			var rt_total = rt_images.length;
			var rt_count = 1;
			var rt_percent = 0;

			$("#regenthumbsbar").progressbar();
			$("#regenthumbsbar-percent").html( "0%" );

			function RegenThumbs( id ) {
				$.post( "admin-ajax.php", { action: "regenthumbnail", id: id }, function() {
					rt_percent = ( rt_count / rt_total ) * 100;
					$("#regenthumbsbar").progressbar( "value", rt_percent );
					$("#regenthumbsbar-percent").html( Math.round(rt_percent) + "%" );
					rt_count = rt_count + 1;

					if ( rt_images.length ) {
						RegenThumbs( rt_images.shift() );
					} else {
						$("#message").html("<p><strong><?php echo js_escape( sprintf( __( 'All done! Processed %d images.', 'arras' ), $count ) ); ?></strong></p>");
						$("#message").show();
					}

				});
			}

			RegenThumbs( rt_images.shift() );
		});
	// ]]>
	</script>
<?php
			}
		}

		// No button click? Display the form.
		else {
?>
<p><?php _e( "Use this tool to regenerate thumbnails for all images that you have uploaded to your blog. This is useful if you have changed your layout, or edited any of the thumbnail sizes. Old thumbnails will be kept to avoid any broken images due to hard-coded URLs.", 'arras' ); ?></p>

<p><?php _e( "This process is not reversible, although you can just change your thumbnail dimensions back to the old values and click the button again if you don't like the results.", 'arras'); ?></p>

<p><?php _e( "To begin, just press the button below.", 'arras'); ?></p>

<p><?php printf( __("Based on Viper007Bond's <a href='%s'>Regenerate Thumbnails</a> plugin.", 'arras'), 'http://wordpress.org/extend/plugins/regenerate-thumbnails/' ) ?></p>

<form method="post" action="">
<?php wp_nonce_field('regenerate-thumbnails') ?>

<p><input type="submit" class="button hide-if-no-js" name="arras-regen-thumbs" id="arras-regen-thumbs" value="<?php _e( 'Regenerate All Thumbnails', 'arras' ) ?>" /></p>

<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'arras' ) ?></em></p></noscript>

</form>

</div><!-- .wrap -->
<?php
	}

}

function arras_ajax_process_image() {
	if ( !current_user_can( 'manage_options' ) )
		die('-1');

	$id = (int) $_REQUEST['id'];

	if ( empty($id) )
		die('-1');

	$fullsizepath = get_attached_file( $id );

	if ( false === $fullsizepath || !file_exists($fullsizepath) )
		die('-1');

	set_time_limit( 60 );

	if ( wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $fullsizepath ) ) )
		die('1');
	else
		die('-1');
}

/* End of file thumbnails.php */
/* Location: ./library/thumbnails.php */
