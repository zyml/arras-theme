<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="thumbnails" class="padding-content">

<h3><?php _e('Thumbnail Sizes', 'arras') ?></h3>

<p style="color: red"><?php _e('If you have recently changed your layout or edited the thumbnail sizes, you will need to regenerate the thumbnails using the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin.', 'arras') ?></p>

<table class="form-table">

<tr valign="top">
<th scope="row"><label><?php _e('Featured Thumbnail Size', 'arras') ?></label></th>
<td>
<label for="arras-featured-thumb-w"><?php _e('Width', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-featured-thumb-w', 'id' => 'arras-featured-thumb-w', 'size' => '5', 'value' => arras_get_option('featured_thumb_w'), 'maxlength' => 3 )) ?>

<label for="arras-featured-thumb-h"><?php _e('Height', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-featured-thumb-h', 'id' => 'arras-featured-thumb-h', 'size' => '5', 'value' => arras_get_option('featured_thumb_h'), 'maxlength' => 3 )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label><?php _e('News Thumbnail Size', 'arras') ?></label></th>
<td>
<label for="arras-news-thumb-w"><?php _e('Width', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-news-thumb-w', 'id' => 'arras-news-thumb-w', 'size' => '5', 'value' => arras_get_option('news_thumb_w'), 'maxlength' => 3 )) ?>

<label for="arras-news-thumb-h"><?php _e('Height', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-news-thumb-h', 'id' => 'arras-news-thumb-h', 'size' => '5', 'value' => arras_get_option('news_thumb_h'), 'maxlength' => 3 )) ?>
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
</p>

<h3><?php _e('Clear timThumb Thumbnail Cache (Leagcy)', 'arras') ?></h3>
<p><?php _e('If you have recently changed your layout, or edited the thumbnail sizes, it is highly recommended that you clear your thumbnail cache.', 'arras') ?></p>
<p><?php printf( __('The thumbnail cache folder is located at: %s.', 'arras'), '<code>' . ARRAS_LIB . '/cache/' . '</code>') ?><br />
<?php _e('If this does not work, you can manually delete all the files in that folder.', 'arras') ?></p>
<p><strong><?php _e('Ensure that you have submitted any changes made before proceeding.', 'arras') ?></strong></p>
<p class="submit">
<input class="button-secondary" type="submit" name="clearcache" value="<?php _e('Clear Thumbnail Cache', 'arras') ?>" />
</p>

</div><!-- #thumbnails -->
