<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="home" class="padding-content">

<h3><?php _e('Featured Slideshow', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-cat-featured1"><?php _e('Show Category', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured1', array(
	'-1' => __('Don\'t Show Featured Slideshow', 'arras'), 
	'-5' => __('Stickied Posts', 'arras'), 
	__('Available Categories', 'arras'
) => $cats), arras_get_option('slideshow_cat') ); ?>
<br /><?php _e('Articles from this category will be shown on the featured slideshow of the index page. <br />You can also specify your stickied posts as the featured \'category\'.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured1-count"><?php _e('Show Posts', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured1-count', 'id' => 'arras-layout-featured1-count', 'size' => '5', 'value' => arras_get_option('slideshow_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

</table>

<h3><?php _e('Featured Posts', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-featured-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured-title', 'id' => 'arras-layout-featured-title', 'style' => 'width:60%', 'value' => arras_get_option('featured_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-featured2"><?php _e('Show Category', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured2', array(
	'-1' => __('Don\'t Show Featured Posts #2', 'arras'), 
	'-5' => __('Stickied Posts', 'arras'), 
	__('Available Categories', 'arras'
) => $cats), arras_get_option('featured_cat') ); ?>
<br /><?php _e('Articles from this category will be shown below the featured slideshow of the index page. <br />You can also specify your stickied posts as the featured \'category\'.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-display"><?php _e('Display Type', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-layout-featured2-display', arras_get_tapestries_select(), arras_get_option('featured_display') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-count"><?php _e('Post Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured2-count', 'id' => 'arras-layout-featured2-count', 'size' => '5', 'value' => arras_get_option('featured_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

</table>


<h3><?php _e('News Posts', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-news-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-news-title', 'id' => 'arras-layout-news-title', 'style' => 'width:60%', 'value' => arras_get_option('news_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-news"><?php _e('News Category', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-news', $cats, arras_get_option('news_cat') ); ?>
<br /><?php _e('The news category will be shown below the featured section in the index page.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-index-newsdisplay"><?php _e('News Display Type', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-layout-index-newsdisplay', arras_get_tapestries_select(), arras_get_option('news_display') ); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-index-count"><?php _e('News Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-index-count', 'id' => 'arras-layout-index-count', 'size' => '5', 'value' => arras_get_option('index_count'), 'maxlength' => 2 )) ?>
 <?php _e('posts', 'arras') ?><br />
<?php printf(__('By default, the theme retrieves %s posts, based on your WordPress settings.', 'arras'), '<strong>' . get_option('posts_per_page') . '</strong>') ?>
 <?php _e('You can override the setting here.', 'arras') ?>
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
<input type="hidden" name="action" value="save" />
</p>

</div><!-- #layout -->
