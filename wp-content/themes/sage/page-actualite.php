<div class="actualite">
    <section class="articles container">
    <?php get_template_part('templates/breadcrumb'); ?>
        <div class="row row-offcanvas row-offcanvas-left">
            <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Actualité</h3>
                <ul>
                <?php wp_list_categories( array(
                                        'orderby' => 'name',
                                        'title_li' => '',
					'current_category' => $cat,
                                        'exclude'    => array( 6, 1 )
                                    ) ); ?>
                </ul>
            </aside>
            <div class="content col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir les domaines</button>
                        <?php //the_content() ?>
                    </div>
                </div>
                <div class="row">
                <!-- THE QUERY -->
                <?php 
		  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                  $the_query = new WP_Query( array( 
                    'posts_per_page' 	=> 6,
                    'paged' 		=> $paged,
                  ));  

		  if ($the_query->have_posts()) {
                    while ( $the_query->have_posts()) : $the_query->the_post();
                      get_template_part('templates/content-actualites', get_post_type()); 
                    endwhile; 
		  }

		  wp_reset_postdata();
                ?>
                    <div class="buttons">
                        <?php
                        $big = 999999999; // need an unlikely integer

                        echo paginate_links( array(
                            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                            'format' => '/page/%#%',
                            'current' => max( 1, get_query_var('paged') ),
			    'total' => $the_query->max_num_pages,
                        ) );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
