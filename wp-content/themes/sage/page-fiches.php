<?php
  $formation_slug = get_query_var('formation');
  $code_AF = substr($formation_slug, strrpos($formation_slug, '-') + 1);
  $sessions = Dokelio::getSessions($code_AF);
  $formation = $sessions[0];// To make code readable
?>

<div class="formation">
  <section class="introduction">
    <div class="container-fluid">
      <?php get_template_part('templates/breadcrumb'); ?>
      <div class="row">
        <div class="introduction-media col-md-6 col-sm-12">
          <figure>
            <img src="https://cdma.happy-dev.fr/wp-content/uploads/Creer_un_site_wordpress-500x282.jpg" alt="<?= $formation->synth_titre ?>" />
          </figure>
          <?php if ($formation->url_video_formation) { ?>
            <span class="icon-play" data-toggle="modal" data-target="#modalVideoFormation"></span>
          <?php } ?>
        </div>
        <div class="col-md-6 col-sm-12">
          <h1 id="formation-title"><?= $formation->synth_titre ?></h1>
          <div class="container-labels row">
          <?php   // Get terms for post
            if ($formation->flag_diplomant)
              echo '<span class="introduction-label col-sm-6">Formation diplômante</span>';
            if ($formation->url_mcf)
              echo '<span class="introduction-label col-sm-6">Formation éligible au CPF</span>';
	  ?>
          </div>
          <hr/>
          <div class="row">
            <div class="col-lg-5">
              <a href="/candidater" class="btn btn-action btn-candidate">Déposer sa candidature</a>
            </div>
            <div class="col-lg-7">
              <a href="/plus-information" class="btn contact-btn">Demander plus d'informations</a>
            </div>
          </div>
          <hr/>
	  <pre>
	    <?= Dokelio::lineBreaks($formation->synth_formation_accroche) ?>
	    <?php if ($formation->url_mcf) :?>
	      <a href="<?= $formation->url_mcf ?>" target="_blank" rel="noopener noreferrer">
		<img class="alignright size-full" src="https://www.cdma.greta.fr/wp-content/uploads/MonCompteFormation_150x150.jpg" alt="Mon Compte Formation" width="150" height="150">
	      </a>
	    <?php endif; ?>
	  </pre>
          <?php 
	    if ($formation->taux_reussite)
              echo '<h2 class="introduction-success">Taux de réussite : '. $formation->taux_reussite .'</h2>';
	  ?>
          <hr/>
          <div class="row">
            <div class="col-md-12">
              <!-- a class="link-pdf" id="pdf-file" href="https://prfc.scola.ac-paris.fr/DIOGEN/PDF/CDMA_PDF.php?PDFNoPForm=<?= $fi; ?>" download="<?= $formation->synth_titre; ?>.pdf">Télécharger la fiche en format PDF</a -->
            </div>
          </div>
          <?php if (!$formation->url_video_formation) { ?>
            <hr/>
            <span class="note hidden-sm-down">Cliquez sur le bouton lecture pour découvrir la vidéo de la formation</span>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="modalVideoFormation" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalLabel"><?= $formation->synth_titre ?></h4>
      </div>
      <div class="modal-body">
        <div id="formation-video-wrapper" class="embed-responsive embed-responsive-4by3">
          <?php 
            global $wp_embed;
            echo $wp_embed->run_shortcode('[embed]'. $formation->url_video_formation .'[/embed]'); 
          ?>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="pauseVideo();">Fermer</button>
      </div>
      </div>
    </div>
  </div>
  <div class="display-none">
    <div id="video-clone">
      <?= $wp_embed->run_shortcode('[embed]'. $formation->url_video_formation .'[/embed]'); ?>
    </div>
  </div>

  <div class="container">
    <ul class="nav nav-tabs sessions-tabs" id="sessions-tabs" role="tablist">
      <?php
        $class = 'active';
        foreach ($sessions as $session) :
      ?>
        <li class="nav-item">
	  <a class="nav-link <?= $class ?>" data-toggle="tab" role="tab" href="#session-<?= $session->code_SES ?>"><?= $session->lib_onglet_session ?></a>
        </li>
      <?php 
	$class = ''; 
	endforeach; 
      ?>
    </ul>

    <div class="formation-detail">
      <div class="row row-offcanvas row-offcanvas-left">
        <aside class="column col-lg-4 col-md-4 sidebar-offcanvas tab-content">
          <div class="container">
            <?php 
              $class = 'in active';
              foreach($sessions as $session) :
	    ?>
	      <div id="session-<?= $session->code_SES ?>" role="tabpanel" class="tab-pane fade <?= $class ?>">
      	      <h2>Dates</h2>
	      <pre><?= Dokelio::lineBreaks($session->periode_session) ?></pre>
	      
      	      <h2>Public</h2>
	      <pre><?= Dokelio::lineBreaks($session->Public_vise) ?></pre>

      	      <h2>Durée</h2>
	      <pre><?= Dokelio::lineBreaks($session->detail_duree_de_formation) ?></pre>

      	      <h2>Tarif(s)</h2>
	      <pre><?= Dokelio::lineBreaks($session->prix) ?></pre>

      	      <h2>Lieu(x)</h2>
	      <pre><?= Dokelio::lineBreaks($session->lieu_de_formation) ?></pre>

      	      <h2>Modalité de formation</h2>
	      <pre><?= Dokelio::lineBreaks($session->rythme_formation) ?></pre>

	      <?php if ($session->effectif) :?>
      	      <h2>Effectif</h2>
	      <pre><?= Dokelio::lineBreaks($session->effectif) ?></pre>
	      <?php endif; ?>

      	      <h2>Contact(s)</h2>
	      <pre><?= Dokelio::lineBreaks($session->contact) ?></pre>

      	      <h2>Référent(e) handicap</h2>
	      <pre><?= Dokelio::lineBreaks($session->referent_handicap) ?></pre>
	    </div>
            <?php 
	      $class = '';
              endforeach;
            ?>
          </div>
        </aside>

        <section class="content col-lg-8 col-md-8 ">
          <div class="row">
            <div class="col-md-12">
              <button type="button" class="btn btn-more hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Informations complémentaires</button>
            </div>
          </div>
          <?php if ($formation->objectif_formation) { ?>
            <h2>Objectifs</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->objectif_formation)) ?></pre>
          <?php } ?>
          <?php if ($formation->Prerequis) { ?>  
              <h2>Prérequis</h2>
              <pre><?= Dokelio::lineBreaks(make_clickable($formation->Prerequis)) ?></pre>
          <?php } ?>
          <?php if ($formation->FRM_contenu_formation) { ?> 
            <h2>Contenu</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->FRM_contenu_formation)) ?></pre>
          <?php } ?>
          <?php if ($formation->methodes_pedagogiques) { ?> 
            <h2>Méthodes pédagogiques</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->methodes_pedagogiques)) ?></pre>
          <?php } ?>
          <?php if ($formation->moyens_pedago) { ?> 
            <h2>Moyens pédagogiques</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->moyens_pedago)) ?></pre>
          <?php } ?>
          <?php if ($formation->modalites_accueil) { ?> 
            <h2>Modalités d'admission et de recrutement</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->modalites_accueil)) ?></pre>
          <?php } ?>
          <?php if ($formation->reconnaissance_des_acquis) { ?> 
            <h2>Reconnaissance des acquis</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->reconnaissance_des_acquis)) ?></pre>
          <?php } ?>
          <?php if ($formation->intervenants) { ?> 
            <h2>Intervenant(e)(s)</h2>
            <pre><?= Dokelio::lineBreaks(make_clickable($formation->intervenants)) ?></pre>
          <?php } ?>
          <?php if ($formation->codeFORMACODE || $formation->codeROME) { ?> 
            <h2>Codification de l'offre</h2>
	    <pre>
	    <?php  
              if ($formation->codeFORMACODE)
          	echo '<strong>Formacode : </strong><br/>'. Dokelio::lineBreaks($formation->codeFORMACODE) .'<br/>';

              if ($formation->codeROME)
          	echo '<strong>ROME : </strong><br/>'. Dokelio::lineBreaks($formation->codeROME); 
	    ?>
	    </pre>
          <?php } ?>

          <hr/>
          <div class="row">
            <div class="col-lg-7">
              <a href="/candidater" class="btn btn-action btn-candidate">Déposer sa candidature</a>
            </div>
            <div class="col-lg-5">
              <a href="/nous-contacter" class="btn contact-btn">Demander plus d'informations</a>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <!-- TEMOIGNAGE -->
  <?php 
  $args = array(  
    'post_type' => 'temoignages',
    'post_status' => 'publish',
    'posts_per_page' => 1, 
    'meta_query' => array(
      array(
        'key' => 'code_AF',
        'value' => "$code_AF",
      )
    ),
  );

  $loop = new WP_Query( $args ); 

  while ($loop->have_posts()) : $loop->the_post(); 
  ?>
    <aside class="formation-temoignage">
      <div class="container">
        <article class="row">
          <div class="col-md-3">
            <figure class="img-circle" data-toggle="modal" data-target="#modalVideoTemoignage">
              <?php 
                $image = get_field('post_image');

                if( !empty($image) ): 
                  $url = $image['url'];
                  $title = $image['title'];
                  $alt = $image['alt'];
                  $size = 'tem';
                  $thumb = $image['sizes'][ $size ]; 
              ?>
                <img src="<?= $thumb; ?>" alt="<?= $alt; ?>" />
	      <?php 
	        endif; 
	      ?>
            </figure>
          </div>
          <div class="col-md-9">
            <h2 data-toggle="modal" data-target="#modalVideoTemoignage"><?php the_title() ?></h2>
            <div><?php the_excerpt() ?></div>
            <p style="font-weight: bold; color: #0956a1; cursor: pointer;" data-toggle="modal" data-target="#modalVideoTemoignage">Lire la suite</p>
          </div>
        </article>
      </div>
    </aside>
  <?php 
  endwhile;
  ?>
  
  <!-- Modal -->
  <div class="modal fade" id="modalVideoTemoignage" tabindex="-1" role="dialog" aria-labelledby="modalLabelTemoignage" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
	<h4 class="modal-title" id="modalLabelTemoignage"><?php the_title(); ?></h4>
        </div>
        <div class="modal-body">
        <?php 
          if ($url = get_field ('video_url')) {
        ?>
          <div id="temoignage-video-wrapper" class="embed-responsive embed-responsive-4by3">
            <?php
              $url = '[embed]'. $url .'[/embed]';
              echo $wp_embed->run_shortcode($url); 
            ?>
          </div>
          <?php
            }
            else {
              echo '<img src="'. $image['sizes']['large'] .'" style="width: 100%;"/>';
            }
          ?>
          <hr/>
          <div class="container">
	      <h2><?php the_title(); ?></h2><br/>
	      <div><?php the_content(); ?></div>
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="pauseVideo();">Fermer</button>
        </div>
      </div>
    </div>
  </div>

  <div class="display-none">
    <div id="tem-video-clone">
      <?= $wp_embed->run_shortcode($url); ?>
    </div>
  </div>

  <div class="display-none" id="formation-breadcrumb">
    <li class="breadcrumb-item">
      <a href="/domaine-offres/<?= $formation->slug ?>"><?= $formation->domaine_libelle ?></a>
    </li>
    <li class="breadcrumb-item active"><?= $formation->synth_titre ?></li>
  </div>
  <div class="display-none">
    <a id="coordo-email" href="mailto:<?= $formation->contact_mel ?>"><?= $formation->contact_mel ?></a>
    <span id="code_AF"><?= $code_AF ?></span>
  </div>
</div>

