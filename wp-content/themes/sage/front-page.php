<?php 
require_once('DiogenHelper.php');
while (have_posts()) : the_post(); 
?>

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
                <div class="search-links-item col-lg-<?php echo $col; ?> <?php if ($firstcol) : echo 'offset-lg-'. $offset; endif; ?> col-md-6 col-sm-6">
                    <a href="<?php echo the_sub_field('lien_header'); ?>">
                        <?php the_sub_field('texte_lien'); ?>
                    </a>
                </div>
            <?php $firstcol = false; endwhile; ?>
        </div>
    <?php } ?>
    </div>

    <?php 
    $header_type = get_field('header_home');
    if ( false && $header_type == 'slider' ) {
        if ( have_rows('slider_home') ): ?>
            <div class="carousel main-carousel js-flickity" data-flickity='{ "autoPlay": 5000, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
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
    } else {
    ?>
  
   <div class="embed-responsive embed-responsive-21by9 embed-video">
        <video class="embed-responsive-item" poster="<?php echo get_site_url() ?>/wp-content/uploads/page-intro.jpg" id="bgvid" playsinline autoplay muted loop>
          <!-- WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
        <!-- source src="<?php echo get_site_url() ?>/wp-content/themes/sage/assets/videos/turtle.webm" type="video/webm"-->
          <source src="<?php echo get_site_url() ?>/wp-content/uploads/<?php the_field('video_home') ?>" type="video/mp4">
        </video>
        <div class="layer"></div>
    </div>
    <?php
   } ?>
    
</section>

<!-- FORMATIONS A LA UNE -->

<section class="articles container">
    <h2>Formations à la une</h2>
    <a class="see-all hidden-md-down" href="/liste-formations">Voir toutes les formations</a>
    <div class="content row">
    <?php $posts = get_field('formations_une');
    if( $posts ):
        foreach( $posts as $post):
            setup_postdata($post);
            // DIOGEN 
            $fdia   = [];// Formations DIOGEN IDs Array
            $fia    = [];// Formations IDs Array
            $fdia[get_the_ID()]     = get_field('id_diogen', get_the_ID());
            $fia[]                  = get_the_ID();
            $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations
            $df   = DiogenHelper::getMatchingDiogenFormation($fdia[get_the_ID()], $dfs);
            $ss   = DiogenHelper::getSessions($fdia[get_the_ID()]);// Sessions
            $ft   = get_the_title();// Formation Title
            //$ls   = DiogenHelper::getLocations($s);// Locations 

            // Iterating through each session
            foreach ($ss as $s) {
              $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
              $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
              $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
            }
    ?>
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
                <p>
                <?php if ($sd) {
                    echo 'Du '.$sd.' au '.$ed ; // dates de session
                }
                else {
                    echo $dc ; // commentaire de date
                }
                echo '<br/>';
                ?>
                <span><?php //echo $ls; ?></span>
                </p>
            </a>
        </article>
        <?php endforeach;
        wp_reset_postdata();
        endif; ?>
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
                <div id="playerPresentation"></div>

                <script>
                  // 2. This code loads the IFrame Player API code asynchronously.
                  var tag = document.createElement('script');

                  tag.src = "https://www.youtube.com/iframe_api";
                  var firstScriptTag = document.getElementsByTagName('script')[0];
                  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                  // 3. This function creates an <iframe> (and YouTube player)
                  //    after the API code downloads.
                  var playerPresentation;
                  function onYouTubeIframeAPIReady() {
                    playerPresentation = new YT.Player('playerPresentation', {
                      height: '390',
                      width: '640',
                      videoId: '<?php the_field('prez_video'); ?>',
                    });
                  }

                    function pauseVideo() {
                    playerPresentation.pauseVideo();
                  }

                </script>
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
                        <span><?php echo get_the_date(); ?></span>
                     </a>

                        <?php
                        $categories = get_the_category();
                        $separator = ' ';
                        $output = '';
                        if($categories){
                            foreach($categories as $category) {
                        if($category->name !== 'A la une') {
                                $output .= '<a class="entry-category" href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "Voir toutes les actualités %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator; }
                            }
                        echo trim($output, $separator);
                        }
                        ?>
                    <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                        <?php the_excerpt(); ?>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
    </div><!-- row end -->
</section><!-- container end -->


<!-- LIEUX DE FORMATION -->
<section class="articles container schools">
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
