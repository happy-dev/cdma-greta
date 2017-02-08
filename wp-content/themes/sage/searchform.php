<form role="search"
      method="get"
      id="searchform"
      action="<?php echo home_url( '/' ); ?>"
      class="form-inline col-sm-12 col-xs-12 col-md-12 col-lg-4">

    <!-- <input type="hidden" name="post_type[]" value="formations" /> -->
    <!-- <input type="hidden" name="post_type[]" value="post" /> -->
   
<?php if (is_front_page()) { ?>
  <!-- FRONT PAGE -->
    <div class="row row-input">
        <div class="col-md-3 col-lg-4"></div>
        <div class="col-md-6 col-lg-4">
<?php } else { ?>
    <!-- OTHER PAGES -->
        <div class="row">
        <div class="col-sm-11 col-xs-10">
<?php } ?>       
            <input class="form-control input-lg"
                   placeholder="Chercher une formation"
                   type="text"
                   name="s"
                   id="s"
                   <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?> onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
        </div>
        <div class="col-sm-1 col-xs-2">
            <button class="btn btn-outline-success" type="submit">OK</button>
        </div>
<?php if (is_front_page()) { ?>
  <!-- FRONT PAGE -->
        <div class="col-md-3 col-lg-4"></div>
<?php } ?>
    </div>
    
    <div class="row row-checkbox">
<?php if (is_front_page()) { ?>
  <!-- FRONT PAGE -->   
      <div class="col-lg-3 col-sm-0"></div>
      <div class="col-lg-6 col-sm-12">
<?php } else { ?>
    <!-- OTHER PAGES -->
      <div class="col-lg-12">
<?php } ?> 
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox1" name="fd" value="formation-diplomante">
          Formations diplomantes
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox2" name="fe" value="formation-eligible-au-cpf">
          Formations éligibles au CPF
        </label>
      </div>
<?php if (is_front_page()) { ?>
  <!-- FRONT PAGE --> 
        <div class="col-lg-3 col-sm-0"></div>
<?php } ?>        
    </div>        
    
	<?php $query_types = get_query_var('post_type'); ?>

</form>
