<div class="stage container">
    <?php get_template_part('templates/breadcrumb'); ?> 
    <section>
        <div class="content">
            <h1><?php the_title() ?></h1>
            <div class="row">
    <!-- THE QUERY -->
        <?php 
        $args=( array( 	'post_type' => 'stages' ,
                        'posts_per_page' => 12  ) );  
        $the_query = new WP_Query( $args ); 
            while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                <article class="entry col-md-6">
                    <a href="<?php the_permalink(); ?>">

                        <h3><?php the_title(); ?></h3>
                        <span>Date de début : <?php the_field('debut_stage'); ?> - <?php the_field('nature_stage'); ?></span>
                        <p>
                            <strong>Profil recherché :</strong> <?php the_field('profil_stage'); ?><br/>
                            <strong>Personne à contacter :</strong> <?php the_field('contact_stage'); ?><br/>
                            <strong>Email :</strong> <?php the_field('email_stage'); ?><br/>
                        </p>
                        <?php the_excerpt(); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
            </div>
        </div>
    </section>
</div>