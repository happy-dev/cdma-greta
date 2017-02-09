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
                <p>
                    Développez vos compétences techniques métiers avec nos formations professionnelles en ébénisterie, marqueterie, sculpture ornementale, finitions traditionnelles ou contemporaines, D.A.O., C.A.O.</p>

<p>Nous mobilisons pour vous l’expertise des professionnels et les ateliers de l’École Boulle.</p>

<p>Ébénisterie : L’ébéniste fabrique des meubles, en bois massif ou plaqué. Pour assurer la réalisation d’un produit de qualité (de style ou de création contemporaine), le professionnel opère des choix fonctionnels et culturels étayés par sa culture artistique, ses connaissances et ses savoir-faire techniques.</p>

<p>Marqueterie : Le marqueteur crée des motifs ornementaux (floraux, géométriques ou figuratifs) en utilisant des morceaux de placage (bois précieux de différentes essences, bois teints, écaille, corne, nacre, métaux…) juxtaposés ou incrustés sur un même plan. La marqueterie s’applique au mobilier, aux instruments de musique, aux tableaux, aux panneaux décoratifs…</p>

<p>Sculpture ornementale sur bois : Le sculpteur ornemaniste réalise l’ornementation de meubles, des éléments de décoration pour l’architecture intérieure, boiseries, manteaux de cheminées, portes, balustrades, sièges.  Le sculpteur ornemaniste dessine d’abord le modèle qu’il va reproduire, en tenant compte de tous les détails. Les travaux préparatoires à la sculpture peuvent également être faits en volume, notamment en modelage. Le travail de sculpture peut alors commencer.</p>

<p>Nous proposons également des formations sur mesure à destination des entreprises.
                </p>
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
    
    <div class="container">
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
            <section class="articles col-md-9">
                <header class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir la liste des domaines</button>
                        <h2><?php //echo $i; ?> Formations <?php echo $dom_title; ?></h2>
                    </div>
                </header>

        <!-- LISTE FORMATIONS -->
                <?php
                    $posts = get_field('formations_dom');
                        if( $posts ): 
                            $i=0;
                            foreach( $posts as $post):
                                setup_postdata($post);
                                $i++;
                        ?>  
                <div class="row <?php if ( $i <= 2 ) {echo 'row-mise-en-avant';} ?>"> 
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
               <?php endforeach; 
                        
                    endif; 
                
                 wp_reset_postdata(); ?>
            </section>
        </div>
    </div>
        
    	<?php //ndif; ?>
</div>
<?php endwhile; ?>