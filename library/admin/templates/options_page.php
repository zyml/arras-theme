<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>
<?php include 'functions.php'; ?>

<?php
$forum_contributors = array(
	'Giovanni' => 'http://www.animeblog.nl/',
	'dgodfather' => 'http://trusupremekillaz.com/tskgaming',
	'Charles' => 'http://www.claireraborar.com/travel',
	'Nedrago' => 'http://www.nedrago.com/',
	'Dan' => 'http://www.techunfolding.com/'
);
$translators = array(
	'er_mejor (Spanish)' => 'http://www.teusoft.com/',
	'kokaz84 (French)' => 'http://micromanga.free.fr/',
	'cngamers (Chinese)' => '',
	'lesta (Romanian)' => '',
	'Michael Wenzl (German)' => 'http://www.michaelwenzl.de/',
	'geppe (Italian)' => ''
);
?>

<div class="wrap clearfix">

<?php screen_icon('themes') ?>
<h2 id="arras-header"><?php _e('Arras Theme Options', 'arras') ?></h2>

<?php if (!arras_cache_is_writable()) : ?>
<div class="error">
	<p>
		<?php printf( 
		__('The thumbnails cache directory (%s) is not writable. You will need to set the directory\'s permissions 755 or 777 for the thumbnails to work.', 'arras'), 
		'<code>' . TEMPLATEPATH . '/library/cache' . '</code>' ) ?>
	</p>
	<p><a href="http://codex.wordpress.org/Changing_File_Permissions"><?php _e('More about Changing File/Folder Permissions', 'arras') ?></a></p>
</div><!-- .error -->
<?php endif ?>

<?php if (!arras_gd_is_installed()) : ?>
<div class="error">
	<p><?php _e('The server does not seem to have GD library installed, which is required for the thumbnails to work. Contact your web host for more information.', 'arras') ?></p>
</div>
<?php endif ?>

<?php echo $notices ?>

<form enctype="multipart/form-data" id="arras-settings-form" method="post" action="themes.php?page=arras-options">
<?php wp_nonce_field('arras-admin'); ?>

<ul id="arras-tabs" class="clearfix">
	<li><a href="#general-settings"><?php _e('General', 'arras') ?></a></li>
	<?php if (!function_exists('wp_nav_menu')) : ?><li><a href="#navigation"><?php _e('Navigation', 'arras') ?></a></li><?php endif; ?>
	<li><a href="#home"><?php _e('Home', 'arras') ?></a></li>
	<li><a href="#layout"><?php _e('Layout', 'arras') ?></a></li>
	<li><a href="#design"><?php _e('Design', 'arras') ?></a></li>
	<li><a href="#thumbnails"><?php _e('Thumbnails', 'arras') ?></a></li>
	<li><a href="#remove"><?php _e('Reset', 'arras') ?></a></li>
</ul>

<div class="clearfix arras-options-wrapper">

<?php include 'arras-general.php' ?>
<?php if (!function_exists('wp_nav_menu')) include 'arras-navigation.php' ?>
<?php include 'arras-home.php' ?>
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
			<li><a href="http://www.arrastheme.com/wiki/doku.php/quick_start_guide"><?php _e('Quick Start Guide', 'arras') ?></a></li>
			<li><a href="http://www.arrastheme.com/forums/"><?php _e('Community Forums', 'arras') ?></a></li>
			<li><a href="http://arras-theme.googlecode.com/"><?php _e('Bug Tracker / Repository', 'arras') ?></a></li>
		</ul>
	</div>
	
	<div class="postbox">
		<h3><span><?php _e('Recommended Plugins', 'arras') ?></span></h3>
		<ul>
			<li><a href="http://www.viper007bond.com/wordpress-plugins/regenerate-thumbnails/">Rengenerate Thumbnails</a></li>
			<li><a href="http://lesterchan.net/portfolio/programming/php/#wp-pagenavi">WP-PageNavi</a></li>
			<li><a href="http://blog.moskis.net/downloads/plugins/fancybox-for-wordpress/">FancyBox for WordPress</a></li>
			<li><a href="http://sexybookmarks.net/">SexyBookmarks</a></li>
			<li><a href="http://mitcho.com/code/yarpp/">Yet Another Related Posts Plugin</a></li>
		</ul>
	</div>
	
	<div class="postbox">
		<h3><span><?php _e('How to Support?', 'arras') ?></span></h3>
		<p><?php _e('There are many ways you can support this theme:', 'arras') ?></p>
		<ul>
			<li><?php _e('Tell others about the theme', 'arras') ?></li>
			<li><?php _e('Report bugs / Send patches', 'arras') ?></li>
			<li><?php _e('Contribute to the forums / wiki', 'arras') ?></li>
			<li><?php _e('Translate the theme', 'arras') ?></li>
			<li><strong><?php _e('Send in a donation!', 'arras') ?></strong></li>
		</ul>
		<p><a class="button-primary" href="http://www.arrastheme.com/donate/"><?php _e('Donate using PayPal', 'arras') ?></a></p>
	</div>
	
	<?php if ( !arras_get_option('donate') ) : ?>
	<div class="postbox">
		<h3><span><?php _e('Thanks!', 'arras') ?></span></h3>
		<p><?php _e('Many thanks to those who have contributed to the theme:', 'arras') ?></p>
		<p><strong><?php _e('Forum Contributors', 'arras') ?></strong><br />
		<?php arras_get_contributors($forum_contributors) ?></p>
		<p><strong><?php _e('Translators', 'arras') ?></strong><br />
		<?php arras_get_contributors($translators) ?></p>
		<div id="donors-list">
		</div>
	</div>
	<?php endif; ?>

</div>

</div><!-- .wrap -->

<?php

/* End of file options_page.php */
/* Location: ./library/admin/templates/options_page.php */
