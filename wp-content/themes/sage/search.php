<?php require_once('DiogenHelper.php'); ?>

<div class="domaine search-domaine">
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-left">
            <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
            </aside>
            <section class="articles col-md-9">
                <!-- FORMATIONS -->
                <header class="row">
                    <div class="col-md-12">
                        <h2>Formations pour "<?php the_search_query(); ?>"</h2>
                    </div>
                </header>   
                <div class="row">
                    <?php
                    $any_formation = false;

                    $fdia   = [];// Formations DIOGEN IDs Array
                    $fia    = [];// Formations IDs Array

                    while(have_posts()) {
                        the_post();
                        if ( 'formations' == get_post_type() ) { 
                            

                            $fdia[get_the_ID()]     = get_field('id_diogen', get_the_ID());
                            $fia[]                  = get_the_ID();
                        }
                    }

                    $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations

                    while (have_posts()) : the_post(); 
                        if ( 'formations' == get_post_type() ) { 
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

                            get_template_part('templates/content', 'search-formations');
                            $any_formation = true;
                        }
                    endwhile; ?>
                    <?php //echo get_pagination_links(); ?>
                    <div class="nav-previous alignleft"><?php next_posts_link( 'Older posts' ); ?></div>
                    <div class="nav-next alignright"><?php previous_posts_link( 'Newer posts' ); ?></div>
                    <?php if (!$any_formation) {
                        echo '<p>Aucune formation ne correspond à la recherche</p>';
                    }
                    ?>
                </div>

                <!-- ACTUALITES -->
                <header class="row">
                    <div class="col-md-12">
                        <h2>Actualités pour "<?php the_search_query(); ?>"</h2>
                    </div>
                </header>
                <div class="row">
                    <?php 
                    $any_news = false;
                    while (have_posts()) : the_post(); 
                        if ( 'post' == get_post_type() ) { 
                            get_template_part('templates/content', 'search-news');
                            $any_news = true;
                        }
                    endwhile; 
                    if (!$any_news) {
                        echo '<p>Aucune actualité ne correspond à la recherche</p>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </div>
</div>   