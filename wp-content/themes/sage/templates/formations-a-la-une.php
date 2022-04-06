<section class="articles container">
  <h2>Formations à la une</h2>
  <a class="see-all hidden-md-down" href="/domaine-offres">Voir toutes les formations</a>

  <div class="content row">
  <?php 
    $formations = Dokelio::getHighlights();

    foreach($formations as $formation) :
  ?>
      <article class="entry col-md-4">
       <a href="https://cdma.happy-dev.fr/fiches/formation-wordpress-concevoir-un-site-vitrine/" title="'. $formation->synth_titre .'">
         <img src="https://cdma.happy-dev.fr/wp-content/uploads/Creer_un_site_wordpress-500x282.jpg" alt="" />
         <h3><?= $formation->synth_titre ?></h3>
         <span><?= $formation->synth_periode_de_formation ?></span>
       </a>
      </article>
  <?php
    endforeach;
  ?>
  </div><!-- row end -->
</section><!-- container end -->
