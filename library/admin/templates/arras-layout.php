<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="layout" class="padding-content">

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

<h3><?php _e('Featured Posts #1', 'arras') ?></h3>
<table class="form-table">

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
<?php echo arras_form_dropdown(
	'arras-layout-featured2-display',
	array( 'default' => __('Node Based', 'arras'), 'quick' => __('Quick Preview', 'arras'), 'line' => __('Per Line', 'arras'), 'traditional' => __('Traditional', 'arras') ),
	arras_get_option('featured_display')
); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-count"><?php _e('Post Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured2-count', 'id' => 'arras-layout-featured2-count', 'size' => '5', 'value' => arras_get_option('featured_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

<tr valign="top">
<td></td>
<td>
<?php echo arras_form_checkbox('arras-layout-featured2-meta', 'show', arras_get_option('featured_display_meta_inpic'), 'id="arras-layout-featured2-meta"') ?> 
<label for="arras-layout-featured2-meta"><?php _e('Display date and comments count in post thumbnails', 'arras') ?></label>
</td>
</tr>

</table>


<h3><?php _e('Index Page - News Posts', 'arras') ?></h3>
<table class="form-table">

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
<?php echo arras_form_dropdown(
	'arras-layout-index-newsdisplay',
	array( 'default' => __('Node Based', 'arras'), 'quick' => __('Quick Preview', 'arras'), 'line' => __('Per Line', 'arras'), 'traditional' => __('Traditional', 'arras') ),
	arras_get_option('news_display')
); ?>
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

<tr valign="top">
<td></td>
<td>
<?php echo arras_form_checkbox('arras-layout-news-meta', 'show', arras_get_option('news_display_meta_inpic'), 'id="arras-layout-news-meta"') ?> 
<label for="arras-layout-news-meta"><?php _e('Display date and comments count in post thumbnails', 'arras') ?></label>
</td>
</tr>

</table>

<h3><?php _e('Archive / Search', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-archive-newsdisplay"><?php _e('Posts Display Type', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown(
	'arras-layout-archive-newsdisplay',
	array( 'default' => __('Node Based', 'arras'), 'quick' => __('Quick Preview', 'arras'), 'line' => __('Per Line', 'arras'), 'traditional' => __('Traditional', 'arras') ),
	arras_get_option('archive_display')
); ?>
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
<label for="arras-layout-post-tags"><?php _e('Tags (Header)', 'arras') ?></label>
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
