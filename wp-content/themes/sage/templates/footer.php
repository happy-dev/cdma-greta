<footer>
  <div class="container">
    <?php //dynamic_sidebar('sidebar-footer'); ?>

      <div class="content row">
          
          <div class="col-md-4">
            <!-- LOGO -->
            <?php 
            $image = get_field('logo_footer', 'option');
                if( !empty($image) ): 
                    $alt = $image['alt'];
                    $size = 'large';
                    $thumb = $image['sizes'][ $size ]; ?>

                    <img class="logo" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                <?php endif; ?>

            <!-- COORDONNEES -->
            <address itemscope itemtype="http://schema.org/ContactPoint">
                <div itemscope itemtype="schema.org/PostalAddress">
                    <div itemprop="streetAddress"><?php the_field('address_1', 'option'); ?></div>
                    <div itemprop="addressLocality"><?php the_field('address_2', 'option'); ?></div>
                </div>
                <div itemprop="telephone" class="phone"><?php the_field('telephone', 'option'); ?></div>
            </address>
              <hr class="hidden-md-up" />
          </div>
          <div class="norms col-md-4">
              <div class="row">
                <!-- LOGOS QUALITE -->
       
                          <div class="col-lg-4 col-md-8">
                    <?php 
                    $image = get_field('logo_qualite_1', 'option');
                        if( !empty($image) ): 
                            $alt = $image['alt'];
                            $size = 'large';
                            $thumb = $image['sizes'][ $size ]; ?>

                            <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                        <?php endif; ?>
                          </div>
                          <div class="col-lg-8 col-md-12">
                        <?php 
                    $image = get_field('logo_qualite_2', 'option');
                        if( !empty($image) ): 
                            $alt = $image['alt'];
                            $size = 'large';
                            $thumb = $image['sizes'][ $size ]; ?>

                            <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                        <?php endif; ?>
                          </div>
                      

              </div>
              <hr class="hidden-md-up" />
          </div>
          
            <div class="socials col-md-4">
                <div class="row row-icons">
                    <a class="icon-social icon-facebook" href="#">Facebook</a>
                    <a class="icon-social icon-twitter" href="#">Twitter</a>
                    <a class="icon-social icon-linkedin" href="#">Linkedin</a>
                </div>
                <div class="row">
                    <div class="col-md-11 col-sm-11 col-xs-10">
                        <input type="text" class="form-control" placeholder="Recevez la Newsletter"/>
                    </div>
                    <div class="col-button col-md-1 col-sm-1 col-xs-2">
                        <button class="btn btn-outline-success">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="trim">
        <div class="trim-left"></div>
        <div class="trim-right"></div>
    </div>
      
    <div class="links row">
        <div class="col-md-12">
            <!-- TEXTE -->
            <?php the_field('texte_footer', 'option'); ?>

            <!-- LIENS -->
                <?php while ( have_rows('liens_footer', 'option') ) : the_row(); ?>
                    <a href="<?php the_sub_field('lien_footer', 'option'); ?>">
                        <?php the_sub_field('texte_lien_footer', 'option'); ?>
                    </a>
                <?php endwhile; ?>
        </div>
    </div>
</footer>
