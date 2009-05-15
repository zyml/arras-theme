<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$cats = array('0' => __('All Categories', 'arras') );
foreach( get_categories('hide_empty=0') as $c ) {
	$cats[(string)$c->cat_ID] = $c->cat_name;
}
?>

<div id="categories" class="padding-content">

<h3><?php _e('Categories', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-cat-featured1"><?php _e('Featured Category #1', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured1', array(
	'-1' => __('Don\'t Show Featured Posts #1', 'arras'), 
	'-5' => __('Stickied Posts', 'arras'), 
	__('Available Categories', 'arras'
) => $cats), arras_get_option('featured_cat1') ); ?>
<br /><?php _e('Articles from this category will be shown on the featured slideshow of the index page. <br />You can also specify your stickied posts as the featured \'category\'.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-featured2"><?php _e('Featured Category #2', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-featured2', array(
	'-1' => __('Don\'t Show Featured Posts #2', 'arras'), 
	'-5' => __('Stickied Posts', 'arras'), 
	__('Available Categories', 'arras'
) => $cats), arras_get_option('featured_cat2') ); ?>
<br /><?php _e('Articles from this category will be shown below the featured slideshow of the index page. <br />You can also specify your stickied posts as the featured \'category\'.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-cat-news"><?php _e('News Category', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-cat-news', $cats, arras_get_option('news_cat') ); ?>
<br /><?php _e('The news category will be shown below the featured section in the index page.', 'arras') ?>
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
</p>

</div><!-- #categories -->
