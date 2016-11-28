<?php while (have_posts()) : the_post(); ?>

<div id="home-search">
    <h1><?php the_field('titre_slider'); ?></h1>

    <!-- OPENING SLIDER/VIDEO -->
    <?php if ( have_rows('slider_home') ): ?>
        <div class="carousel main-carousel js-flickity" data-flickity-options='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
            <?php while ( have_rows('slider_home') ) : the_row(); ?>
                <?php
                $imageArray = get_sub_field('slides_home');
                $image = $imageArray['url']; ?>
                <div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); background-size:cover; padding-top:40%; width:100%">
                </div>
            <?php endwhile; ?>
        </div>
        <div class="layer"></div>
    <?php endif ?>
    
    <!-- TEXTE/LIENS SLIDER -->
    <?php while ( have_rows('liens_header') ) : the_row(); ?>
        <a href="<?php the_sub_field('lien'); ?>">
            <?php the_sub_field('texte_lien'); ?>
        </a>
    <?php endwhile; ?>
</div>


<?php if ( get_field('video_home') ): 
the_field('video_home');
endif ?>

<!-- FORMATIONS -->

<div class="container">
    <h2>Formations à la une</h2>
    <a class="see-all" href="">Voir toutes les formations</a>

    <div class="row">
    <!-- THE QUERY -->
    <?php $posts = get_field('formations_une');
        if( $posts ): ?>
            <?php foreach( $posts as $post): ?>
                <?php setup_postdata($post); ?>
                    <article class="formation col-md-4">
                        <?php $image = get_field('post_image');
                            if( !empty($image) ): 

                                $url = $image['url'];
                                $title = $image['title'];
                                $alt = $image['alt'];
                                $size = 'thumbnail';
                                $thumb = $image['sizes'][ $size ]; ?>

                                <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                                    <img src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>" alt="<?php echo $alt; ?>" />
                                    <h3><?php the_title(); ?></h3>
                                </a>
                            <?php endif; ?>
                        <?php //the_excerpt(); ?>
                    </article>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div><!-- row end -->
</div><!-- container end -->

<div class="container">
    <!-- PREZ GRETA -->
    <h2><?php the_field('prez_titre'); ?></h2>
    <?php the_field('prez_texte'); ?>
    <?php the_field('prez_video'); ?>
</div><!-- container end -->

<div class="container">
    <h2>Actualités</h2>
    <a href="/actualites">Voir toute l'actualité</a>

    <div class="row">
        <!-- THE QUERY -->
        <?php 
        $args=( array( 	'post_type' => 'post' ,
                        'category_name'  => 'a-la-une',
                        'posts_per_page' => 3  ) );  
        $the_query = new WP_Query( $args ); 
            while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                <div>
                    <?php the_post_thumbnail('thumbnail'); ?>
                    <a href= <?php the_permalink(); ?> >
                        <?php the_title(); ?>
                    </a>
                    <?php //the_excerpt(); ?>
                </div>	
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
    </div><!-- row end -->
</div><!-- container end -->


<!-- LIEUX DE FORMATION -->
<div class="container">
<h2>Lieux de formation</h2>

<?php if ( have_rows('lieux_formation') ): ?>
	<div class="main-carousel js-flickity" data-flickity-options='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
		<?php while ( have_rows('lieux_formation') ) : the_row(); ?>
     		<?php
			$imageArray = get_sub_field('logos_lieux');
			$image = $imageArray['url']; ?>
			<div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); width: 50px; height:50px;">
			</div>
		<?php endwhile; ?>
	</div>
<?php endif ?>
</div><!-- container end -->

<?php endwhile; ?>