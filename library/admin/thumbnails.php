<?php
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

function arras_regen_thumbs_process() {
	global $wpdb;
	
	echo '<div id="message" class="updated fade" style="display:none"></div>';
	
	// Just query for the IDs only to reduce memory usage
	$images = $wpdb->get_results( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_mime_type LIKE 'image/%'" );
	
	if ( empty($images) ) {
		echo '	<p>' . sprintf( __( "Unable to find any images. Are you sure <a href='%s'>some exist</a>?", 'arras' ), admin_url('upload.php?post_mime_type=image') ) . "</p>\n\n";
	} else {
		echo '	<p>' . __( "Please be patient while all thumbnails are regenerated. This can take a while if your server is slow (cheap hosting) or if you have many images. Do not navigate away from this page until this script is done or all thumbnails won't be resized. You will be notified via this page when all regenerating is completed.", 'arras' ) . '</p>';
		// Generate the list of IDs
		$ids = array();
		foreach ( $images as $image )
			$ids[] = $image->ID;
		$ids = implode( ',', $ids );

		$count = count($images);
		?>
		<noscript><p><em><?php _e( 'You must enable Javascript in order to proceed!', 'arras' ) ?></em></p></noscript>
		
		<div id="regenthumbsbar" style="position:relative;height:25px;">
			<div id="regenthumbsbar-percent" style="position:absolute;left:50%;top:50%;width:50px;margin-left:-25px;height:25px;margin-top:-9px;font-weight:bold;text-align:center;"></div>
		</div>
		
		<p class="final-submit" style="display:none">
		<a class="button-primary" href="admin.php?page=arras-options"><?php _e('Back to Theme Options', 'arras') ?></a>
		</p>

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

				function RegenThumbs(id) {
					$.post("admin-ajax.php", { action: "regenthumbnail", id: id }, function() {
						rt_percent = ( rt_count / rt_total ) * 100;
						$("#regenthumbsbar").progressbar( "value", rt_percent );
						$("#regenthumbsbar-percent").html( Math.round(rt_percent) + "%" );
						rt_count = rt_count + 1;

						if ( rt_images.length ) {
							RegenThumbs( rt_images.shift() );
						} else {
							$("#message").html("<p><strong><?php echo esc_js( sprintf(__( 'All done! Processed %d images.', 'arras'), $count) ); ?></strong></p>");
							$("#message").show();
							$('.final-submit').show();
						}

					});
				}

				RegenThumbs(rt_images.shift());
			});
		// ]]>
		</script>
		<?php
	}
}

/* End of file thumbnails.php */
/* Location: ./library/admin/thumbnails.php */