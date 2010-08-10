<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<?php
$posttypes = get_post_types(null, 'objects');
$posttypes_opt = array();

foreach( $posttypes as $id => $obj ) {
	if (!in_array( $id, arras_posttype_blacklist() )) {
		$posttypes_opt[$id] = $obj->labels->name;
	}
}

?>

<div class="wrap clearfix">

<?php screen_icon('themes') ?>
<h2 id="arras-header"><?php _e('Post Types & Taxonomies Options', 'arras') ?></h2>

<?php echo $notices ?>

<form enctype="multipart/form-data" id="arras-posttax-form" class="ui-widget-content" method="post" action="admin.php?page=arras-posttax">
<?php wp_nonce_field('arras-posttax'); ?>

<ul class="clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" id="arras-tabs">
	<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="admin.php?page=arras-posttax"><?php _e('Post Types', 'arras') ?></a></li>
	<li class="ui-state-default ui-corner-top"><a href="admin.php?page=arras-posttax&type=taxonomy"><?php _e('Taxonomies', 'arras') ?></a></li>
</ul>

<div class="clearfix arras-options-wrapper">

<div class="padding-content">
<h3><?php _e('Home', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-posttype-slideshow"><?php _e('Slideshow', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-slideshow', $posttypes_opt, arras_get_option('slideshow_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-featured1"><?php _e('Featured Post #1', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-featured1', $posttypes_opt, arras_get_option('featured1_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-featured2"><?php _e('Featured Post #2', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-featured2', $posttypes_opt, arras_get_option('featured2_posttype') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-posttype-news"><?php _e('News Posts', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-posttype-news', $posttypes_opt, arras_get_option('news_posttype') ); ?>
</td>
</tr>

</table>

<?php do_action('arras_admin_posttype'); ?>

</div>


<p class="final-submit">
<input type="hidden" name="type" value="posttype" />
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
<input class="button-secondary" type="submit" name="reset" value="<?php _e('Reset Settings', 'arras') ?>" />
</p>

</div>

</form>

<?php arras_right_col() ?>

</div><!-- .wrap -->

<?php

/* End of file posttax_page.php */
/* Location: ./library/admin/templates/posttax_page.php */
