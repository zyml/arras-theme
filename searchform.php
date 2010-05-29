<form method="get" class="searchform clearfix" action="<?php bloginfo('url'); ?>/">
 <input type="text" value="<?php if ('' == get_search_query()) { _e('Search...', 'arras'); } else { the_search_query(); } ?>" name="s" class="s" onfocus="this.value=''" />
 <input type="submit" class="searchsubmit" value="<?php _e('Search', 'arras') ?>" title="<?php printf( __('Search %s', 'arras'), esc_html( get_bloginfo('name'), 1 ) ) ?>" />
</form>
