<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="general-settings" class="padding-content">

<h3><?php _e('Theme Updates', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Current Version', 'arras') ?></th>
<td class="version"><?php echo ARRAS_VERSION ?></td>
</tr>

</table>

<h3><?php _e('RSS Feeds', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-rss-feed-url"><?php _e('RSS Feed (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-rss-feed-url', 'id' => 'arras-rss-feed-url', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('feed_url') )) ?><br />
<?php _e('This will replace the default WordPress RSS feed to this. Useful if you have decided to use third-party services like <a href="http://feedburner.google.com/">Feedburner</a>.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-rss-comments-url"><?php _e('RSS Comments Feed (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-rss-comments-url', 'id' => 'arras-rss-comments-url', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('comments_feed_url') )) ?><br />
<?php _e('This will replace the default WordPress RSS comments feed to this. Useful if you have decided to use third-party services like <a href="http://feedburner.google.com/">Feedburner</a>.', 'arras') ?>
</td>
</tr>

</table>

<h3><?php _e('Footer Information', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-footer-title"><?php _e('Footer Title', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-footer-title', 'id' => 'arras-footer-title', 'style' => 'width:40%', 'value' => arras_get_option('footer_title') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-footer-message">Footer Message</label></th>
<td>
<?php echo arras_form_textarea( 'arras-footer-message', form_prep(stripslashes(arras_get_option('footer_message'))), 'style="width: 70%; height: 100px;" class="code"' ) ?><br />
<?php _e('Usually your website\'s copyright information would go here.<br /> It would be great if you could include a link to WordPress and even greater if you could include a link to the theme website. :)', 'arras') ?>
</td>
</tr>

</table>

<p class="submit">
<input class="button-primary" type="submit" name="save" value="<?php _e('Save Changes', 'arras') ?>" />
</p>

</div><!-- #general-settings -->
