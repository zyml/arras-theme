<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
 <input type="text" value="<?php the_search_query(); ?>" name="s" 
 	id="s" size="45" onfocus="this.value=''" />
 <input type="submit" id="searchsubmit" value="<?php _e('Search', 'arras') ?>" />
</form>
