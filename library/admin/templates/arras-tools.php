<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="tools" class="padding-content">

<h3><?php _e('Clear timThumb Thumbnail Cache (Legacy)', 'arras') ?></h3>
<p><?php printf( __('The thumbnail cache folder is located at: %s.', 'arras'), '<code>' . ARRAS_LIB . '/cache/' . '</code>') ?><br />
<?php _e('If this does not work, you can manually delete all the files in that folder.', 'arras') ?></p>
<p><strong><?php _e('Ensure that you have submitted any changes made before proceeding.', 'arras') ?></strong></p>
<p class="submit">
<input class="button-secondary" type="submit" name="clearcache" value="<?php _e('Clear Thumbnail Cache', 'arras') ?>" />
</p>

</div><!-- #tools -->
