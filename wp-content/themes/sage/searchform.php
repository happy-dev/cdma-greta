<form role="search"
      method="get"
      id="searchform"
      action="<?php echo home_url( '/' ); ?>"
      class="form-inline col-sm-12 col-xs-12 col-md-12 col-lg-4">

    <input type="hidden" name="post_type[]" value="formations" />
    <input type="hidden" name="post_type[]" value="post" />

    <div class="row">
        <div class="col-sm-11 col-xs-10">
            <input class="form-control"
                   placeholder="Chercher une formation"
                   type="text"
                   name="s"
                   id="s"
                   <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?>value="Chercher une formation" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
        </div>
        <div class="col-sm-1 col-xs-2">
            <button class="btn btn-outline-success" type="submit">OK</button>
        </div>
    </div>
    
    <div class="row row-checkbox">
        <div class="col-lg-12">
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox1" value="option1">
            Formations diplomantes
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" id="inlineCheckbox2" value="option2">
            Formations éligibles au CPF
            </label>
        </div>
    </div>        
    
	<?php $query_types = get_query_var('post_type'); ?>
	<!-- <input type="checkbox" name="post_type[]" value="articles" <label>Articles</label> -->
</form>
