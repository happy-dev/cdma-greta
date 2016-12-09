<?php while (have_posts()) : the_post(); ?>

           <?php get_search_form(); ?>

<!-- OPENING IMAGE/VIDEO -->
<div class="search">
    <div class="search-form">
            <form>
                <div class="container">
                    <h1><?php the_field('titre_slider'); ?></h1>
                    <div class="row row-input">
                        <div class="col-md-3 col-lg-4"></div>
                        <div class="col-md-6 col-lg-4">
                            <input class="form-control input-lg"
                                   type="text"
                                   placeholder="Chercher une formation" />
                        </div>
                        <div class="col-md-3 col-lg-4"></div>
                    </div>
                    <div class="row row-checkbox">
                        <div class="col-lg-3 col-sm-2"></div>
                        <div class="col-lg-6 col-sm-8">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox1" value="option1">
                            Formations diplomantes
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" id="inlineCheckbox2" value="option2">
                            Formations éligibles au CPF
                            </label>
                        </div>
                        <div class="col-lg-3 col-sm-2"></div>
                    </div>
                </div>
            </form>
    </div>
    <!-- LIENS SLIDER -->
    <?php if (have_rows ('liens_header') ) { ?>  
        <div class="search-links">
            <?php while ( have_rows('liens_header') ) : the_row(); ?>
                <a href="<?php echo the_sub_field('lien_header'); ?>">
                    <?php the_sub_field('texte_lien'); ?>
                </a>
            <?php endwhile; ?>
        </div>
    <?php } ?>

    <?php if ( !get_field('video_home') ) {
        if ( have_rows('slider_home') ): ?>
            <div class="carousel main-carousel js-flickity" data-flickity='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
                <?php while ( have_rows('slider_home') ) : the_row(); ?>
                    <?php
                    $imageArray = get_sub_field('slides_home');
                    $image = $imageArray['url']; ?>
                    <div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); background-size:cover; padding-top:40%; width:100%">
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="layer"></div>
        <?php endif ;
    } else {
        the_field('video_home');
    } ?>
</div>

<!-- FORMATIONS -->
<section class="container">
    <h2>Formations à la une</h2>
    <a class="see-all hidden-md-down" href="">Voir toutes les formations</a>
    <div class="content row">
    <?php $posts = get_field('formations_une');
        if( $posts ): ?>
            <?php foreach( $posts as $post): ?>
                <?php setup_postdata($post); ?>
                    <article class="entry col-md-4">
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
                                    <p>38h - Temps plein sur 5 jours<br/>
                                    Cours du jour, Formation en présentiel<br/>
                                    <span>Ecole Estienne</span></p>
                                </a>
                            <?php endif; ?>
                        <?php //the_excerpt(); ?>
                    </article>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div><!-- row end -->
</section><!-- container end -->

<section class="presentation">
    <div class="row">
        <div class="video col-md-6">
            <?php //the_field('prez_video'); ?>
            <img src="http://127.0.0.1/~pauline/cdma/greta-cdma/wp-content/uploads/homepage-greta-video-background.jpg" />
            <span class="icon-play"></span>
        </div>
        <div class="intro greta col-md-6">
            <h2><?php the_field('prez_titre'); ?></h2>
            <?php the_field('prez_texte'); ?>
            <span class="note">Cliquez sur le bouton lecture pour découvrir la video du Greta CDMA</span>
        </div>
    </div>
</section><!-- container end -->

<section class="container">
    <h2>Actualités</h2>
    <a class="see-all hidden-md-down" href="/actualites">Voir toute l'actualité</a>

    <div class="content row">
        <!-- THE QUERY -->
        <?php 
        $args=( array( 	'post_type' => 'post' ,
                        'category_name'  => 'a-la-une',
                        'posts_per_page' => 3  ) );  
        $the_query = new WP_Query( $args ); 
            while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                <article class="entry col-md-4">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('thumbnail'); ?>
                        <h3><?php the_title(); ?></h3>
                        <?php the_excerpt(); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
    </div><!-- row end -->
</section><!-- container end -->


<!-- LIEUX DE FORMATION -->
<section class="container">
<h2>Lieux de formation</h2>

<?php if ( have_rows('lieux_formation') ): ?>
	<div class="main-carousel js-flickity" data-flickity='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
		<?php while ( have_rows('lieux_formation') ) : the_row(); ?>
     		<?php
			$imageArray = get_sub_field('logos_lieux');
			$image = $imageArray['url']; ?>
			<div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); width: 50px; height:50px;">
			</div>
		<?php endwhile; ?>
	</div>
<?php endif ?>
</section><!-- container end -->

<?php endwhile; ?>
