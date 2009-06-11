<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php global $arras_registered_alt_layouts; ?>

<?php
$style_dir = dir(TEMPLATEPATH . '/css/styles/');
if ($style_dir) {
	while(($file = $style_dir->read()) !== false) {
		if(is_valid_arras_style($file)) $styles[substr($file, 0, -4)] = $file;
	}
}
?>

<div id="design" class="padding-content">

<h3><?php _e('Overall Design', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-col"><?php _e('Overall Layout', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-layout-col', $arras_registered_alt_layouts, arras_get_option('layout')) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-style"><?php _e('Default Style', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-style', $styles, arras_get_option('style') ) ?><br />
<?php printf( __('Alternate stylesheets are placed in %s.', 'arras'), '<code>wp-content/themes/' .get_stylesheet(). '/css/styles/</code>' ) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-background"><?php _e('Site Background', 'arras') ?></label></th>
<td>
<?php $bg_images = arras_get_files_list( '/images/bg/'.arras_get_option('style'), false ) ?>
<div id="arras-background-container">

<p><?php _e('Style Backgrounds', 'arras') ?></p>

<?php foreach ( $bg_images as $bg ) : ?>
<div class="arras-background-node <?php if ( arras_get_option('background') == urlencode(arras_get_option('style').'/'.$bg) ) : ?>background-selected<?php endif ?>">
<a href="#<?php echo urlencode(arras_get_option('style').'/'.$bg) ?>" title="<?php echo $bg ?>">
<img src="<?php bloginfo('template_url') ?>/library/timthumb.php?src=<?php bloginfo('template_url') ?>/images/bg/<?php echo arras_get_option('style') .'/'. $bg ?>&amp;w=196&amp;h=120&amp;zc=1" 
	alt="<?php echo $bg ?>" />
</a>
</div>
<?php endforeach ?>

<p><?php _e('Custom Backgrounds', 'arras') ?></p>

<div class="arras-background-node arras-background-custom <?php if ( arras_get_option('background') == 'none' ) : ?>background-selected<?php endif ?>">
<a href="#none" title="<?php _e('None', 'arras') ?>" style="border: 2px dotted #ccc; height: 116px"></a>
</div>

<?php $bg_images = arras_get_files_list( '/images/bg/', false ) ?>
<?php foreach ( $bg_images as $bg ) : ?>
<div class="arras-background-node arras-background-custom <?php if ( arras_get_option('background') == $bg ) : ?>background-selected<?php endif ?>">
<a href="#<?php echo urlencode($bg) ?>" title="<?php echo $bg ?>">
<img src="<?php bloginfo('template_url') ?>/library/timthumb.php?src=<?php bloginfo('template_url') ?>/images/bg/<?php echo $bg ?>&amp;w=196&amp;h=120&amp;zc=1" 
	alt="<?php echo $bg ?>" />
</a>
</div>
<?php endforeach ?>

</div>

<?php printf( __('Custom backgrounds are placed in %s.', 'arras'), '<code>wp-content/themes/' .get_stylesheet(). '/images/bg/</code>' ) ?>

<input type="hidden" name="arras-background-type" id="arras-background-type" value="<?php echo arras_get_option('background_type') ?>" />
<input type="hidden" name="arras-background" id="arras-background" value="<?php echo arras_get_option('background') ?>" />

</td>
</tr>

<tr class="background-extras" valign="top" <?php if (arras_get_option('background_type') == 'original') echo 'style="display: none"' ?>>
<th scope="row"><label for="arras-background-tiling"><?php _e('Background Tiling', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-background-tiling', 
	array('no-repeat' => __('Do not Tile', 'arras'), 'repeat-x' => __('Tile Horizontally', 'arras'), 'repeat-y' => __('Tile Vertically', 'arras'), 'repeat' => __('Tile Both Horizontally and Vertically', 'arras') ),
	arras_get_option('background_tiling')
); ?>
</td>
</tr>

<tr class="background-extras" valign="top" <?php if (arras_get_option('background_type') == 'original') echo 'style="display: none"' ?>>
<th scope="row"><label for="arras-background-color"><?php _e('Background Color', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-background-color', 'id' => 'arras-background-color', 'class' => 'code', 'size' => '8', 'value' => arras_get_option('background_color') )) ?>
<div id="colorpicker"></div>
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
</p>

</div><!-- #design -->
