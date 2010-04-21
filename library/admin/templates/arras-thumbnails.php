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

<h3><?php _e('Clear timThumb Thumbnail Cache (Legacy)', 'arras') ?></h3>
<p><?php _e('If you have recently changed your layout, or edited the thumbnail sizes, it is highly recommended that you clear your thumbnail cache.', 'arras') ?></p>
<p><?php printf( __('The thumbnail cache folder is located at: %s.', 'arras'), '<code>' . ARRAS_LIB . '/cache/' . '</code>') ?><br />
<?php _e('If this does not work, you can manually delete all the files in that folder.', 'arras') ?></p>
<p><strong><?php _e('Ensure that you have submitted any changes made before proceeding.', 'arras') ?></strong></p>
<p class="submit">
<input class="button-secondary" type="submit" name="clearcache" value="<?php _e('Clear Thumbnail Cache', 'arras') ?>" />
</p>

<h3><?php _e('Frequently Asked Questions (EN only)', 'arras') ?></h3>

<p><strong>Q:</strong> How do I add thumbnails to my posts?</p>
<p><strong>A:</strong> Starting from 1.4, the recommended method to set your thumbnails is to go to the edit page of the post you wish to add thumbnails on, find the box named <em>Post Thumbnail</em> (probably located at the bottom right) and click on <em>Set Thumbnail</em>. Upload and select your thumbnail in the pop-up box, and you are done!</p>
<hr />

<p><strong>Q:</strong> How big should I upload my images to make the thumbnails fit in the theme?</p>
<p><strong>A:</strong> Your image should be at least <strong>960x300</strong> for 1 column layout, <strong>640x250</strong> for 2 column layout, and <strong>500x225</strong> for 3 column layout.</p>
<hr />

<p><strong>Q:</strong> The thumbnail sizes in my blog are too large. How do I fix that?</p>
<p><strong>A:</strong> When WordPress does not have a thumbnail at a size that is needed (usually caused when the thumbnail size setting is changed), it displays the full image instead. What you can to is to download the <em>Rengerate Thumbnails</em> plugin and let it generate the thumbnail of that size for you.</p>
<hr />

<p><strong>Q:</strong> I do not like the way WordPress crops the image for me. Is there any way you can adjust it?</p>
<p><strong>A:</strong> You can go to the <em>Media Library</em> and edit the image that is used as the thumbnail. Crop the image and apply the changes to your thumbnails. It's not accurate and you can only apply to all thumbnail sizes (unless someone writes a plugin for it).</p>
<hr />

</div><!-- #thumbnails -->
