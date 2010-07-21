<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php global $arras_registered_alt_layouts, $arras_registered_style_dirs; ?>

<?php
$styles = array();
foreach ($arras_registered_style_dirs as $style_dir) {
	$style_dir = dir($style_dir);
	if ($style_dir) {
		while(($file = $style_dir->read()) !== false) {
			if(is_valid_arras_style($file)) $styles[substr($file, 0, -4)] = $file;
		}
	}
}
?>

<div id="design" class="padding-content">

<h3><?php _e('Overall Design', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-layout-col"><?php _e('Overall Layout', 'arras') ?></label></th>
<td>
<?php if ( !defined('ARRAS_INHERIT_LAYOUT') || ARRAS_INHERIT_LAYOUT == true ) {
echo arras_form_dropdown('arras-layout-col', $arras_registered_alt_layouts, arras_get_option('layout')) ?><br />
<?php 
	echo arras_form_checkbox('arras-reset-thumbs', 'show', false, 'id="arras-reset-thumbs"') . ' '; 
	_e('Reset thumbnail sizes accordingly based on selected layout.', 'arras');
?>
<?php
} else {
	echo '<span class="grey">' . __('The developer of the child theme has disabled layout settings.', 'arras') . '</span>';
}
?>

</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-style"><?php _e('Default Style', 'arras') ?></label></th>
<td>
<?php if ( !defined('ARRAS_INHERIT_STYLES') || ARRAS_INHERIT_STYLES == true ) {
echo arras_form_dropdown('arras-style', $styles, arras_get_option('style') ) ?><br />
<?php printf( __('Alternate stylesheets can be placed in %s.', 'arras'), '<code>wp-content/themes/' .get_stylesheet(). '/css/styles/</code>' );
} else {
	echo '<span class="grey">' . __('The developer of the child theme has disabled alternate stylesheets.', 'arras') . '</span>';
}
?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-logo"><?php _e('Custom Logo', 'arras') ?></label></th>
<td>
<?php if ( arras_get_option('logo') != 0 ) {
	echo wp_get_attachment_image(arras_get_option('logo'), 'full') . '<br />';
	echo arras_form_checkbox('arras-delete-logo', 'show', false, 'id="arras-delete-logo"');
?> 
	<label for="arras-delete-logo"><?php _e('Delete existing', 'arras') ?></label>
<?php } ?>
<p id="arras-logo-field"><input type="file" id="arras-logo" name="arras-logo" size="35" /></p>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-style"><?php _e('Custom Background', 'arras') ?></label></th>
<td>
<a href="<?php bloginfo('url') ?>/wp-admin/admin.php?page=arras-custom-background"><strong><?php _e('Set Custom Background', 'arras') ?></strong></a>
</td>
</tr>

</table>

<?php do_action('arras_admin_settings-design'); ?>

</div><!-- #design -->
