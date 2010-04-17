<?php
if ( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
	die( __('Please do not load this page directly. Thanks!', 'arras') );
if ( post_password_required() ) {
	_e('<p class="nocomments">This post is password protected. Enter the password to view comments.</p>', 'arras');
	return;
}
?>
<?php if ( have_comments() ) : ?>
	<?php if ( !empty($comments_by_type['comment']) ) : ?>  
	<h4 class="module-title"><?php comments_number( __('No Comments', 'arras'), __('1 Comment', 'arras'), _n('% Comment', '% Comments', get_comments_number(), 'arras') ); ?></h4>
		<ol id="commentlist" class="clearfix">
			<?php wp_list_comments('type=comment&callback=arras_list_comments'); ?>
		</ol>
		<div class="comments-navigation clearfix">
			<div class="floatleft"><?php previous_comments_link( __('&laquo; View Older', 'arras') ) ?></div>
		    <div class="floatright"><?php next_comments_link( __('View Newer &raquo;', 'arras') ) ?></div>
		</div>
	<?php endif; ?>
	
	<?php if ( !empty($comments_by_type['pings']) ) : ?>
	<h4 class="module-title"><?php _e('Trackbacks / Pings', 'arras') ?></h4>
	<ol class="pingbacks"><?php wp_list_comments('type=pings&callback=arras_list_trackbacks'); ?></ol>
	<?php endif; ?>
	
<?php else: ?>
		<?php if ('open' == $post->comment_status) : ?>
		<h4 class="module-title"><?php _e('No Comments', 'arras') ?></h4>
		<p class="nocomments"><?php _e('Start the ball rolling by posting a comment on this article!', 'arras') ?></p>
		<?php endif ?>
<?php endif; ?>

<?php if ('closed' == $post->comment_status) : ?>
	<h4 class="module-title"><?php _e('Comments Closed', 'arras') ?></h4>
	<p class="nocomments"><?php _e('Comments are closed. You will not be able to post a comment in this post.', 'arras') ?></p>
<?php else: ?>
<div id="respond">
<h4 class="module-title"><?php comment_form_title( __('Leave a Reply', 'arras'), __('Leave a Reply to %s', 'arras') ); ?></h4>
 <div id="commentsform">
  <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
  <?php comment_id_fields(); ?>
   <?php if ( $user_ID ) : ?>
   <p>
	   <?php printf( __('Logged in as <a href="%1$s" title="Logged in as %2$s">%3$s</a>.', 'arras'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity, $user_identity) ?>
	   <a href="<?php echo wp_logout_url() ?> " title="<?php _e('Log out of this account', 'arras') ?>"> (<?php _e('Logout', 'arras') ?>)</a>
   </p>
   <?php else : ?>
    <p><label for="author"><?php _e('Name', 'arras') ?> <?php if ($req) _e('(required)', 'arras') ?></label><br />
     <input type="text" name="author" id="s1" value="<?php echo $comment_author; ?>" size="40" tabindex="1" minlength="2" <?php if (get_option('require_name_email')) : ?>class="required"<?php endif ?> />
    </p>
    <p><label for="email"><?php _e('Mail (will not be published)', 'arras') ?> <?php if ($req) _e('(required)', 'arras') ?></label><br />
     <input type="text" name="email" id="s2" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" <?php if (get_option('require_name_email')) : ?>class="required email"<?php endif ?> />
    </p>
    <p><label for="url"><?php _e('Website', 'arras') ?></label><br />
     <input type="text" name="url" id="s3" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" class="url" />
    </p>
   <?php endif; ?>
	<p><?php printf( __('<strong>XHTML:</strong> You can use these tags: <code>%s</code>', 'arras'), allowed_tags() ) ?></p>
    <p>
     <textarea name="comment" id="s4" cols="50" rows="10" tabindex="4" class="required"></textarea>
    </p>
	<?php if(function_exists('show_subscription_checkbox')) : ?>
	<p><?php show_subscription_checkbox() ?></p>
	<?php endif; ?>
    <p>
     <input name="submit" type="submit" id="sbutt" tabindex="5" value="<?php _e('Submit Comment', 'arras') ?>" />
     <?php cancel_comment_reply_link( __('Cancel Reply', 'arras') ) ?>
    </p>
   <?php do_action('comment_form', $post->ID); ?>
  </form>
 <?php if(function_exists('show_manual_subscription_form')) { show_manual_subscription_form(); } ?>
 </div><!-- end #commentsform --></div>
 <?php endif ?>