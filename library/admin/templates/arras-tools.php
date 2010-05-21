<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="tools" class="padding-content">

<h3><?php _e('Regenerate Thumbnails', 'arras') ?></h3>
<p><?php _e('If you have recently changed your layout or edited the thumbnail sizes, you will need to regenerate the thumbnails.', 'arras') ?></p>
<p><?php _e( 'Use this tool to regenerate thumbnails for all images that you have uploaded to your blog.', 'arras' ); ?></p>
<p class="submit"><a class="button-secondary" href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=arras-regen-thumbs"><?php _e('Regenerate Thumbnails', 'arras') ?></a></p>


<h3><?php _e('Clear timThumb Thumbnail Cache (Legacy)', 'arras') ?></h3>
<p><?php printf( __('The thumbnail cache folder is located at: %s.', 'arras'), '<code>' . ARRAS_LIB . '/cache/' . '</code>') ?><br />
<?php _e('If this does not work, you can manually delete all the files in that folder.', 'arras') ?></p>
<p><strong><?php _e('Ensure that you have submitted any changes made before proceeding.', 'arras') ?></strong></p>
<p class="submit">
<input class="button-secondary" type="submit" name="clearcache" value="<?php _e('Clear Thumbnail Cache', 'arras') ?>" />
</p>

</div><!-- #tools -->
