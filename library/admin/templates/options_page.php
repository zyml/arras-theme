<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php include 'functions.php'; ?>

<?php if (!arras_cache_is_writable) : ?>
<div class="error">
	<p>
		<?php printf( 
		__('The thumbnails cache directory (%s) is not writable. You will need to set the directory\'s permissions 755 or 777 for the thumbnails to work.', 'arras'), 
		'<code>' . TEMPLATEPATH . '/library/cache' . '</code>' ) ?>
	</p>
	<p><a href="http://codex.wordpress.org/Changing_File_Permissions"><?php _e('More about Changing File/Folder Permissions', 'arras') ?></a></p>
</div><!-- .error -->
<?php endif ?>

<?php if (!arras_gd_is_installed) : ?>
<div class="error">
	<p><?php _e('The server does not seem to have GD library installed, which is required for the thumbnails to work. Contact your web host for more information.', 'arras') ?></p>
</div>
<?php endif ?>

<div class="wrap">

<div class="clearfix">
<h2 id="arras-header"><?php _e('Arras.Theme Options', 'arras') ?></h2>
</div>

<p id="arras-help-links">
<strong><a href="http://www.arrastheme.com/"><?php _e('Donate!', 'arras') ?></a></strong> |
<strong><a href="http://www.arrastheme.com/forums/"><?php _e('Support Forum', 'arras') ?></a></strong>
</p>

<form id="arras-settings-form" method="post" action="themes.php?page=arras-options&_wpnonce=<?php echo $nonce ?>">

<ul id="arras-tabs" class="clearfix">
	<li><a href="#general-settings"><?php _e('General', 'arras') ?></a></li>
	<li><a href="#categories"><?php _e('Categories', 'arras') ?></a></li>
	<li><a href="#navigation"><?php _e('Navigation', 'arras') ?></a></li>
	<li><a href="#layout"><?php _e('Layout', 'arras') ?></a></li>
	<li><a href="#design"><?php _e('Design', 'arras') ?></a></li>
	<li><a href="#remove"><?php _e('Reset', 'arras') ?></a></li>
</ul>

<div class="clearfix arras-options-wrapper">
<div class="arras-options-tabcover"></div>

<?php include 'arras-general.php' ?>
<?php include 'arras-categories.php' ?>
<?php include 'arras-navigation.php' ?>
<?php include 'arras-layout.php' ?>
<?php include 'arras-design.php' ?>

<div id="remove" class="padding-content">
	<h3><?php _e('Clear Thumbnail Cache', 'arras') ?></h3>
	<p><?php _e('If you have recently changed your layout, or edited the thumbnail sizes, it is highly recommended that you clear your thumbnail cache.', 'arras') ?></p>
	<p><?php printf( __('The thumbnail cache folder is located at: %s.', 'arras'), '<code>' . ARRAS_LIB . '/library/cache/' . '</code>') ?><br />
	<?php _e('If this does not work, you can manually delete all the files in that folder.', 'arras') ?>
	<p class="submit">
	<input class="button-secondary" type="submit" name="clearcache" value="<?php _e('Clear Thumbnail Cache', 'arras') ?>" />
	</p>
	<h3><?php _e('Revert to Default Settings', 'arras') ?></h3>
	<p><?php _e('If you do screw up, you can reset the settings here.', 'arras') ?></p>
	<p><?php _e('<strong>NOTE: This will erase all your settings!</strong>', 'arras') ?></p>
	<p class="submit">
	<input class="button-secondary" type="submit" name="reset" value="<?php _e('Uninstall / Reset Arras.Theme', 'arras') ?>" />
	</p>
</div>

</form>
</div><!-- .wrap -->

<?php
/* End of file options_page.php */
/* Location: ./library/admin/templates/options_page.php */
