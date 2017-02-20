<?php while (have_posts()) : the_post(); ?>
<div class="domaine">
<!-- DOMAINE -->
    <section>
        <div class="presentation">
            <!-- IMAGE -->
            <?php if (!get_field ('post_video') ) { ?>
            <figure>
                <?php $image = get_field('post_image');
                if( !empty($image) ): 
                    $url = $image['url'];
                    $title = $image['title'];
                    $alt = $image['alt'];
                    $size = 'large';
                    $thumb = $image['sizes'][ $size ]; ?>
                        <img class="image-background" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                <?php endif; ?>
            </figure>
            <?php } ?>

            <!-- TEXTE -->
            <div class="layer"></div>
            <div class="container">
                <div class="row">
                    <div class="intro col-md-6 col-sm-12 col-xs-12">
                        <?php $dom_title = get_the_title(); ?>
                        <h1><?php echo $dom_title; ?></h1>
                        <?php the_content(); ?>
                        <a class="note"
                           href="#presentation-pannel"
                           data-toggle="collapse"
                           aria-expanded="false"
                           aria-controls="presentation-pannel">Lire la suite</a>
                        <?php if (get_field ('post_video') ) { ?>
                            <span class="note">Cliquez sur le bouton lecture pour découvrir la vidéo <?php echo $dom_title; ?></span>
                        <?php } ?>
                    </div>
                    <!-- VIDEO -->
                    <?php if (get_field ('post_video') ) { ?>
                        <div class="video col-md-6 col-sm-12 col-xs-12">
                            &nbsp;<span class="icon-play" data-target="#modalVideoDomaine"></span>
                        </div>
                     <?php } ?>
                </div>
            </div>
        </div>
        <div class="presentation-annexe container collapse" id="presentation-pannel">
            <?php the_content() ?>
            <a class="note up"
               href="#presentation-pannel"
               data-toggle="collapse"
               aria-expanded="false"
               aria-controls="presentation-pannel">X Fermer</a>
        </div>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="modalVideoDomaine" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel"><?php echo $dom_title; ?></h4>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PtsTJ_xoZYo" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php wp_reset_postdata();?>   
    <div class="container">
        <?php get_template_part('templates/breadcrumb'); ?>
        <div class="row row-offcanvas row-offcanvas-left">
        <!-- LISTE DOMAINES -->
        	<?php
        	$args=( array( 	'post_type' => 'domaines', 'orderby' => 'title', 'order' => 'ASC' ) ); 
        	$the_query = new WP_Query( $args ); ?>
            <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Domaines</h3>
                <ul>
                    <?php while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                        <li>
                            <a href= <?php the_permalink(); ?> >
                                <?php the_title(); ?>
                            </a>
                        </li>	
                    <?php endwhile; ?>
                <?php wp_reset_postdata();?>
                </ul>
            </aside> 
        <!-- FORMATIONS -->
        <?php
        $mea = get_field('mise_en_avant');
        $posts = get_field('formations_dom');      
            if( $posts ): 
                $count = count( $posts ); 
        ?>
            <section class="articles col-md-9">
                <header class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir la liste des domaines</button>
                        <h2><?php echo $count; ?> Formations <?php echo $dom_title; ?></h2>
                    </div>
                </header>

        <!-- LISTE FORMATIONS -->
            <?php       
            $i = 0;
            $ids = get_field('formations_dom', false, false);
            query_posts( array(
                'post_type'         => 'formations',
                'posts_per_page'    => 9,
                'post__in'          => $ids,
                'post_status'       => 'any',
                'orderby'           => 'post__in',
                'paged'             => $paged
            )); 
            $paged = ($wp_query->query['paged']) ? $wp_query->query['paged'] : 1;
            require_once('DiogenHelper.php');
            while ( have_posts()) : the_post();
            $i++;
            ?>
                <div class="row <?php if ( $i <= $mea && 1 == $paged ) {echo 'row-mise-en-avant';} ?>"> 
                    <article class="entry col-md-12">
                        <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                            <div class="col-md-4">
                            <?php
                                $image = get_field('post_image');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'single_f';
                                    $thumb = $image['sizes'][ $size ]; 
                                endif; 
                                ?>
                                <img src="<?php echo $thumb; ?>"
                                     alt="<?php echo $alt; ?>" />
                       
                            </div>
                            <div class="col-md-8">
                                <h3><?php the_title(); ?></h3>
                                <span>Du 03/11/2016 au 31/01/2017 
    Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
                                <p>Réaliser une recherche iconographique en vue de concevoir un projet d'édition.
    Identifier et respecter les contraintes du cahier des charges.
    Respecter l'utilisation des images au regard du Droit.</p>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                endwhile; 
                 
                //wp_reset_postdata(); ?>
                <?php previous_posts_link( 'Précédent' ); ?>
                <?php next_posts_link( 'Suivant' ); 
                endif; ?>
            </section>
        </div>
    </div>
</div>
