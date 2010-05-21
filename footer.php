	</div><!-- #main -->
	
	<?php arras_before_footer() ?>
    
    <div id="footer" class="clearfix">
    	<ul id="footer-sidebar" class="clearfix xoxo">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
			<li></li>
            <?php endif; ?>
        </ul>
		
		<div class="footer-message">
		<p class="floatright"><a class="arras" href="http://www.arrastheme.com/"><strong><?php _e('About Arras Theme', 'arras') ?></strong></a></p>
		<?php echo stripslashes(arras_get_option('footer_message')); ?>		
		</div><!-- .footer-message -->
    </div>
    
    <?php wp_footer() ?>
	<?php arras_footer() ?>
	
	<?php echo $wpdb->num_queries . __(' queries') ?>
	<?php
	global $wpdb;
    echo "<pre style='white-space: pre-wrap;'>";
    print_r($wpdb->queries);
    echo "</pre>";
	?>

</div><!-- #wrapper -->
</body>
</html>
   