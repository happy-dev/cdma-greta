<?php
require_once('Diogen.php');
require_once('DiogenHelper.php');

$fi = get_field('id_diogen');// Formation Id
//$fi = 29877;// Single session
//$fi = 30143;// Multiple sessions
//$fi = 27494;// Date commented
$fs = DiogenHelper::getFormation($fi);// Formations
$ss = DiogenHelper::getSessions($fi);// Sessions
$ms = count($ss) > 1;// Multiple Sessions ? true or false 

// Iterating through each session
foreach ($ss as $s) {
  $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
  $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
  $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
  $ps   = DiogenHelper::getPublics($s->SSNo);// Publics
  $pc   = Diogen::removeApostrophe($s->SSPublicCommentaire);// Publics Commentaire
  $ds   = DiogenHelper::getDuration($s);// Durations
  $cts  = DiogenHelper::getCounts($s);// Counts
  $pcs  = DiogenHelper::getPrices($s);// Prices 
  $cs   = DiogenHelper::getConditions($s);// Conditions 
  $ls   = DiogenHelper::getLocations($s);// Locations 
  $ct   = DiogenHelper::getContact($fi, $s);// Contact
}

$ctn    = Diogen::removeApostrophe($fs->OFContenu);// Contenu
$obj    = Diogen::removeApostrophe($fs->OFObjectif);// Objectifs
$prm    = Diogen::removeApostrophe($fs->OFPrerequisMaxi);// Prérequis
$metp   = Diogen::removeApostrophe($fs->OFMethode);// Méthodes pédagogiques
$mop    = DiogenHelper::getMoyPeda($fs, $fi);// Moyens pédagogiques
$rcac   = DiogenHelper::getRecoAcquis($fs, $fi);// Reconnaissance des acquis
$int    = Diogen::removeApostrophe($fs->OFIntervenant);// Intervenant
$forc   = DiogenHelper::getFormacode($fs, $fi);// Formacode
$corm   = DiogenHelper::getCodeROME($fs, $fi);// Code ROME
?>

<?php the_post(); ?>
<div class="formation">
    <section class="introduction">
        <div class="container-fluid">
        <?php get_template_part('templates/breadcrumb'); ?>
            <div class="row">
                <div class="introduction-media col-md-6 col-sm-12">
                    <!-- IMAGE / VIDEO -->
                    <?php if (!get_field ('post_video') ) { ?>
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
                    <?php } 
                    else {
                    the_field('video_home');
                    ?>
                    <span class="icon-play" data-toggle="modal" data-target="#modalVideoFormation"></span>
                    <?php } ?>
                </div>
                <div class="col-md-6 col-sm-12">
                    <!-- TEXTE -->
                    <h1><?php the_title(); ?></h1>
                   <?php   // Get terms for post
                     $terms = get_the_terms( $post->ID , 'type_form' );
                     // Loop over each item since it's an array
                     if ( $terms != null ){
                     foreach( $terms as $term ) {
                        if($term->slug == 'formation-diplomante') { 
                            echo '<span class="introduction-label">Formation diplômante</span>';
                        }
                        if($term->slug == 'formation-eligible-au-cpf') { 
                            echo '<span class="introduction-label">Formation éligible au CPF</span>';
                        }
                     unset($term);
                    } } ?>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-5">
                            <a href="/candidater" class="candidate"><button class="btn btn-action btn-candidate">Candidater</button></a>
                        </div>
                        <div class="col-lg-7">
                            <a href="/nous-contacter" class="contact"><button class="btn">Demander plus d'informations</button></a>
                        </div>
                    </div>
                    <hr/>
                    <?php the_content() ?>
                    <?php if (get_field( 'taux_reussite' ) ) { ?> 
                    <h2 class="introduction-success">Taux de réussite : <?php echo get_field( 'taux_reussite' ) ?> </h2>
                    <?php } ?>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <a class="link-pdf" href="#">Télécharger la fiche en format PDF</a>
                        </div>
                    </div>
                    <?php if (get_field ('post_video') ) { ?>
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
                <div class="embed-responsive embed-responsive-4by3">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PtsTJ_xoZYo" allowfullscreen></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="formation-detail">
            <div class="row row-offcanvas row-offcanvas-left">
                <aside class="column col-lg-4 col-md-4 sidebar-offcanvas" id="sidebar">
    <!-- DATES -->   
                    <h2>Dates</h2>
                    <pre><?php // If multiple sessions
                    if ($ms) {
                      foreach ($ss as $s) {
                        $sd = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
                        $ed = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
                        echo '<div>' ;
                        echo 'Du '.$sd.' au '.$ed ; // dates de session
                        echo '<br/>';
                        echo $dc ; // commentaire de date
                        echo '</div>' ;
                      }
                    }
                // If single session
                    else { 
                    if ($sd) {
                    echo 'Du '.$sd.' au '.$ed ; // dates de session
                    }
                    echo '<br/>';
                    echo $dc ; // commentaire de date
                    }
                    ?>
                    </pre>
    <!-- PUBLIC -->
                    <h2>Public</h2>
                    <pre><?php echo $ps; ?>
                    <?php echo $pc; ?></pre>
    <!-- DUREE -->
                    <h2>Durée</h2>
                    <pre><?php echo $ds; ?></pre>
    <!-- EFFECTIF -->
                    <h2>Effectif</h2>
                    <pre><?php echo $cts; ?></pre>
    <!-- TARIF -->
                    <h2>Tarif(s)</h2>
                    <pre><?php echo $pcs; ?></pre>
    <!-- LIEU -->
                    <h2>Lieu(x)</h2>
                    <pre><?php echo $ls; ?></pre>
    <!-- MODALITE -->
                    <h2>Modalité de formation</h2>
                    <pre><?php echo $cs; ?></pre>
    <!-- COORDONNEES GRETA -->
                    <h2>Coordonnées</h2>
                    <pre>GRETA DE LA CRÉATION, DU DESIGN ET DES MÉTIERS D'ART
Agence administrative et commerciale
21 rue de Sambre et Meuse
75010 PARIS
info@cdma.greta.fr</pre>
    <!-- CONTACT -->
                    <h2>Contact(s)</h2>
                    <pre><?php echo $ct; ?></pre>
                </aside>
                <section class="content col-lg-8 col-md-8 ">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-more hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Informations complémentaires</button>
                        </div>
                    </div>
    <!-- CONTENU -->
                    <pre><?php echo $ctn; ?></pre>
    <!-- OBJECTIFS -->
                    <h2>Objectifs</h2>
                    <pre><?php echo $obj; ?></pre>
    <!-- PREREQUIS -->    
                    <h2>Prérequis</h2>
                    <pre><?php echo $prm; ?></pre>
    <!-- METHODES PEDAGOGIQUES -->
                    <h2>Méthodes pédagogiques</h2>
                    <pre><?php echo $metp; ?></pre>
    <!-- MOYENS PEDAGOGIQUES -->
                    <h2>Moyens pédagogiques</h2>
                    <pre><?php echo $mop; ?></pre>
    <!-- RECONNAISSANCE DES ACQUIS -->
                    <h2>Reconnaissance des acquis</h2>
                    <pre><?php echo $rcac; ?></pre>
    <!-- INTERVENANT -->               
                    <h2>Intervenant(e)(s)</h2>
                    <pre><?php echo $int; ?></pre>
    <!-- CODIFICATION -->
                    <h2>Codification de l'offre</h2>
                    <pre><?php echo $forc; ?><?php echo $corm ?></pre>
                    <hr/>
                    
                    <div class="row">
                        <div class="col-lg-7">
                            <a href="/candidater" class="candidate"><button class="btn btn-action btn-candidate">Candidater</button></a>
                        </div>
                        <div class="col-lg-5">
                            <a href="/nous-contacter" class="contact"><button class="btn">Demander plus d'informations</button></a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
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
                                    $size = 'large';
                                    $thumb = $image['sizes'][ $size ]; 
                                ?>
                                <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                                <?php endif; ?>
                            </figure>
                        </div>
                        <div class="col-md-9">
                            <h2><?php the_title() ?></h2>
                            <p><?php the_content() ?></p>
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
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/PtsTJ_xoZYo" allowfullscreen></iframe>
                </div>
                <hr/>
                <div class="container">
                    <h2>Témoignage d’une stagiaire du Greta – formation CAP Tapisserie en 2013</h2>
                    <br/>
                    <pre>C’est avec plaisir que je vous fais part de ma réussite au CAP crû 2013 ! 1er sésame décroché pour démarrer une jolie carrière de Tapissier.

     Je voudrais remercier le GRETA pour sa formation intense et intensive, remercier sa coordinatrice Helen Fréard pour sa connaissance pointue du métier, son exigence quant aux respect des valeurs du métier et des méthodes traditionnelles et son énergie manifeste pour maintenir une formation de qualité. Remercier tous les professeurs (je n’ai pas l’adresse mail de tout le monde) pour leurs qualités professionnelles, leur patience et leur capacité à s’adapter à chacun des stagiaires simultanément !

     Merci à mon maître de stage Mr Bruno LASCAR, véritable maître d’apprentissage qui a la passion de son métier et de la transmission du savoir et du savoir faire, dans le respect des traditions, du produit et du client, tout en étant bien ancré dans le 21e siècle avec ses nouvelles techniques et ses contraintes économiques.

     Remercier ma consultante Mme Amira Ouerhani du cabinet de reclassement BPI, qui croit fermement en mon projet de reconversion depuis le début et m’accompagne pleinement dans mon reclassement.

     Et puis, merci à Micheline et Bernard de la chambre d’hôte de Joué les Tours près du centre d’examens, qui m’ont soutenu matin et soir durant ces 4 jours d’épreuves !

     Me voici donc partie sur les routes de la Tapisserie et de l’Ameublement. Je ne manquerai pas de vous faire part de mes prochaines étapes et réalisations, et espère pouvoir continuer d’échanger avec vous sur cet univers fantastique !

     Je vous souhaite de passer une très belle période estivale.

     A bientôt.

    Françoise Hervy</pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
            </div>
        </div>
    </div>
</div>
                    


<span style="display:none;" id="coordo-email">alexandre@happy-dev.fr</span>

