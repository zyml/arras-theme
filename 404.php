<?php get_header(); ?>

<div id="content" class="section">
<?php arras_above_content() ?>

<div class="single-post">
	<h1 class="entry-title"><?php _e('Error 404 - Not Found', 'arras') ?></h1>
	<div class="entry-content clearfix">
		<?php _e('<p><strong>We\'re very sorry, but that page doesn\'t exist or has been moved.</strong><br />
		Please make sure you have the right URL.</p>
		<p>If you still can\'t find what you\'re looking for, try using the search form below.</p>', 'arras') ?>
		<?php get_search_form(); ?>
	</div>
</div>

<?php arras_below_content() ?>
</div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>