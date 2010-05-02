<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="layout" class="padding-content">

<h3><?php _e('Display Types - Node Based', 'arras') ?></h3>

<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-limit-words"><?php _e('Limit Excerpts', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-limit-words', 'id' => 'arras-layout-limit-words', 'size' => '5', 'value' => arras_get_option('node_based_limit_words'), 'maxlength' => 3 )) ?>
 <?php ' ' . _e('words', 'arras') ?>
</td>
</tr>
</table>

<h3><?php _e('Archive / Search', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-archive-newsdisplay"><?php _e('Posts Display Type', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-layout-archive-newsdisplay', arras_get_tapestries_select(), arras_get_option('archive_display') ); ?>
</td>
</tr>

</table>

<h3><?php _e('Single Post', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Display in Single Posts', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-layout-post-author', 'show', arras_get_option('post_author'), 'id="arras-layout-post-author"') ?> 
<label for="arras-layout-post-author"><?php _e('Author (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-date', 'show', arras_get_option('post_date'), 'id="arras-layout-post-date"') ?> 
<label for="arras-layout-post-date"><?php _e('Publish Date (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-cats', 'show', arras_get_option('post_cats'), 'id="arras-layout-post-cats"') ?> 
<label for="arras-layout-post-cats"><?php _e('Categories (Header)', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-post-tags', 'show', arras_get_option('post_tags'), 'id="arras-layout-post-tags"') ?> 
<label for="arras-layout-post-tags"><?php _e('Tags', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-single-thumbs', 'show', arras_get_option('single_thumbs'), 'id="arras-layout-single-thumbs"') ?> 
<label for="arras-layout-single-thumbs"><?php _e('Post Thumbnail', 'arras') ?></label>
<br />

<?php echo arras_form_checkbox('arras-layout-single-author', 'show', arras_get_option('display_author'), 'id="arras-layout-single-author"') ?> 
<label for="arras-layout-single-author"><?php _e('Author Information', 'arras') ?></label>

</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-metapos"><?php _e('Position of Custom Fields', 'arras') ?></label></th>
<td>
<?php echo arras_form_radio('arras-layout-metapos', 'top', arras_get_option('single_meta_pos') == 'top') ?> <?php _e('Before the Post Content', 'arras') ?><br />
<?php echo arras_form_radio('arras-layout-metapos', 'bottom', arras_get_option('single_meta_pos') == 'bottom') ?> <?php _e('After the Post Content', 'arras') ?><br />
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-single-custom-fields">Single Post Custom Fields</label></th>
<td>
<?php echo arras_form_textarea(array('name' => 'arras-single-custom-fields', 'id' => 'arras-single-custom-fields', 'class' => 'code', 'rows' => '3', 'cols' => '70', 'value' => stripslashes(arras_get_option('single_custom_fields')) )) ?><br />
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
<input type="hidden" name="action" value="save" />
</p>

</div><!-- #layout -->
