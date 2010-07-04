<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="thumbnails" class="padding-content">

<h3><?php _e('Thumbnail Options', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Auto Thumbnails', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-thumbs-auto', 'show', arras_get_option('auto_thumbs'), 'id="arras-thumbs-auto"') ?> 
<label for="arras-thumbs-auto"><?php _e('Check this to allow the theme to automatically retrieve the first attached image from the post as featured image when no image is specified.', 'arras') ?></label>

</td>
</tr>
</table>

<h3><?php _e('Thumbnail Sizes', 'arras') ?></h3>

<p style="color: red"><?php _e('If you have recently changed your layout or edited the thumbnail sizes, you will need to regenerate your thumbnails.', 'arras'); ?></p>

<table class="thumbnail-sizes-table form-table">
<?php foreach ($arras_image_sizes as $image_size_id => $image_size_args) : ?>
<tr valign="top">
<th scope="row"><label><?php echo $image_size_args['name'] ?></label></th>
<td>
<label for="arras-<?php echo $image_size_id ?>-w"><?php _e('Width', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-' . $image_size_id . '-w', 'id' => 'arras-' . $image_size_id . '-w', 'size' => '5', 'value' => $image_size_args['w'], 'maxlength' => 3 )) ?><span class="default-w hide"><?php echo $image_size_args['dw'] ?></span>

<label for="arras-<?php echo $image_size_id ?>-h"><?php _e('Height', 'arras') ?></label>
<?php echo arras_form_input(array('name' => 'arras-' . $image_size_id . '-h', 'id' => 'arras-' . $image_size_id . '-h', 'size' => '5', 'value' => $image_size_args['h'], 'maxlength' => 3 )) ?><span class="default-h hide"><?php echo $image_size_args['dh'] ?></span>
</td>
<td class="arras-thumbnail-size-reset">
<a class="button-secondary"><?php _e('Reset to Defaults', 'arras') ?></a>
</td>
</tr>
<?php endforeach ?>
</table>

<script type="text/javascript">
	var j = jQuery.noConflict();
	j(document).ready(function() {
		j('.arras-thumbnail-size-reset .button-secondary').click( function() {
			j(this).parent().parent().children('td').find('input').eq(0).val( j(this).parent().parent().children('td').find('.default-w').html() );
			j(this).parent().parent().children('td').find('input').eq(1).val( j(this).parent().parent().children('td').find('.default-h').html() );
			checkRegenThumbsField();
		} );
		
		j('.thumbnail-sizes-table input').change( function() {
			checkRegenThumbsField();
		} );
	});
</script>

<?php do_action('arras_admin_settings-thumbnails'); ?>

<h3><?php _e('Frequently Asked Questions (EN only)', 'arras') ?></h3>

<p><strong>Q:</strong> How do I add thumbnails to my posts?</p>
<p><strong>A:</strong> Starting from 1.4, the recommended method to set your thumbnails is to go to the edit page of the post you wish to add thumbnails on, find the box named <em>Post Thumbnail</em> (probably located at the bottom right) and click on <em>Set Thumbnail</em>. Upload and select your thumbnail in the pop-up box, and you are done!</p>
<hr />

<p><strong>Q:</strong> The thumbnail sizes in my blog are too large. How do I fix that?</p>
<p><strong>A:</strong> When WordPress does not have a thumbnail at a size that is needed (usually caused when the thumbnail size setting is changed), it displays the full image instead. You can regenerate your thumbnails by checking on the option below.</p>
<hr />

</div><!-- #thumbnails -->
