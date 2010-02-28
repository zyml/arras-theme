	</div><!-- #content -->
</div><!-- #container -->

<?php wp_reset_query() ?>

<div id="primary" class="aside main-aside sidebar">
<?php arras_above_sidebar() ?>  
<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : ?>
<?php endif; ?>
</ul>		
</div><!-- #primary -->
<div id="secondary" class="aside main-aside sidebar">
    <ul>
        <!-- Widgetized sidebar, if you have the plugin installed.  -->
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary Sidebar #1') ) : ?>              
        <?php endif; ?>
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Secondary Sidebar #2') ) : ?>
		<?php endif; ?>
    </ul>
	<?php arras_below_sidebar() ?>  
</div><!-- #secondary -->
