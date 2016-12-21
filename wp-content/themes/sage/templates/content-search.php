<article class="entry col-md-12">
    <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
        <div class="col-md-4">
                <img
                     src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                     alt="<?php the_title(); ?>" />
        </div>
        <div class="col-md-8">
            <h3><?php the_title(); ?></h3>
            <span>Du 03/11/2016 au 31/01/2017
Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
            <?php the_excerpt(); ?>
        </div>
    </a>
</article>