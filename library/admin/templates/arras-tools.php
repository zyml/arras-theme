<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="tools" class="padding-content">

<h3><?php _e('Import Theme Settings (BETA)', 'arras') ?></h3>
<p><?php _e('Import your theme settings by pasting the exported code below.', 'arras') ?></p>
<?php echo arras_form_textarea('arras-tools-import', null, 'style="width: 90%; height: 100px;" class="code"'); ?>
</p>

<h3><?php _e('Export Theme Settings (BETA)', 'arras') ?></h3>
<p><?php _e('You can save the following code into a text file and use it when you need to import them into another installation. Note that not all options (custom background, child theme settings, etc.) will be exported.', 'arras') ?></p>
<?php echo arras_form_textarea('arras-tools-export', json_encode( maybe_serialize($arras_options) ), 'style="width: 90%; height: 100px;" class="code"'); ?>
</p>

<?php do_action('arras_admin_settings-tools'); ?>

</div><!-- #tools -->
