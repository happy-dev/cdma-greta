<section class="articles container">
  <h2>Formations à la une</h2>
  <a class="see-all hidden-md-down" href="/domaine-offres">Voir toutes les formations</a>

  <div class="content row">
  <?php foreach(Dokelio::getHighlights() as $formation) : ?>
    <article class="entry col-md-4">
     <a href="https://cdma.happy-dev.fr/fiches/formation-wordpress-concevoir-un-site-vitrine/" title="'. $formation->synth_titre .'">
     <img src="/wp-content/uploads/<?= $formation->nom_image ?>" alt="<?= $formation->synth_titre ?>" />
       <h3><?= $formation->synth_titre ?></h3>
       <span><?= $formation->synth_periode_de_formation ?></span>
     </a>
    </article>
  <?php endforeach; ?>
  </div><!-- row end -->
</section><!-- container end -->
