<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); } ?>

<div class="wrap">
	<div class="clearfix">
		<h2 id="arras-header"><?php _e('Arras Theme Quick Guide', 'arras') ?></h2>
	</div><!-- .clearfix -->
	
	<p><?php _e("Here's a little handy guide on how to get started with Arras Theme.", 'arras') ?></p>
	
	<h3><?php _e('How do I post thumbnails into each post?', 'arras') ?></h3>
	<p><?php _e('Like some of the WordPress themes, Arras Theme uses single post custom fields to store the location of the images you would like to use.', 'arras') ?></p>
	<p><strong><?php _e('To upload your own images for use in thumbnails:', 'arras') ?></strong></p>
	<p><strong><a href="http://i43.tinypic.com/4ida3n.jpg"><?php _e('Pictorial Guide on Posting Thumbnails', 'arras') ?></a></strong></p>
	<ol style="list-style: decimal; margin: 20px 0; padding-left: 30px;">
		<li><?php _e('When editing or creating a new post, click on the <strong>Insert Image</strong> icon to upload a new image.', 'arras') ?></li>
		<li><?php _e("Upload your image using WordPress' built-in image uploader.", 'arras') ?></li>
		<li><?php _e('When your image has successfully been uploaded, click on <strong>File URL</strong>. A URL should appear in the field above the button (Link URL field). 
			Copy that value.', 'arras') ?></li>
		<li><?php _e('Go back to the post editing screen. Under <strong>Custom Fields</strong>, create a new one by entering <strong>thumb</strong> as the name 
			and paste the URL that you have copied into the value field.') ?></li>
		<li><?php _e('Save the field and you should be able to see the image in your blog. You are done!', 'arras') ?></li>
	</ol>
	
	<h3><?php _e('My thumbnails are not appearing! How do I fix it?', 'arras') ?></h3>
	<p><?php _e('Take a look at this forum post:', 'arras') ?> <a href="http://www.arrastheme.com/forums/topic.php?id=79"><?php _e('Troubleshooting Missing Thumbnails', 'arras') ?></a>.</p>

	<h3><?php _e('Where can I find help regarding this theme?', 'arras') ?></h3>
	<p><?php _e('You can try out the <a href="http://forums.arrastheme.com/">Community Forums</a>.', 'arras') ?></p>
	
	<h3><?php _e('I want to make this theme better! How can I help?', 'arras') ?></h3>
	<ol style="list-style: decimal; margin: 20px 0; padding-left: 30px;">
		<li><?php _e('Help out in the community forums. There are many who need help with this theme.', 'arras') ?></li>
		<li><?php _e('If you know HTML, CSS or PHP, make suggestions on how to improve the code.', 'arras') ?></li>
		<li><?php _e('Donate to the theme developer so that he can continue working this theme.', 'arras') ?></li>
	</ol>
	
</div><!-- .wrap -->

<?php
/* End of file usage_page.php */
/* Location: ./library/admin/templates/usage_page.php */