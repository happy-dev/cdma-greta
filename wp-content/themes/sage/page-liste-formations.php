<?php require_once('DiogenHelper.php'); ?>

<div class="domaine">
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
            <section class="articles col-md-9">
            <?php       
            query_posts( array(
                'post_type'         => 'formations',
                'posts_per_page'    => 9,
                'paged'             => $paged,
                'order'             => 'ASC'
            )); 
           //$paged = ($wp_query->query['paged']) ? $wp_query->query['paged'] : 1;
            $fdia   = [];// Formations DIOGEN IDs Array
            $fia    = [];// Formations IDs Array

            while ( have_posts()) : the_post();
            $fdia[get_the_ID()]     = get_field('id_diogen', get_the_ID());
            $fia[]                  = get_the_ID();
            $df   = DiogenHelper::getMatchingDiogenFormation($fdia[get_the_ID()], $dfs);
            $ss   = DiogenHelper::getSessions($fdia[get_the_ID()]);// Sessions

            $ft   = get_the_title();// Formation Title
            $obj  = $df->OFObjectif;// Objectif

            // Iterating through each session
            foreach ($ss as $s) {
              $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
              $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
              $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
            }
            ?>  
                <div class="row"> 
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
            wp_reset_postdata(); ?>
            <?php previous_posts_link( 'Précédent' ); ?>
            <?php next_posts_link( 'Suivant' ); ?>
            </section>
        </div>
    </div>
</div>