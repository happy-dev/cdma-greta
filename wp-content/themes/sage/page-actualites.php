<div class="actualite">
    <section class="container">
    <?php get_template_part('templates/breadcrumb'); ?>

        <div class="row row-offcanvas row-offcanvas-left">
            <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Actualité</h3>
                <?php wp_list_categories( array(
                                        'orderby' => 'name',
                                        'title_li' => '',
                                        'exclude'    => array( 6, 1 )
                                    ) ); ?>
            </aside>
            <div class="content col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir les domaines</button>
                        <h2><?php //the_title() ?></h2>
                        <?php //the_content() ?>
                    </div>
                </div>
                <div class="row">
                <!-- THE QUERY -->
                <?php 
                $args = array(  'post_type' => 'post' ,
                                'posts_per_page' => 12  ) ;  
                $the_query = new WP_Query( $args ); 
                    while ( $the_query->have_posts()) : $the_query->the_post();
                        get_template_part('templates/content-actualites', get_post_type()); 
                    endwhile; ?>
                <?php wp_reset_postdata();?>
                </div>
            </div>
        </div>
    </section>
</div>