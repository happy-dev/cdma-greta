<div class="secondary-navbar">
    <nav class="navbar container">
        <div class="row">
            <ul class="nav navbar-nav col-lg-8 hidden-md-down">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="formations-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Formations</a>
                    <div class="dropdown-menu" aria-labelledby="formations-dropdown">
                        
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Certifications et VAE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Financez votre formation</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="entreprise-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entreprise</a>
                    <div class="dropdown-menu" aria-labelledby="entreprise-dropdown">
                       
                    </div>
                </li>
            </ul>
            <?php get_search_form(); ?>
      </div>
    </nav>
</div>

<?php while (have_posts()) : the_post(); ?>
<div class="domaine">
<!-- DOMAINE -->
    <aside>
        <article>
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
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                            <a class="note"
                               href="#presentation-pannel"
                               data-toggle="collapse"
                               aria-expanded="false"
                               aria-controls="presentation-pannel">Lire la suite</a>
                            <?php if (get_field ('post_video') ) { ?>
                                <span class="note">Cliquez sur le bouton lecture pour découvrir la vidéo <?php the_title(); ?></span>
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
        </article>
    </aside>
    
    <!-- Modal -->
    <div class="modal fade" id="modalVideoDomaine" tabindex="-1" role="dialog" aria-labelledby=" Vidéo <?php the_title(); ?>" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php the_title(); ?></h4>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PtsTJ_xoZYo" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
    

<!-- LISTE DOMAINES -->
	<!-- THE QUERY -->
    
<section class="container">
    <div class="row row-offcanvas row-offcanvas-left">
    <!--div class="row"-->
	<?php
	$args=( array( 	'post_type' => 'domaines', 'orderby' => 'title', 'order' => 'ASC' ) ); 
	$the_query = new WP_Query( $args ); ?>

        <div class="column col-md-3 sidebar-offcanvas" id="sidebar">
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
        </div>

        <!-- LISTE FORMATIONS -->
        <div class="content col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir la liste des domaines</button>
                    <h2>128 Formations <?php the_title(); ?></h2>
                </div>
            </div>
            
            <div class="row row-mise-en-avant">
                <article class="entry col-md-12">
                    <a class="row row-entry" href="#" title="CAP Ébéniste (F/H)">
                        <div class="col-md-4">
                                <img
                                     src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                                     alt="CAP Ébéniste (F/H)" />
                        </div>
                        <div class="col-md-8">
                            <h3>CAP Ébéniste (F/H)</h3>
                            <span>Du 03/11/2016 au 31/01/2017
Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
                            <p>Réaliser une recherche iconographique en vue de concevoir un projet d'édition.
Identifier et respecter les contraintes du cahier des charges.
Respecter l'utilisation des images au regard du Droit.</p>
                        </div>
                    </a>
                </article>
                <article class="entry col-md-12">
                    <a class="row row-entry" href="#" title="CAP Ébéniste (F/H)">
                        <div class="col-md-4">
                                <img
                                     src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                                     alt="CAP Ébéniste (F/H)" />
                        </div>
                        <div class="col-md-8">
                            <h3>CAP Ébéniste (F/H)</h3>
                            <span>Du 03/11/2016 au 31/01/2017
Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
                            <p>Réaliser une recherche iconographique en vue de concevoir un projet d'édition.
Identifier et respecter les contraintes du cahier des charges.
Respecter l'utilisation des images au regard du Droit.</p>
                        </div>
                    </a>
                </article>
                <article class="entry col-md-12">
                    <a class="row row-entry" href="#" title="CAP Ébéniste (F/H)">
                        <div class="col-md-4">
                                <img
                                     src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                                     alt="CAP Ébéniste (F/H)" />
                        </div>
                        <div class="col-md-8">
                            <h3>CAP Ébéniste (F/H)</h3>
                            <span>Du 03/11/2016 au 31/01/2017
Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
                            <p>Réaliser une recherche iconographique en vue de concevoir un projet d'édition.
Identifier et respecter les contraintes du cahier des charges.
Respecter l'utilisation des images au regard du Droit.</p>
                        </div>
                    </a>
                </article>
            </div>
            
            <div class="row">
            <?php $posts = get_field('formations_dom');
            if( $posts ): ?>
                <?php foreach( $posts as $post): ?>
                    <?php setup_postdata($post); ?>

                    <article class="entry col-md-12">

                        <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                            <div class="col-md-4">
                            <?php $image = get_field('post_image');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'thumbnail';
                                    $thumb = $image['sizes'][ $size ]; ?>
                                    <img
                                         src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                                         alt="<?php echo $alt; ?>" />
                            <?php endif; ?>
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
                <?php endforeach; ?>
            </div>
            
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>
    
	<?php endif; ?>
</div>
<?php endwhile; ?>