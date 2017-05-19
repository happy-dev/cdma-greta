<?php require_once('DiogenHelper.php'); ?>

<div class="domaine search-domaine container">
    <!-- FORMATIONS -->
        <?php
        $search_txt 	= get_query_var('s');    
        $fq         	= new WP_Query('s='.$search_txt);// Posts Query

        $fq->query_vars["taxonomy"] 	= null;
        $fq->query_vars['post_type']      	= 'formations';
        $fq->query_vars['posts_per_page'] 	= 9;
        $fq->query_vars['paged'] 		= $paged;
        $fq->query_vars['tax_query'] 	= [];   

        if (isset($_GET['taxonomy'])) {
          switch ($_GET['taxonomy']) {
            case 'formation-diplomantes-cpf':
              $ta = ['formation-diplomante', 'formation-eligible-au-cpf'];
      $op = 'AND';
              break;

            case 'toute-formation':
              break;

            default:
              $ta = $_GET['taxonomy'];
      $op = 'IN';
          }

          if (isset($ta)) {
            $tq = [[
              'taxonomy' => 'type_form',
              'field'    => 'slug',
              'terms'    => $ta,
      'operator' => $op,
            ]];// Tax Query

            $fq->query_vars['tax_query'] = $tq;   
          }
        }

            relevanssi_do_query($fq);

            $any_formation 	= false;
            $fdia   		= [];// Formations DIOGEN IDs Array
            $fia    		= [];// Formations IDs Array
            $i=0;
            while ($fq->have_posts()) : $fq->the_post();
              if ( 'formations' == get_post_type() ) { 
                $i++;
                $fdia[get_the_ID()]     = get_field('id_diogen', get_the_ID());
                $fia[]                  = get_the_ID();
                $any_formation 		= true;
              }
            endwhile;
            ?>
            <section class="articles">
      <?php if ($_GET['s'] != '') : ?>
                    <h2><?php echo($fq->post_count); ?> Formations pour "<?php the_search_query(); ?>"</h2>
      <?php else : ?>
                    <h2>Formations</h2>
      <?php endif; ?>	  
        <?php
            if (!$any_formation) {
                echo '<p>Aucune formation ne correspond à la recherche</p>';
            }
            ?>
        <div class="row">
            <?php
            $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations
            while ($fq->have_posts()) : $fq->the_post(); 
               if ( 'formations' == get_post_type() ) { 
                    $df   = DiogenHelper::getMatchingDiogenFormation($fdia[get_the_ID()], $dfs);
                    $ss   = DiogenHelper::getSessions($fdia[get_the_ID()]);// Sessions
                $dsc  = DiogenHelper::getDescription(get_the_content(), $df);// Description

                // Selecting first session
            $s 	  = $ss[0];
                    $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
                    $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
                    $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
                    $ps   = DiogenHelper::getPublics($s->SSNo);// Publics
             ?>
                    <article class="entry col-md-12">
                        <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
                            <div class="col-md-4">
                            <?php $image = get_field('post_image');
                                if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'news';
                                    $thumb = $image['sizes'][ $size ]; ?>
                                                            <?php endif; ?>
                                    <img style="width:100%;" src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>" />
                            </div>
                            <div class="col-md-8">
                                <h3><?php the_title(); ?></h3>
                                <span>
                                <?php if ($sd) {
                                    echo 'Du '.$sd.' au '.$ed ; // dates de session
                                    echo '<br/>';
                                }
                                echo $dc ; // commentaire de date
                                ?>
                                <br/>
                                </span>
                            <?php echo wp_trim_words( $dsc, 50, '...' ); ?>
                            </div>
                        </a>
                    </article>
                    <?php $any_formation = true;
               }
            endwhile; ?>
             <div class="buttons">
             <?php
            $big = 999999999; // need an unlikely integer

            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
    'total' => $fq->max_num_pages
            ) );
            ?>
            </div>
        </div>
    </section>
    <hr/>

        <!-- ACTUALITES -->
    <section class="articles container"> 
    <?php if ($_GET['s'] != '') : ?>
    <?php 
      $pq         = new WP_Query('s='.$search_txt);// Posts Query
      $pq->query_vars['post_type']        = 'post';
      $pq->query_vars['posts_per_page']   = 3;
      $pq->query_vars['orderby']   	= 'date';
      relevanssi_do_query($pq);
    ?>
       <h2><?php echo($pq->post_count); ?> Actualités pour "<?php the_search_query(); ?>"</h2>
    <?php else : ?>
                  <h2>Actualités</h2>
    <?php endif; ?>	
        <div class="content row">
            <?php 
            $any_news = false;
            // THE POSTS QUERY

            while ($pq->have_posts()) : $pq->the_post(); 
                //if ( 'post' == get_post_type() ) { 
                    get_template_part('templates/content', 'search-news');
                    $any_news = true;
                //}
            endwhile; 
            ?>
        </div>
        <?php
        if (!$any_news) {
            echo '<p>Aucune actualité ne correspond à la recherche</p>';
        }
        ?>
    </section>
</div>   
