<?php
require_once('Diogen.php');
require_once('DiogenHelper.php');

global $post;
the_post();

$sa = [];// Sessions Array
$fi = get_field('id_diogen');// Formation Id
$fs = DiogenHelper::getFormation($fi);// Formations
$ss = DiogenHelper::getSessions($fi);// Sessions
$ms = count($ss) > 1;// Multiple Sessions ? true or false 


// Iterating through each session
$first = true;
foreach ($ss as $s) {
  $sa[] = DiogenHelper::getLeftColumn($s, $fi, $first);
  $first = false;
}

$ctn    = Diogen::removeApostrophe($fs->OFContenu);// Contenu
$obj    = Diogen::removeApostrophe($fs->OFObjectif);// Objectifs
$prm    = Diogen::removeApostrophe($fs->OFPrerequisMaxi);// Prérequis
$metp   = Diogen::removeApostrophe($fs->OFMethode);// Méthodes pédagogiques
$mop    = DiogenHelper::getMoyPeda($fs, $fi);// Moyens pédagogiques
$mar    = DiogenHelper::getAdmissionMod($fs, $fi);// Méthodes d'Admission et de Recrutement
$rcac   = DiogenHelper::getRecoAcquis($fs, $fi);// Reconnaissance des acquis
$int    = Diogen::removeApostrophe($fs->OFIntervenant);// Intervenant
$forc   = DiogenHelper::getFormacode($fs, $fi);// Formacode
$corm   = DiogenHelper::getCodeROME($fs, $fi);// Code ROME
?>

<div class="formation">
    <section class="introduction">
        <div class="container-fluid">
        <?php get_template_part('templates/breadcrumb'); ?>
            <div class="row">
                <div class="introduction-media col-md-6 col-sm-12">
                    <!-- IMAGE / VIDEO -->
                    <figure>
                        <?php 
                        $image = get_field('post_image');
                          if( !empty($image) ): 
                            $url = $image['url'];
                            $title = $image['title'];
                            $alt = $image['alt'];
                            $size = 'single_f';
                            $thumb = $image['sizes'][ $size ]; 
                        ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                        <?php endif; ?>
                    </figure>
                    <?php if ($url = get_field ('video_url') ) { ?>
                      <span class="icon-play" data-toggle="modal" data-target="#modalVideoFormation"></span>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <!-- TEXTE -->
                    <h1 id="formation-title"><?php the_title(); ?></h1>
                    <div class="container-labels row">
                   <?php   // Get terms for post
                     $terms = get_the_terms( $post->ID , 'type_form' );
                     // Loop over each item since it's an array
                     if ( $terms != null ){
                     foreach( $terms as $term ) {
                        if($term->slug == 'formation-diplomante') { 
                            echo '<span class="introduction-label col-sm-6">Formation diplômante</span>';
                        }
                        if($term->slug == 'formation-eligible-au-cpf') { 
                            echo '<span class="introduction-label col-sm-6">Formation éligible au CPF</span>';
                        }
                     unset($term);
                    } } ?>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-5">
                            <a href="/candidater" class="btn btn-action btn-candidate">Candidater</a>
                        </div>
                        <div class="col-lg-7">
                            <a href="/plus-information" class="btn contact-btn">Demander plus d'informations</a>
                        </div>
                    </div>
                    <hr/>
                    <pre><?php 
		      if ($content = get_the_content()) {
			echo $content;
		      }
		      else {
			echo Diogen::removeApostrophe($fs->OFAccroche);
    		      }
		    ?></pre>
                    <?php if (get_field( 'taux_reussite' ) ) { ?> 
                    <h2 class="introduction-success">Taux de réussite : <?php echo get_field( 'taux_reussite' ) ?> </h2>
                    <?php } ?>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <a class="link-pdf" id="pdf-file" href="https://prfc.scola.ac-paris.fr/DIOGEN/PDF/CDMA_PDF.php?PDFNoPForm=<?php echo $fi; ?>" download="<?php echo $post->post_name; ?>.pdf">Télécharger la fiche en format PDF</a>
                        </div>
                    </div>
                    <?php if (!nullOrEmpty($url)) { ?>
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
                <h4 class="modal-title" id="modalLabel"><?php the_title(); ?></h4>
            </div>
            <div class="modal-body">
                <div id="formation-video-wrapper" class="embed-responsive embed-responsive-4by3">
                  <?php 
		      global $wp_embed;
		      $url = '[embed]'. $url .'[/embed]';
		      echo $wp_embed->run_shortcode($url); 
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
	<?php echo $wp_embed->run_shortcode($url); ?>
      </div>
    </div>
    <div class="container">
        <ul class="nav nav-tabs sessions-tabs" role="tablist">
            <?php
                $class = 'active';
                foreach ($ss as $s) :
                  $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
                  $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
            ?>
            <li class="nav-item">
            <a class="nav-link <?php echo $class; ?>"
               data-toggle="tab"
               role="tab"
               href="#session-<?php echo $s->SSNo ?>">Session du <?php echo $sd ?> au <?php echo $ed ?></a>
            </li>
            <?php $class = ''; endforeach; ?>
        </ul>
        <div class="formation-detail">
            <div class="row row-offcanvas row-offcanvas-left">
                <aside class="column col-lg-4 col-md-4 sidebar-offcanvas tab-content">
                    <div class="container">
                        <?php //var_dump($sa); exit;
                          foreach($sa as $s) {
                            echo $s; 
                          }
                        ?>
                    </div>
                </aside>

                <section class="content col-lg-8 col-md-8 ">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-more hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Informations complémentaires</button>
                        </div>
                    </div>
    <!-- 1. OBJECTIFS -->
                    <?php if ($obj) { ?>
                        <h2>Objectifs</h2>
                        <pre><?php echo make_clickable($obj); ?></pre>
                    <?php } ?>
    <!-- 2. PREREQUIS -->  
                    <?php if ($prm) { ?>  
                        <h2>Prérequis</h2>
                        <pre><?php echo make_clickable($prm); ?></pre>
                    <?php } ?>
    <!-- 3. CONTENU -->
                    <?php if ($ctn) { ?> 
                        <h2>Contenu</h2>
                        <pre><?php echo make_clickable($ctn); ?></pre>
                    <?php } ?>
    <!-- 4. METHODES PEDAGOGIQUES -->
                    <?php if ($metp) { ?> 
                        <h2>Méthodes pédagogiques</h2>
                        <pre><?php echo make_clickable($metp); ?></pre>
                    <?php } ?>
    <!-- 5. MOYENS PEDAGOGIQUES -->
                    <?php if ($mop) { ?> 
                        <h2>Moyens pédagogiques</h2>
                        <pre><?php echo make_clickable($mop); ?></pre>
                    <?php } ?>
    <!-- 5. MÉTHODES ADMISSION ET RECRUTEMENT -->
                    <?php if ($mar) { ?> 
                        <h2>Modalités d'admission et de recrutement</h2>
                        <pre><?php echo make_clickable($mar); ?></pre>
                    <?php } ?>
    <!-- 6. RECONNAISSANCE DES ACQUIS -->
                    <?php if ($rcac) { ?> 
                        <h2>Reconnaissance des acquis</h2>
                        <pre><?php echo make_clickable($rcac); ?></pre>
                    <?php } ?>
    <!-- 7. INTERVENANT --> 
                    <?php if ($int) { ?>               
                        <h2>Intervenant(e)(s)</h2>
                        <pre><?php echo make_clickable($int); ?></pre>
                    <?php } ?>
    <!-- 8. CODIFICATION -->
                    <?php if ($forc or $corm) { ?> 
                    <h2>Codification de l'offre</h2>
                    <pre><?php  
		      if ($forc) { 
			echo '<strong>Formacode : </strong><br/>';
                        echo $forc ;
			echo '<br/>';
                      }
                      if ($corm) { 
			echo '<strong>ROME : </strong><br/>';
		        echo $corm ; 
		      }
                    ?></pre>
                    <?php } ?>

 
                    <hr/>
                    
                    <div class="row">
                        <div class="col-lg-7">
                            <a href="/candidater" class="btn btn-action btn-candidate">Candidater</a>
                        </div>
                        <div class="col-lg-5">
                            <a href="/nous-contacter" class="btn contact-btn">Demander plus d'informations</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>

	<?php $majDate = new DateTime( $fs->OFMAJDate ); ?>
        <pre style="text-align:center; font-style:italic;">Date de mise à jour : <?php echo $majDate->format('d/m/Y'); ?> | Ce document n'est pas contractuel et peut subir des modifications</pre>
    </div>

<!-- TEMOIGNAGE -->
    <?php if (get_field ('tem_yes_no') == 'oui' ) {
        $posts = get_field('temoignage');
        foreach( $posts as $post): 
            setup_postdata($post); ?>
            <aside class="formation-temoignage">
                <div class="container">
                    <article class="row">
                        <div class="col-md-3">
                            <figure class="img-circle" data-toggle="modal" data-target="#modalVideoTemoignage">
                                <?php 
                                  // IMAGE / VIDEO
                                  $image = get_field('post_image');
                                  if( !empty($image) ): 
                                    $url = $image['url'];
                                    $title = $image['title'];
                                    $alt = $image['alt'];
                                    $size = 'tem';
                                    $thumb = $image['sizes'][ $size ]; 
                                ?>
                                <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                                <?php endif; ?>
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
        <?php endforeach;
    } ?>
    
    <!-- Modal -->
    <div class="modal fade" id="modalVideoTemoignage" tabindex="-1" role="dialog" aria-labelledby="modalLabelTemoignage" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabelTemoignage"><?php the_title(); ?></h4>
            </div>
            <div class="modal-body">
		<?php 
                  if ($url = get_field ('video_url') ) {
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
	<?php echo $wp_embed->run_shortcode($url); ?>
      </div>
    </div>
</div>
