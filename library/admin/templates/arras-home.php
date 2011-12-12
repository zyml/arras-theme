<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="home" class="padding-content">

<h3><?php _e('Post Options', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e("Hide duplicate posts", 'arras') ?></th>
<td>

<?php echo arras_form_checkbox('arras-hide-duplicates', 'show', arras_get_option('hide_duplicates'), 'id="arras-hide-duplicates"') ?> 
<label for="arras-hide-duplicates"><?php _e('Check this to prevent duplicate posts from displaying within the slideshow and the featured posts.', 'arras') ?></label>
<p><?php _e('This might increase your server load, depending on the number of posts displayed.', 'arras') ?></p>
</td>
</tr>
</table>

<h3><?php _e('Slideshow', 'arras') ?> <span class="enabler"><?php echo arras_form_checkbox('arras-enable-slideshow', 'show', arras_get_option('enable_slideshow'), 'id="arras-enable-slideshow"') ?><label for="arras-enable-slideshow"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Selected Post Type', 'arras') ?></th>
<td>
<strong><?php echo arras_get_posttype_name(arras_get_option('slideshow_posttype')) ?></strong>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-slideshow"><?php printf( __('Stickied Posts / %s', 'arras'), arras_get_taxonomy_name(arras_get_option('slideshow_tax')) ) ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-slideshow[]', arras_get_terms_list(arras_get_option('slideshow_tax')), arras_get_option('slideshow_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown on the featured slideshow of the index page.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-slideshow-count"><?php _e('Show Posts', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-slideshow-count', 'id' => 'arras-layout-slideshow-count', 'size' => '5', 'value' => arras_get_option('slideshow_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

</table>

<h3><?php _e('Featured Posts #1', 'arras') ?>  <span class="enabler"><?php echo arras_form_checkbox('arras-enable-featured1', 'show', arras_get_option('enable_featured1'), 'id="arras-enable-featured1"') ?><label for="arras-enable-featured1"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Selected Post Type', 'arras') ?></th>
<td>
<strong><?php echo arras_get_posttype_name(arras_get_option('featured1_posttype')) ?></strong>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured1-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured1-title', 'id' => 'arras-layout-featured1-title', 'style' => 'width:60%', 'value' => arras_get_option('featured1_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-featured1"><?php printf( __('Stickied Posts / %s', 'arras'), arras_get_taxonomy_name(arras_get_option('featured1_tax')) ) ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured1[]', arras_get_terms_list(arras_get_option('featured1_tax')), arras_get_option('featured1_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown below the featured slideshow of the index page.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured1-display"><?php _e('Tapestry (Display Type)', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-layout-featured1-display', arras_get_tapestries_select(), arras_get_option('featured1_display')); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured1-count"><?php _e('Post Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured1-count', 'id' => 'arras-layout-featured1-count', 'size' => '5', 'value' => arras_get_option('featured1_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

</table>


<h3><?php _e('Featured Posts #2', 'arras') ?>  <span class="enabler"><?php echo arras_form_checkbox('arras-enable-featured2', 'show', arras_get_option('enable_featured2'), 'id="arras-enable-featured2"') ?><label for="arras-enable-featured2"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Selected Post Type', 'arras') ?></th>
<td>
<strong><?php echo arras_get_posttype_name(arras_get_option('featured2_posttype')) ?></strong>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured2-title', 'id' => 'arras-layout-featured2-title', 'style' => 'width:60%', 'value' => arras_get_option('featured2_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-featured2"><?php printf( __('Stickied Posts / %s', 'arras'), arras_get_taxonomy_name(arras_get_option('featured2_tax')) ) ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured2[]', arras_get_terms_list(arras_get_option('featured2_tax')), arras_get_option('featured2_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown below the featured slideshow of the index page.', 'arras') ?>

</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-display"><?php _e('Tapestry (Display Type)', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-layout-featured2-display', arras_get_tapestries_select(), arras_get_option('featured2_display')); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-featured2-count"><?php _e('Post Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-featured2-count', 'id' => 'arras-layout-featured2-count', 'size' => '5', 'value' => arras_get_option('featured2_count'), 'maxlength' => 2 )) ?>
 <?php ' ' . _e('posts', 'arras') ?>
</td>
</tr>

</table>


<h3><?php _e('News Posts', 'arras') ?> <span class="enabler"><?php echo arras_form_checkbox('arras-enable-news', 'show', arras_get_option('enable_news'), 'id="arras-enable-news"') ?><label for="arras-enable-news"><?php _e('Show/Hide', 'arras') ?></label></span></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Selected Post Type', 'arras') ?></th>
<td>
<strong><?php echo arras_get_posttype_name(arras_get_option('news_posttype')) ?></strong>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-news-title"><?php _e('Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-news-title', 'id' => 'arras-layout-news-title', 'style' => 'width:60%', 'value' => arras_get_option('news_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-news"><?php printf( __('Stickied Posts / %s', 'arras'), arras_get_taxonomy_name(arras_get_option('news_tax')) ) ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-news[]', arras_get_terms_list(arras_get_option('news_tax')), arras_get_option('news_cat'), 'class="multiple" multiple="multiple"' ); ?>
<br /><?php _e('Selected categories will be shown below the featured section in the index page.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-index-newsdisplay"><?php _e('Tapestry (Display Type)', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-layout-index-newsdisplay', arras_get_tapestries_select(), arras_get_option('news_display')); ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-index-count"><?php _e('News Count', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-layout-index-count', 'id' => 'arras-layout-index-count', 'size' => '5', 'value' => arras_get_option('index_count'), 'maxlength' => 2 )) ?>
 <?php _e('posts', 'arras') ?>
</td>
</tr>

</table>

<?php do_action('arras_admin_settings-home'); ?>

</div><!-- #layout -->
