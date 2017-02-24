<?php require_once('DiogenHelper.php'); ?>

<div class="domaine">
    <div class="container">
        <?php get_template_part('templates/breadcrumb'); ?>
        <div class="row row-offcanvas row-offcanvas-left">
        <!-- LISTE DOMAINES -->
        	<?php
        	$args=( array( 	'post_type' => 'domaines', 'orderby' => 'title', 'order' => 'ASC' ) ); 
        	$the_query = new WP_Query( $args ); ?>
            <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Domaines</h3>
                <ul>
                    <?php while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                        <li>
                            <a href= <?php the_permalink(); ?> >
                                <?php the_title(); ?>
                            </a>
                        </li>	
                    <?php endwhile; ?>
                <?php wp_reset_postdata();?>
                </ul>
            </aside> 
        <!-- FORMATIONS -->
            <section class="articles col-md-9">
            <?php       
            query_posts( array(
                'post_type'         => 'formations',
                'posts_per_page'    => 9,
                'paged'             => $paged,
                'order'             => 'ASC'
            )); 
            $fdia   = [];// Formations DIOGEN IDs Array
            $fia    = [];// Formations IDs Array
            $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations

            while ( have_posts()) : the_post();
            $fdia[get_the_ID()]     = get_field('id_diogen', get_the_ID());
            $fia[]                  = get_the_ID();
            $df   = DiogenHelper::getMatchingDiogenFormation($fdia[get_the_ID()], $dfs);
            $ss   = DiogenHelper::getSessions($fdia[get_the_ID()]);// Sessions

            // Iterating through each session
            foreach ($ss as $s) {
              $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
              $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
              $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
              $ps   = DiogenHelper::getPublics($s->SSNo);// Publics
            }
            //$ctn    = Diogen::removeApostrophe($fs->OFContenu);// Contenu
            ?>  
                <div class="row"> 
                    <article class="entry col-md-12">
                        <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                            <div class="col-md-4">
                            <?php
                                $image = get_field('post_image');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'single_f';
                                    $thumb = $image['sizes'][ $size ]; 
                                endif; 
                                ?>
                                <img src="<?php echo $thumb; ?>"
                                     alt="<?php echo $alt; ?>" />
                            </div>
                            <div class="col-md-8">
                                <h3><?php the_title(); ?></h3>
                                <span>
                                <?php if ($sd) {
                                    echo 'Du '.$sd.' au '.$ed ; // dates de session
                                }
                                echo '<br/>';
                                if ($dc) {
                                    echo $dc ;
                                }
                                ?>
                                <br/>
                                </span>
                                <p><?php the_excerpt(); ?></p>
                                <p><?php //echo $ctn; ?></p>
                            </div>
                        </a>
                    </article>
                </div>
            <?php
            endwhile; 
            wp_reset_postdata(); ?>
            <?php wp_reset_postdata();?>
            <div class="buttons">
                <?php
                $big = 999999999; // need an unlikely integer

                echo paginate_links( array(
                    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format' => '?paged=%#%',
                    'current' => max( 1, get_query_var('paged') ),
                    //'total' => $the_query->max_num_pages
                ) );
                ?>
            </section>
        </div>
    </div>
</div>