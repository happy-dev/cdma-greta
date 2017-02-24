<form role="search"
      method="get"
      id="searchform"
      action="<?php echo home_url( '/' ); ?>"
      class="form-inline col-sm-12 col-xs-12 col-md-12 col-lg-4">

    <!-- <input type="hidden" name="post_type[]" value="formations" /> -->
    <!-- <input type="hidden" name="pages[]" value="1" /> -->
   
    <?php if (is_front_page()) { ?>
      <!-- FRONT PAGE -->
    <div class="row row-input">
        <div class="col-md-3 col-lg-4"></div>
        <div class="col-md-6 col-lg-4">
            <input class="icon-search form-control input-lg"
                   placeholder="Chercher une formation"
                   type="text"
                   name="s"
                   id="s"
                   <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?> onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
        </div>
        <div class="col-sm-1 col-xs-2">
            <button class="btn btn-outline-success" type="submit">OK</button>
        </div>
    <?php } else { ?>
        <!-- OTHER PAGES -->
        <!-- div class="row row-search">
            <div class="col-search col-lg-5 col-md-3 col-sm-4 col-xs-5">
                <div class="select-container">
                    <div id="search-bar-select-facade" class="select-facade">
                        Toutes nos formations
                    </div>
                    <select id="search-bar-select">
                        <option selected="selected">Toutes nos formations</option>
                        <option>Formations diplomantes</option>
                        <option>Formations éligibles au CPF</option>
                    </select>
                </div>
            </div>
            <div class="col-search col-lg-7 col-md-9 col-sm-8 col-xs-7">
                <input class="icon-search form-control input-lg select-input"
                       type="text"
                       name="s"
                       id="s"
                       <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?> onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
                <button class="btn btn-outline-success select-button" type="submit">OK</button>
            </div>
        </div-->
        <div class="form-container">
            <div class="select-container">
                <div id="search-bar-select-facade" class="select-facade">
                    Toutes nos formations
                </div>
                <select name="fd" id="search-bar-select">
                    <option value="toute-formation" selected="selected">Toutes nos formations</option>
                    <option value="formation-diplomante">Formations diplomantes</option>
                    <option value="formation-eligible-au-cpf">Formations éligibles au CPF</option>
                    <option value="formation-diplomantes-cpf">Formations diplomantes et CPF</option>
                </select>
            </div>
            <div class="select-input-container">
                <input class="icon-search form-control input-lg select-input"
                       type="text"
                       name="s"
                       id="s"
                       <?php if(is_search()) { ?>value="<?php the_search_query(); ?>" <?php } else { ?> onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"<?php } ?> />
            </div>
            <button class="btn btn-outline-success select-button" type="submit">OK</button>
        </div>
    <?php } ?>

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
          <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox1" name="fd" value="formation-diplomante">
          Formations diplomantes
        </label>
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox2" name="fe" value="formation-eligible-au-cpf">
          Formations éligibles au CPF
        </label>
      </div>
    <?php } else { ?>
      <!-- OTHER PAGES -->
      <!-- div class="col-lg-12" -->
    <?php } ?> 
        
    <?php if (is_front_page()) { ?>
      <!-- FRONT PAGE --> 
        <div class="col-lg-3 col-sm-0"></div>
    <?php } ?>        
    </div>          
	<?php $query_types = get_query_var('post_type'); ?>

</form>