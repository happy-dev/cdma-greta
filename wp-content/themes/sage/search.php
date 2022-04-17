<div class="domaine search-domaine container">
  <?php
    $search_txt = get_query_var('s');
    $formations = Dokelio::search($search_txt);
  ?>

  <section class="articles">
  <?php 
    if ($search_txt != '')
      echo '<h2>'. count($formations) .' Formations pour "'. $search_txt .'"</h2>';
    else
      echo '<h2>Formations</h2>';

    if (count($formations) == 0) 
      echo '<p>Aucune formation ne correspond à votre recherche</p>';
  ?>
    <div class="row">
      <?php foreach($formations as $formation) :?>
        <article class="entry col-md-12">
          <a class="row row-entry" href="/fiches/<?= Dokelio::toSlug($formation->synth_titre) ?>-<?= Dokelio::codeAFToId($formation->code_AF) ?>" title="<?= $formation->synth_titre ?>">
            <div class="col-md-4">
              <img src="<?= 'https://cdma.happy-dev.fr/wp-content/uploads/Creer_un_site_wordpress-500x282.jpg' ?>" alt="<?= $formation->synth_titre ?>" />
            </div>
            <div class="col-md-8">
              <h3><?= $formation->synth_titre ?></h3>
              <span><?= $formation->synth_periode_de_formation ?></span>
              <p><?= wp_trim_words(Dokelio::lineBreaks($formation->synth_formation_accroche, true), 50, '...') ?></p>
            </div>
          </a>
        </article>
      <?php endforeach ?>
    </div>
  </section>
  <hr/>

  <!-- ACTUALITES -->
  <section class="articles container"> 
  <?php if ($search_txt != '') :
    $pq = new WP_Query('s='.$search_txt);// Posts Query
    $pq->query_vars['post_type']        = 'post';
    $pq->query_vars['posts_per_page']   = 9999;
    $pq->query_vars['orderby']          = 'date';
    relevanssi_do_query($pq);
  ?>
    <h2><?= $pq->post_count ?> Actualités pour "<?= $search_txt ?>"</h2>
      
    <div class="row">
    <?php 
      if ($pq->post_count > 3)
        echo '<a class="see-all col-xs-12" role="button" data-toggle="collapse" href="#more-news" aria-expended="false" aria-controls="more-news">Voir tous les résultats</a>';
    ?>
    </div>
    <?php else : ?>
      <h2>Actualités</h2>
    <?php endif;
      $idx = 1;

      if (isset($pq)) {
        echo '<div class="content row">';
	
	while ($pq->have_posts()) { 
	  $pq->the_post();

          if ($idx == 4) {
            echo '</div><div class="collapse content row" id="more-news">';
          }
     
          get_template_part('templates/content', 'search-news');
          $idx++;
	}

        echo '</div>';
      }

      if (!isset($pq) || $pq->post_count == 0)
        echo '<p>Aucune actualité ne correspond à la recherche</p>';
    ?>
  </section>
</div>
