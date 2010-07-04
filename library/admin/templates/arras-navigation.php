<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php
$linkcats['0'] = __('None', 'arras');

// type=link is deprecated in WP3.0 (need to compat this...)
$lc = get_categories('type=link&hide_empty=0');

foreach ( $lc as $c ) {
	$linkcats[$c->cat_ID] = $c->cat_name;
}
?>

<div id="navigation" class="padding-content">

<h3><?php _e('Main Navigation', 'arras') ?></h3>

<?php if (!function_exists('show_suckerfish_options')) : ?>

<p><?php printf( __('It is highly recommended that you use the %s for better control of the main navigation.', 'arras'), '<a href="http://pixopoint.com/multi-level-navigation/">Multi-level Navigation Plugin for WordPress</a>'); ?>
</p>

<table class="form-table">

<tr valign="top">
<th scope="row"><label for="arras-nav-home"><?php _e('Home Link', 'arras') ?></label></th>
<td>
<?php echo arras_form_input(array('name' => 'arras-nav-home', 'id' => 'arras-nav-home', 'style' => 'width:40%', 'value' => arras_get_option('topnav_home') )) ?>
<br /><?php _e('You can change the name of the home link at the main navigation.', 'arras') ?>
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-layout-metapos"><?php _e('Top Navigation Display', 'arras') ?></label></th>
<td>
<?php echo arras_form_radio('arras-nav-display', 'categories', arras_get_option('topnav_display') == 'categories') ?> <?php _e('Categories', 'arras') ?><br />
<?php echo arras_form_radio('arras-nav-display', 'pages', arras_get_option('topnav_display') == 'pages') ?> <?php _e('Pages', 'arras') ?><br />
<?php echo arras_form_radio('arras-nav-display', 'linkcat', arras_get_option('topnav_display') == 'linkcat') ?> <?php _e('Link Category', 'arras') ?><br />
</td>
</tr>

<tr valign="top">
<th scope="row"><label for="arras-nav-linkcat"><?php _e('Link Category', 'arras') ?></label></th>
<td>
<?php echo arras_form_dropdown('arras-nav-linkcat', $linkcats, arras_get_option('topnav_linkcat')); ?>
<br /><?php _e('To organise and arrange the links in the top navigation, you can create a link category with all the links you want to display at the main navigation and assign the link category here.', 'arras') ?>
</td>
</tr>

</table>

<?php else: ?>

<p><?php printf( __('You have %s installed.', 'arras'), '<em>Multi-level Navigation Plugin for WordPress</em> or <em>PixoPoint Menu Plugin</em>'); ?>
</p>

<p><?php _e('You will need to go to their respective plugin settings page to adjust the navigation bar.', 'arras') ?></p>

<?php endif ?>

<?php do_action('arras_admin_settings-navigation'); ?>

</div><!-- #navigation -->
