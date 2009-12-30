<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php include 'functions.php'; ?>

<div class="wrap clearfix">

<h2 id="arras-header"><?php _e('Arras Theme Options', 'arras') ?></h2>

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

<?php echo $notices ?>

<form id="arras-settings-form" method="post" action="themes.php?page=arras-options&_wpnonce=<?php echo $nonce ?>">

<ul id="arras-tabs" class="clearfix">
	<li><a href="#general-settings"><?php _e('General', 'arras') ?></a></li>
	<li><a href="#navigation"><?php _e('Navigation', 'arras') ?></a></li>
	<li><a href="#layout"><?php _e('Layout', 'arras') ?></a></li>
	<li><a href="#design"><?php _e('Design', 'arras') ?></a></li>
	<li><a href="#thumbnails"><?php _e('Thumbnails', 'arras') ?></a></li>
	<li><a href="#remove"><?php _e('Reset', 'arras') ?></a></li>
</ul>

<div class="clearfix arras-options-wrapper">

<?php include 'arras-general.php' ?>
<?php include 'arras-navigation.php' ?>
<?php include 'arras-layout.php' ?>
<?php include 'arras-design.php' ?>
<?php include 'arras-thumbnails.php' ?>

<div id="remove" class="padding-content">
	<h3><?php _e('Revert to Default Settings', 'arras') ?></h3>
	<p><?php _e('If you do screw up, you can reset the settings here.', 'arras') ?></p>
	<p><?php _e('<strong>NOTE: This will erase all your settings!</strong>', 'arras') ?></p>
	<p class="submit">
	<input class="button-secondary" type="submit" name="reset" value="<?php _e('Uninstall / Reset Arras.Theme', 'arras') ?>" />
	</p>
</div>

</div>

</form>

<div id="arras-right-col">
	<div class="postbox">
		<h3><span><?php _e('Helpful Links', 'arras') ?></span></h3>
		<ul>
			<li><a href="http://www.arrastheme.com/wiki/"><?php _e('Documentation Wiki', 'arras') ?></a></li>
			<li><a href="http://www.arrastheme.com/forums/"><?php _e('Community Forums', 'arras') ?></a></li>
			<li><a href="http://arras-theme.googlecode.com/"><?php _e('Bug Tracker / Repository', 'arras') ?></a></li>
		</ul>
	</div>
	
	<div class="postbox">
		<h3><span><?php _e('Recommended Plugins', 'arras') ?></span></h3>
		<ul>
			<li><a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/">Rengenerate Thumbnails</a></li>
			<li><a href="http://pixopoint.com/products/pixopoint-menu/">PixoPoint Menu Plugin</a></li>
			<li><a href="http://lesterchan.net/portfolio/programming/php/#wp-pagenavi">WP-PageNavi</a></li>
			<li><a href="http://blog.moskis.net/downloads/plugins/fancybox-for-wordpress/">FancyBox for WordPress</a></li>
			<li><a href="http://sexybookmarks.net/">SexyBookmarks</a></li>
			<li><a href="http://mitcho.com/code/yarpp/">Yet Another Related Posts Plugin</a></li>
		</ul>
	</div>
	
	<div class="postbox">
		<h3><span><?php _e('Donate!', 'arras') ?></span></h3>
		<p><?php _e('If you are using Arras Theme and like it, donate to the author!', 'arras') ?></p>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_xclick"><input type="hidden" name="business" value="zy@zy.sg" />
			<input type="hidden" name="item_name" value="Arras Theme Donation" />
			<input type="hidden" name="item_number" value="arrastheme_2010_donation" />
			<input type="hidden" name="no_shipping" value="1" />
			<input type="hidden" name="return" value="http://www.arrastheme.com/" />
			<input type="hidden" name="cancel_return" value="http://www.arrastheme.com/" />
			<input type="hidden" name="currency_code" value="USD" />
			<input type="hidden" name="tax" value="0" />
			<input type="hidden" name="bn" value="PP-DonationsBF" />
			<input class="button-primary" type="submit" name="submit" value="<?php _e('Donate using PayPal', 'arras') ?>" />
			<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
		</form>
	</div>
	
</div>

</div><!-- .wrap -->


<?php
/* End of file options_page.php */
/* Location: ./library/admin/templates/options_page.php */
