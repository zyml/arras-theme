<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="home" class="padding-content">

<h3><?php _e('Featured Slideshow', 'arras') ?> <span class="enabler"><?php echo arras_form_checkbox('arras-enable-slideshow', 'show', arras_get_option('enable_slideshow'), 'id="arras-enable-slideshow"') ?><label for="arras-enable-slideshow"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-cat-featured1"><?php _e('Stickied Posts / Categories', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured1[]', array( 
	'-5' => __('Stickied Posts', 'arras'), 
	__('Categories', 'arras'
) => $cats), arras_get_option('slideshow_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown on the featured slideshow of the index page.', 'arras') ?>
<br /><?php _e('If nothing is selected, this section will show <strong>all</strong> posts.', 'arras') ?>
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

<h3><?php _e('Featured Posts', 'arras') ?>  <span class="enabler"><?php echo arras_form_checkbox('arras-enable-featured', 'show', arras_get_option('enable_featured'), 'id="arras-enable-featured"') ?><label for="arras-enable-featured"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-featured-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured-title', 'id' => 'arras-layout-featured-title', 'style' => 'width:60%', 'value' => arras_get_option('featured_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-featured2"><?php _e('Stickied Posts / Categories', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured2[]', array(
	'-5' => __('Stickied Posts', 'arras'), 
	__('Categories', 'arras'
) => $cats), arras_get_option('featured_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown below the featured slideshow of the index page.', 'arras') ?>
<br /><?php _e('If nothing is selected, this section will show <strong>all</strong> posts.', 'arras') ?>
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
<th scope="row"><label for="arras-layout-featured-offset"><?php _e('Post Offset', 'arras') ?></label></th>
<td>
<?php echo arras_form_checkbox('arras-layout-featured-offset', 'show', arras_get_option('featured_offset'), 'id="arras-layout-featured-offset"') ?> 
<?php _e('Posts will offset from the slideshow if they have the same category.', 'arras') ?></label>
</td>
</tr>

</table>


<h3><?php _e('News Posts', 'arras') ?> <span class="enabler"><?php echo arras_form_checkbox('arras-enable-news', 'show', arras_get_option('enable_news'), 'id="arras-enable-news"') ?><label for="arras-enable-news"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-news-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-news-title', 'id' => 'arras-layout-news-title', 'style' => 'width:60%', 'value' => arras_get_option('news_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-news"><?php _e('Stickied Posts / Categories', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-news', $cats, arras_get_option('news_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown below the featured section in the index page.', 'arras') ?>
<br /><?php _e('If nothing is selected, this section will show <strong>all</strong> posts.', 'arras') ?>
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
 <?php _e('posts', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-news-offset"><?php _e('Post Offset', 'arras') ?></label></th>
<td>
<?php echo arras_form_checkbox('arras-layout-news-offset', 'show', arras_get_option('news_offset'), 'id="arras-layout-news-offset"') ?> 
<?php _e('Posts will offset from the slideshow and/or featured posts if they have the same category.', 'arras') ?></label>
</td>
</tr>

</table>

</div><!-- #layout -->
