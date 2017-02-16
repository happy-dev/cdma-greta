<?php while (have_posts()) : the_post(); ?>

<!-- OPENING IMAGE/VIDEO -->
<section class="search">
    <div class="search-form">
        <form>
            <div class="container">
                <h1><?php the_field('titre_slider'); ?></h1>
                <?php get_search_form(); ?>
            </div>
        </form>
    </div>

    
    <!-- LIENS SLIDER -->
    <div class="container">
    <?php if (have_rows ('liens_header') ) {
            $len = count( get_field('liens_header') );
            $col = min(round(12 / $len, 0, PHP_ROUND_HALF_DOWN), 3);
            $offset = max(12 - ($col * $len), 0);
            $firstcol = true;
        ?>
        <div class="search-links row">
            <?php while ( have_rows('liens_header') ) : the_row(); ?>
                <div class="search-links-item col-md-<?php echo $col; ?> <?php if ($firstcol) : echo 'offset-md-'. $offset; endif; ?> col-sm-6">
                    <a href="<?php echo the_sub_field('lien_header'); ?>">
                        <?php the_sub_field('texte_lien'); ?>
                    </a>
                </div>
            <?php $firstcol = false; endwhile; ?>
        </div>
    <?php } ?>
    </div>

    <?php //if ( false && !get_field('video_home') ) {
        if ( have_rows('slider_home') ): ?>
            <div class="carousel main-carousel js-flickity" data-flickity='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
                <?php while ( have_rows('slider_home') ) : the_row(); ?>
                    <?php
                    $imageArray = get_sub_field('slides_home');
                    $image = $imageArray['url']; ?>
                    <div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); background-size:cover; padding-top:40%; width:100%; height:100%">
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="layer"></div>
        <?php endif ;
    //} else {
    ?>
   <!-- <div class="embed-responsive embed-responsive-21by9 embed-video">
        <video class="embed-responsive-item" poster="http://127.0.0.1/~pauline/cdma/greta-cdma/wp-content/uploads/2016/12/page-intro.jpg" id="bgvid" playsinline autoplay muted loop>
          <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
        <!-- source src="<?php echo get_site_url() ?>/wp-content/themes/sage/assets/videos/turtle.webm" type="video/webm"-->
     <!--   <source src="<?php echo get_site_url() ?>/wp-content/themes/sage/assets/videos/turtle.mp4" type="video/mp4">

        </video>
        <div class="layer"></div>
    </div> -->
    <?php
        //the_field('video_home');
   // } ?>
</section>

<!-- FORMATIONS A LA UNE -->

<section class="articles container">
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
                                $size = 'news';
                                $thumb = $image['sizes'][ $size ]; ?>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                                <img src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>" />
                                <h3><?php the_title(); ?></h3>
                                <p>38h - Temps plein sur 5 jours<br/>
                                Cours du jour, Formation en présentiel<br/>
                                <span>Ecole Estienne</span></p>
                            </a>
                        <?php //the_excerpt(); ?>
                    </article>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>
    </div><!-- row end -->
</section><!-- container end -->

<section class="presentation">
    <div class="row">
        <?php
        $imageArray = get_field('prez_image');
        if( !empty($imageArray) ): 
        $image = $imageArray['url']; 
        endif; ?> 
        <div class="video col-md-6" style="background-image: url(<?php echo $image; ?>); background-size:cover; ">  
            <!-- <img src="<?php echo $url; ?>" alt="<?php echo $alt; ?>" /> -->
            <span class="icon-play" data-toggle="modal" data-target="#modalVideoPresentation"></span>
        </div>
        <div class="intro greta col-md-6">
            <div class="container">
                <h2><?php the_field('prez_titre'); ?></h2>
                <?php the_field('prez_texte'); ?>
                <span class="note">Cliquez sur le bouton lecture pour découvrir la video du Greta CDMA</span>
            </div>
        </div>
    </div>
</section><!-- container end -->

<!-- Modal -->
<div class="modal fade" id="modalVideoPresentation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modalLabel">Le Greta CDMA</h4>
        </div>
        <div class="modal-body">
            <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="<?php the_field('prez_video'); ?>" allowfullscreen></iframe>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
</div>

<!-- ACTUALITES -->

<section class="articles container">
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
                    <?php $image = get_field('post_image');
                        if( !empty($image) ): 
                            $url = $image['url'];
                            $title = $image['title'];
                            $alt = $image['alt'];
                            $size = 'news';
                            $thumb = $image['sizes'][ $size ]; ?>
                        <?php endif; ?>
                     <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                        <h3><?php the_title(); ?></h3>    
        <!-- PAULINE : CSS A MODIFIER -->      
                        <?php
                        $categories = get_the_category();
                        $separator = ' ';
                        $output = '';
                        if($categories){
                            foreach($categories as $category) {
                        if($category->name !== 'A la une') {
                                $output .= '<a style="color: #0956a1;" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "Voir toutes les actualités %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator; }
                            }
                        echo trim($output, $separator);
                        }
                        ?>
                        <?php the_excerpt(); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
    </div><!-- row end -->
</section><!-- container end -->


<!-- LIEUX DE FORMATION -->
<section class="articles container">
<h2>Lieux de formation</h2>

<?php if ( have_rows('lieux_formation') ): ?>
	<div class="main-carousel js-flickity" data-flickity='{ "autoPlay": true, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
		<?php while ( have_rows('lieux_formation') ) : the_row(); ?>
     		<?php
			$image = get_sub_field('logos_lieux');
			$url = $image['url'];
            $title = $image['title'];
            $alt = $image['alt'];
            $size = 'large';
            $thumb = $image['sizes'][ $size ]; 
            $link = get_sub_field('liens_lieux'); ?>
			<div class="carousel-cell" style="height:100px; margin-left: 100px;">
                <a href="<?php echo $link; ?>" target="_blank">
                    <img src="<?php echo $url; ?>" style="height:100%" alt="<?php echo $alt; ?>" />
                </a>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif ?>
</section><!-- container end -->

<?php endwhile; ?>
