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
                    while (have_posts()) : the_post(); 
                        if ( 'formations' == get_post_type() ) { 
                            get_template_part('templates/content', 'search');
                            $any_formation = true;
                        }
                    endwhile; 
                    if (!$any_formation) {
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
                            get_template_part('templates/content', 'search');
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