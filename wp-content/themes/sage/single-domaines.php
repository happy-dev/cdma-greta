<?php 
    require_once('DiogenHelper.php');       
    while (have_posts()) : the_post(); 
?>
<div class="domaine">
<!-- DOMAINE -->
    <section>
        <div class="presentation">
            <!-- IMAGE -->
            <figure>
                <?php $image = get_field('post_image');
                if( !empty($image) ): 
                    $url = $image['url'];
                    $title = $image['title'];
                    $alt = $image['alt'];
                    $size = 'large';
                    $thumb = $image['sizes'][ $size ]; ?>
                        <img class="image-background" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                <?php endif; ?>
            </figure>

            <!-- TEXTE -->
            <div class="layer"></div>
            <div class="container">
                <?php get_template_part('templates/breadcrumb'); ?>
                <div class="row">
                    <div class="intro col-md-6 col-sm-12 col-xs-12">
                        <?php $dom_title = get_the_title(); ?>
                        <h1><?php echo $dom_title; ?></h1>
                        <?php 
                        $ct     = get_the_content(); 
                        $text   = trim( strip_tags( $ct ) );
                        $word_number = substr_count( "$text ", ' ' );
                        ?>
                        <p><?php echo wp_trim_words( $ct, 120, '...' ); ?></p>
                        <?php if ( $word_number > 120 ) { ?>
                            <a class="note"
                               href="#presentation-pannel"
                               data-toggle="collapse"
                               aria-expanded="false"
                               aria-controls="presentation-pannel">Lire l'intégralité
                            </a>
                        <?php } ?>
                        <?php if (get_field ('post_video') ) { ?>
                            <span class="note">Cliquez sur le bouton lecture pour découvrir la vidéo <?php echo $dom_title; ?></span>
                        <?php } ?>
                    </div>
                    <!-- VIDEO -->
                    <?php if (get_field ('post_video') ) { ?>
                        <div class="video col-md-6 col-sm-12 col-xs-12" data-toggle="modal" data-target="#modalVideoDomaine">
                            &nbsp;<span class="icon-play"></span>
                        </div>
                     <?php } ?>
                </div>
            </div>
        </div>
        <?php if ( $word_number > 120 ) { ?>
        <div class="presentation-annexe container collapse" id="presentation-pannel">
            <?php the_content() ?>
            <a class="note up"
               href="#presentation-pannel"
               data-toggle="collapse"
               aria-expanded="false"
               aria-controls="presentation-pannel">X Fermer</a>
        </div>
        <?php } ?>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="modalVideoDomaine" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel"><?php echo $dom_title; ?></h4>
            </div>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-4by3">
                    <div id="playerDomaine"></div>

                    <script>
                      // 2. This code loads the IFrame Player API code asynchronously.
                      var tag = document.createElement('script');

                      tag.src = "https://www.youtube.com/iframe_api";
                      var firstScriptTag = document.getElementsByTagName('script')[0];
                      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                      // 3. This function creates an <iframe> (and YouTube player)
                      //    after the API code downloads.
                      var playerDomaine;
                      function onYouTubeIframeAPIReady() {
                        playerDomaine = new YT.Player('playerDomaine', {
                          height: '390',
                          width: '640',
                          videoId: '<?php the_field('post_video'); ?>',
                        });
                      }

                        function pauseVideo() {
                        playerDomaine.pauseVideo();
                      }

                    </script>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="">Fermer</button>
            </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php wp_reset_postdata();?>   
    <div class="container">
        <div class="row row-offcanvas row-offcanvas-left">
        <!-- LISTE DOMAINES -->
        	<?php
		$slug = $post->post_name;
        	$args = array(
		  'post_type' => 'domaines', 
		  'orderby' => 'title', 
		  'order' => 'ASC',
		  'posts_per_page' => -1,
		); 
        	$the_query = new WP_Query( $args ); ?>
            <aside class="column col-md-4 sidebar-offcanvas" id="sidebar">
                <div class="container">
                    <h3>Domaines</h3>
                    <ul>
                        <?php 
                          while ( $the_query->have_posts()) : $the_query->the_post(); 
                            $current = '';
                            if ($post->post_name == $slug) {
                              $current = 'current';
                            }
                        ?>

                            <li class="<?php echo $current; ?>">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </li>	
                        <?php endwhile; ?>
                    <?php wp_reset_postdata();?>
                    </ul>
                </div>
            </aside> 
        <!-- FORMATIONS -->
        <?php
        $mea = get_field('mise_en_avant');
        $posts = get_field('formations_dom');      
            if( $posts ): 
                $count = count( $posts ); 
        ?>
            <section class="articles col-md-8">
                <header class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Voir la liste des domaines</button>
                        <h2><?php echo $count; ?> Formations <?php echo $dom_title; ?></h2>
                    </div>
                </header>

        <!-- LISTE FORMATIONS -->
            <?php       
            $i      = 0;
            $fs     = get_field('formations_dom');// Formations
            $fdia   = [];// Formations DIOGEN IDs Array
            $fia    = [];// Formations IDs Array

            foreach($fs as $f) {// Formation
                $fdia[$f->ID]   = get_field('id_diogen', $f->ID);
                $fia[]          = $f->ID;
            }
            $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations
            query_posts( array(
                'post_type'         => 'formations',
                'posts_per_page'    => 9,
                'post__in'          => $fia,
                'post_status'       => 'any',
                'orderby'           => 'post__in',
                'paged'             => $paged
            )); 

            while ( have_posts()) : the_post(); 
                $df   = DiogenHelper::getMatchingDiogenFormation($fdia[get_the_ID()], $dfs);
                $ss   = DiogenHelper::getSessions($fdia[get_the_ID()]);// Sessions
                $ft   = get_the_title();// Formation Title
                $dsc  = DiogenHelper::getDescription(get_the_content(), $df);// Description

            	// Selecting first session
	    	$s    = $ss[0];
                $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
                $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
                $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
		$l    = DiogenHelper::getLocations($s, true);

                $i++;
            ?>
                <div class="row <?php if ( $i <= $mea && 0 == $paged ) {echo 'row-mise-en-avant';} ?>"> 
                    <article class="entry col-md-12">
                        <?php
                          $image = get_field('post_image');
                          if( !empty($image) ): 
                              $url = $image['url'];
                              $title = $image['title'];
			      $alt = $image['alt'] ? $image['alt'] : "";
                              $size = 'single_f';
                              $thumb = $image['sizes'][ $size ]; 
                          endif; 
                        ?>
                        <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                            <div class="col-md-4">
                                <img src="<?php echo $thumb; ?>"
                                     alt="<?php echo $alt; ?>" />
                       
                            </div>
                            <div class="col-md-8">
                                <h3><?php the_title(); ?></h3>
                                <span>
                                <?php if ($sd) {
                                    echo 'Du '.$sd.' au '.$ed ; // dates de session
				    if (isset($l) AND $l != '') {
				      echo '&nbsp;&nbsp;'. $l;
				    }
                                    echo '<br/>';
                                }
                                if ($dc) {
                                    echo $dc ; // commentaire de date
                                    echo '<br/>';
                                }
                                ?>
                                </span>
                                <p><?php echo wp_trim_words( $dsc, 50, '...' ); ?></p>
                            </div>
                        </a>
                    </article>
                </div>
                <?php
                endwhile; 
                //wp_reset_postdata(); ?>
                <div class="buttons">
                 <?php
                $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                ) );
                ?>
                </div>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
