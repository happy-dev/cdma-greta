<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">

<input type="hidden" name="post_type[]" value="formations" />
<input type="hidden" name="post_type[]" value="post" />

	<input type="text" name="s" id="s" <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?>value="Chercher une formation" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> /><br />
	<?php $query_types = get_query_var('post_type'); ?>
	<!-- <input type="checkbox" name="post_type[]" value="articles" <label>Articles</label> -->
</form>