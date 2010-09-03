<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div id="general-settings" class="padding-content">

<h3><?php _e('Theme Information', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><?php _e('Current Version', 'arras') ?></th>
<td class="version">
<span class="number"><?php echo ARRAS_VERSION ?></span>
<p><?php _e('If you have recently upgraded Arras to a new release, it is <span style="color: red">highly recommended</span> that you reset your theme options, clear your browser cache and restart your browser before proceeding.', 'arras') ?></p>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-credits"><?php _e('Display Credits', 'arras') ?></label></th>
<td>
<?php echo arras_form_checkbox('arras-credits', 'show', !arras_get_option('donate'), 'id="arras-credits"') ?> 
<?php _e('Credits will only appear to the right of the theme options page.', 'arras') ?>
</td>
</tr>

</table>

<h3><?php _e('Site Information', 'arras') ?></h3>
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

<tr valign="top">
<th scope="row"><label for="arras-twitter"><?php _e('Twitter Username', 'arras') ?></label></th>
<td>
<?php echo htmlentities('http://www.twitter.com/') ?><?php echo arras_form_input(array('name' => 'arras-twitter', 'id' => 'arras-twitter', 'class' => 'code', 'size' => '15', 'value' => arras_get_option('twitter_username') )) ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-facebook"><?php _e('Facebook Profile (URL)', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-facebook', 'id' => 'arras-facebook', 'class' => 'code', 'size' => '65', 'value' => arras_get_option('facebook_profile') )) ?><br />
<?php _e('Link to your Facebook profile.', 'arras') ?>
</td>
</tr>

</table>

<h3><?php _e('Footer Information', 'arras') ?></h3>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-footer-sidebars"><?php _e('No. of Columns', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown( 'arras-footer-sidebars', array(1 => 1, 2, 3, 4), arras_get_option('footer_sidebars') ); ?>
<?php echo '<br />' . __('Footer sidebars will be labelled respectively (eg. Footer Sidebar #1, etc.)', 'arras') ?>
</td>
</tr>

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

<?php do_action('arras_admin_settings-general'); ?>

</div><!-- #general-settings -->
