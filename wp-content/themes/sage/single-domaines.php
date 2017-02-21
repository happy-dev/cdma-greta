<?php 
    require_once('DiogenHelper.php');       
    while (have_posts()) : the_post(); 
?>
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
            $i      = 0;
            $paged  = isset($wp_query->query['paged']) ? $wp_query->query['paged'] : 1;
            $fs     = get_field('formations_dom');// Formations
            $fdia   = [];// Formations DIOGEN IDs Array
            $fia    = [];// Formations IDs Array

            foreach($fs as $f) {// Formation
                $fdia[$f->ID]   = get_field('id_diogen', $f->ID);
                $fia[]          = $f->ID;
            }
            $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations


            query_posts( array(
                'post_type'         => 'formations',
                'posts_per_page'    => 9,
                'post__in'          => $fia,
                'post_status'       => 'any',
                'orderby'           => 'post__in',
                'paged'             => $paged
            )); 
        
            
            while ( have_posts()) : the_post();
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
            endwhile; 
             
            //wp_reset_postdata(); ?>
            <?php previous_posts_link( 'Précédent' ); ?>
            <?php next_posts_link( 'Suivant' ); 
            endif; ?>
            </section>
        </div>
    </div>
</div>
