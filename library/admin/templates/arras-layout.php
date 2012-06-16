<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="layout" class="padding-content">

<h3><?php _e('Excerpts', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-limit-words"><?php _e('Excerpt Limit', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-limit-words', 'id' => 'arras-layout-limit-words', 'size' => '5', 'value' => arras_get_option('excerpt_limit'), 'maxlength' => 3 )) ?>
 <?php ' ' . _e('words', 'arras') ?>
 <br /><?php _e('Excerpts will only be trimmed to the limit if no excerpt is specified for the respective post.', 'arras') ?>
</td>
</tr>
</table>

<h3><?php _e('Archive / Search', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-archive-newsdisplay"><?php _e('Tapestry (Display Type)', 'arras') ?></label></th>
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
<th scope="row"><?php _e('Display Relative Post Dates', 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-layout-single-postdates', 'show', arras_get_option('relative_postdates'), 'id="arras-layout-single-postdates"') ?> 
<label for="arras-layout-single-author"><?php _e('Check this to display post dates relative to current time (eg. 2 days ago ).', 'arras') ?></label>

</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-single-custom-taxonomies"><?php _e('Display Custom Taxonomies', 'arras') ?></label></th>
<td>
<?php echo arras_form_textarea(array('name' => 'arras-single-custom-taxonomies', 'id' => 'arras-single-custom-taxonomies', 'class' => 'code', 'rows' => '3', 'cols' => '70', 'value' => esc_textarea(arras_get_option('single_custom_taxonomies')) )) ?><br />
<?php _e("List down the custom taxonomies' slug that you wish to display here, separated by a comma (,).", 'arras') ?>
</td>
</tr>

<?php if ( defined('ARRAS_CUSTOM_FIELDS') && ARRAS_CUSTOM_FIELDS == true ) : ?>
<tr valign="top">
<th scope="row"><label for="arras-single-custom-fields"><?php _e('Single Post Custom Fields', 'arras') ?></label></th>
<td>
<?php echo arras_form_textarea(array('name' => 'arras-single-custom-fields', 'id' => 'arras-single-custom-fields', 'class' => 'code', 'rows' => '3', 'cols' => '70', 'value' => esc_textarea(arras_get_option('single_custom_fields')) )) ?><br />
</td>
</tr>
<?php endif ?>

</table>

<?php do_action('arras_admin_settings-layout'); ?>

</div><!-- #layout -->
