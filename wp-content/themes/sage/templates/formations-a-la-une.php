<section class="articles container">
  <h2>Formations à la une</h2>
  <a class="see-all hidden-md-down" href="/domaine-offres">Voir toutes les formations</a>

  <div class="content row">
  <?php foreach(Dokelio::getHighlights() as $formation) : ?>
    <article class="entry col-md-4">
     <a href="/fiches/<?= Dokelio::toSlug($formation->synth_titre) ?>-<?= Dokelio::codeAFToId($formation->code_AF) ?>" title="<?= $formation->synth_titre ?>">
     <img src="/wp-content/themes/sage/images/<?= $formation->nom_image_formation ?>" alt="<?= $formation->synth_titre ?>" />
       <h3><?= $formation->synth_titre ?></h3>
       <span><?= $formation->synth_periode_de_formation ?></span>
     </a>
    </article>
  <?php endforeach; ?>
  </div><!-- row end -->
</section><!-- container end -->
