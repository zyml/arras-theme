	<?php arras_before_footer() ?>
	</div><!-- #main -->
    
    <div id="footer" class="clearfix">
    	<ul id="footer-sidebar" class="clearfix xoxo">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
            <?php endif; ?>
        </ul>
		<ul class="footer-message">
			<li class="widgetcontainer">
                	<h4 class="widgettitle"><?php echo stripslashes(arras_get_option('footer_title')); ?></h4>
                	<div class="widgetcontent">
                	<?php echo stripslashes(arras_get_option('footer_message')); ?>
					
                	<p><a href="http://www.arrastheme.com/"><strong><?php _e('About Arras Theme', 'arras') ?></strong></a></p>
                	</div>
            </li>
		</ul>
    </div>
    
    <?php wp_footer() ?>
	<?php arras_footer() ?>

</div><!-- #wrapper -->
</body>
</html>
   