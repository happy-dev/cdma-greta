<?php 
  $domain_slug = get_query_var('domain');
  $index = get_query_var('index');

  if ($domain_slug) {// Displaying a specific domain
    $formations = Dokelio::getFormations($domain_slug, $index);
    $formations_count = Dokelio::getFormationsCount($domain_slug);
    $current_domain = $formations[0];// He he, code needs to be readable
    $word_number = substr_count($current_domain->accroche_domaine, ' ');
    $dom_title = $current_domain->lib_domaine;
  }
  else {
    $formations = Dokelio::getFormations(null, $index);
    $formations_count = Dokelio::getFormationsCount();
    $current_domain = null;
    $dom_title = null;
  }
?>

<div class="domaine">
  <?php if ($domain_slug) : ?>
  <section>
    <div class="presentation">
      <figure>
        <img class="image-background" src="/wp-content/themes/sage/images/<?= $current_domain->image_domaine ?>" alt="<?= $current_domain->lib_domaine ?>" />
      </figure>
      <div class="container">
        <?php get_template_part('templates/breadcrumb'); ?>
        <div class="row">
          <div class="intro col-md-6 col-sm-12 col-xs-12">
            <h1><?= $dom_title ?></h1>
              <p><?= wp_trim_words($current_domain->accroche_domaine, 120, '...') ?></p>
              <?php if ( $word_number > 120 ) { ?>
                <a class="note" href="#presentation-pannel" data-toggle="collapse" aria-expanded="false" aria-controls="presentation-pannel">Lire l'intégralité </a>
              <?php } ?>
              <?php if ($current_domain->url_video_domaine) { ?>
                <span class="note">Cliquez sur le bouton lecture pour découvrir la vidéo <?= $dom_title ?></span>
              <?php } ?>
          </div>
          <?php if ($current_domain->url_video_domaine) { ?>
            <div class="video col-md-6 col-sm-12 col-xs-12" data-toggle="modal" data-target="#modalVideoDomaine">
              &nbsp;<span class="icon-play"></span>
            </div>
           <?php } ?>
        </div><!-- .row -->
      </div>
    </div>
    <?php if ( $word_number > 120 ) { ?>
      <div class="presentation-annexe container collapse" id="presentation-pannel">
        <?= $current_domain->accroche_domaine ?>
        <a class="note up" href="#presentation-pannel" data-toggle="collapse" aria-expanded="false" aria-controls="presentation-pannel">X Fermer</a>
      </div>
    <?php } ?>
  </section>
  <div class="modal fade" id="modalVideoDomaine" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalLabel"><?= $dom_title ?></h4>
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

              // 3. This function creates an <iframe> (and YouTube player) after the API code downloads.
              var playerDomaine;
              function onYouTubeIframeAPIReady() {
                playerDomaine = new YT.Player('playerDomaine', {
                  height: '390',
                  width: '640',
                  videoId: '<?= substr($current_domain->url_video_domaine, strrpos($current_domain->url_video_domaine, '=') + 1) ?>'
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
  <?php else: ?>
    <div class="container">
      <?php get_template_part('templates/breadcrumb'); ?>
    </div>
  <?php endif; ?>

  <div class="container">
    <div class="row row-offcanvas row-offcanvas-left">
      <aside class="column col-md-4 sidebar-offcanvas" id="sidebar">
        <div class="container">
          <h3>Domaines</h3>
          <ul>
            <?php 
              $current = '';
	      foreach(Dokelio::getDomains() as $domain) {
		if ($current_domain)
		  $current = ($domain->lib_domaine == $current_domain->lib_domaine) ? 'current' : '';
	        echo '<li class="'. $current .'"><a href="/domaine-offres/'. $domain->slug_domaine .'">'. $domain->lib_domaine .'</a></li>';
	      }
            ?>
          </ul>
        </div>
      </aside> 

      <section class="articles col-md-8">
        <header class="row">
          <div class="col-md-12">
            <button type="button" class="btn hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Voir la liste des domaines</button>
            <h2><?= $formations_count ?> Formations <?= $dom_title ?></h2>
          </div>
        </header>

	<?php foreach($formations as $formation) :?>
          <div class="row <?= $formation->flag_avant ? 'row-mise-en-avant' : '' ?>"> 
            <article class="entry col-md-12">
	      <a class="row row-entry" href="/fiches/<?= $formation->slug_formation ?>" title="<?= $formation->synth_titre ?>">
                <div class="col-md-4">
                  <img src="/wp-content/themes/sage/images/<?= $formation->nom_image_formation ?>" alt="<?= $formation->synth_titre ?>" />
                </div>
                <div class="col-md-8">
                  <h3><?= $formation->synth_titre ?></h3>
		  <span><?= $formation->synth_periode_de_formation ?></span>
                  <p><?= wp_trim_words(Dokelio::lineBreaks($formation->synth_formation_accroche, true), 50, '...') ?></p>
                </div>
              </a>
            </article>
          </div>
	<?php endforeach ?>

	<?php
	  if ($formations_count > CDMA_LIMIT) {
	    echo '<div class="buttons">';
	    for($i=1; $i<=(1+$formations_count/CDMA_LIMIT); $i++) {
	      if ((!$index && $i==1) || $index == $i)
                echo '<span aria-current="page" class="page-numbers btn-action current">'. $i .'</span>';
	      else if ($domain_slug)
	        echo '<a class="page-numbers" href="/domaine-offres/'. $domain_slug .'/'. $i .'/">'. $i .'</a>';
	      else
	        echo '<a class="page-numbers" href="/domaine-offres/'. $i .'/">'. $i .'</a>';
	    }
	    echo '</div>';
	  }
	?>
      </section>
    </div>
  </div>
</div>
