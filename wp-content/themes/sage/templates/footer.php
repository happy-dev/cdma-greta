<footer class="footer" >
    <a href="#" title="Haut de page" class="icon-arrow-up scroll-up"></a>
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
                <address itemscope itemtype="https://schema.org/ContactPoint">
                    <div itemscope itemtype="https://schema.org/PostalAddress">
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
                    <?php while ( have_rows('logos_quali', 'option') ) : the_row(); 
                    $image = get_sub_field('logo_quali', 'option');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'single_f';
                                    $thumb = $image['sizes'][ $size ]; 
                                endif; 
                    ?>
                        <div class="col-lg-6 col-md-12">
                            <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                        </div>
                    <?php endwhile; ?>
                </div>
                <hr class="hidden-md-up" />
            </div>
            <!-- RESEAUX SOCIAUX -->
            <div class="socials col-md-4">
                <div class="row row-icons">
                    <?php while ( have_rows('reseaux_sociaux', 'option') ) : the_row(); 
                    $image = get_sub_field('logo_rs', 'option');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                endif; 
                    ?>
                        <a  class="icon-social icon-<?php echo strtolower(get_sub_field('texte_rs', 'option')); ?>" 
                            style="background-image: url(<?php echo $url; ?>)" 
                            href="<?php the_sub_field('lien_rs', 'option'); ?>" 
                            target="_blank">
                            <?php the_sub_field('texte_rs', 'option'); ?>
                        </a>
                    <?php endwhile; ?>
                </div>
                  <?php echo do_shortcode('[contact-form-7 id="1603" title="Newsletter"]'); ?>
            </div>
        </div>
    </div>
    <div class="trim">
        <div class="trim-left"></div>
        <div class="trim-right hidden-xs-down"></div>
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
