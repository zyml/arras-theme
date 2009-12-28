<form method="get" class="searchform clearfix" action="<?php bloginfo('url'); ?>/">
 <input type="text" value="<?php the_search_query(); ?>" name="s" class="s" onfocus="this.value=''" />
 <input type="submit" class="searchsubmit" value="<?php _e('Search', 'arras') ?>" title="<?php printf( __('Search %s', 'arras'), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
</form>
