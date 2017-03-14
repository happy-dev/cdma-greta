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
                    <h1 id="formation-title"><?php the_title(); ?></h1>
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
                            <a href="/nous-contacter" class="contact-btn"><button class="btn">Demander plus d'informations</button></a>
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
<?php // IF MULTIPLE SESSIONS
                    if ($ms) { 
                        foreach ($ss as $s) { 
                    ?>
        <!-- 1. DATES -->
                        <?php if ($sd or $dc) { ?>
                            <h2>Dates</h2>
                            <pre>
                            <?php if ($sd) { 
                            echo 'Du '.$sd.' au '.$ed ; // dates de session
                            echo '<br/>';
                            }
                            if ($dc) {
                            echo $dc ; // commentaire de date
                            }
                            ?>
                            </pre>
                        <?php } ?>
        <!-- 2. PUBLIC --> 
                        <?php if ($ps or $pc) { ?>
                            <h2>Public</h2>
                            <pre><?php echo $ps; ?>
                            <?php echo $pc; ?></pre>
                        <?php } ?>
        <!-- 3. DUREE -->
                        <?php if ($ds) { ?>
                            <h2>Durée</h2>
                            <pre><?php echo $ds; ?></pre>
                        <?php } ?>
        <!-- 4. TARIF -->
                        <?php if ($pcs) { ?>
                            <h2>Tarif(s)</h2>
                            <pre><?php echo $pcs; ?></pre>
                        <?php } ?>
        <!-- 5. LIEU -->
                        <?php if ($ls) { ?>
                            <h2>Lieu(x)</h2>
                            <pre><?php echo $ls; ?></pre>
                        <?php } ?>
        <!-- 6. MODALITE -->
                        <?php if ($cs) { ?>
                            <h2>Modalité de formation</h2>
                            <pre><?php echo $cs; ?></pre>
                        <?php } ?>
        <!-- 7. EFFECTIF -->
                        <?php if ($cts) { ?>
                            <h2>Effectif</h2>
                            <pre><?php echo $cts; ?></pre>
                        <?php } ?>
        <!-- 8. COORDONNEES GRETA -->
                        <h2>Coordonnées</h2>
                        <pre>GRETA DE LA CRÉATION, DU DESIGN ET DES MÉTIERS D'ART
Agence administrative et commerciale
21 rue de Sambre et Meuse
75010 PARIS
info@cdma.greta.fr</pre>
        <!-- 9. CONTACT -->
                        <?php if ($ct) { ?>
                            <h2>Contact(s)</h2>
                            <pre><?php echo $ct; ?></pre>
                         <?php } ?>   
                    <?php } //endforeach
                        } //endif
                    ?>
<!-- IF SINGLE SESSION -->
    <!-- 1. DATES -->  
                    <?php if ($sd or $dc) { ?>
                    <h2>Dates</h2>
                    <pre>
                    <?php if ($sd) {
                    echo 'Du '.$sd.' au '.$ed ; // dates de session
                    echo '<br/>';
                    }
                    if ($dc) {
                    echo $dc ; // commentaire de date
                    }
                    ?>
                    </pre>
                    <?php } ?>
    <!-- 2. PUBLIC --> 
                    <?php if ($ps or $pc) { ?>
                        <h2>Public</h2>
                        <pre><?php echo $ps; ?>
                        <?php echo $pc; ?></pre>
                    <?php } ?>
    <!-- 3. DUREE -->
                    <?php if ($ds) { ?>
                        <h2>Durée</h2>
                        <pre><?php echo $ds; ?></pre>
                    <?php } ?>
    <!-- 4. TARIF -->
                    <?php if ($pcs) { ?>
                        <h2>Tarif(s)</h2>
                        <pre><?php echo $pcs; ?></pre>
                    <?php } ?>
    <!-- 5. LIEU -->
                    <?php if ($ls) { ?>
                        <h2>Lieu(x)</h2>
                        <pre><?php echo $ls; ?></pre>
                    <?php } ?>
    <!-- 6. MODALITE -->
                    <?php if ($cs) { ?>
                        <h2>Modalité de formation</h2>
                        <pre><?php echo $cs; ?></pre>
                    <?php } ?>
    <!-- 7. EFFECTIF -->
                    <?php if ($cts) { ?>
                        <h2>Effectif</h2>
                        <pre><?php echo $cts; ?></pre>
                    <?php } ?>
    <!-- 8. COORDONNEES GRETA -->
                    <h2>Coordonnées</h2>
                    <pre>GRETA DE LA CRÉATION, DU DESIGN ET DES MÉTIERS D'ART
Agence administrative et commerciale
21 rue de Sambre et Meuse
75010 PARIS
info@cdma.greta.fr</pre>
    <!-- 9. CONTACT -->
                    <?php if ($ct) { ?>
                        <h2>Contact(s)</h2>
                        <pre><?php echo $ct; ?></pre>
                    <?php } ?>
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
                        <pre><?php echo $obj; ?></pre>
                    <?php } ?>
    <!-- 2. PREREQUIS -->  
                    <?php if ($prm) { ?>  
                        <h2>Prérequis</h2>
                        <pre><?php echo $prm; ?></pre>
                    <?php } ?>
    <!-- 3. CONTENU -->
                    <?php if ($ctn) { ?> 
                        <h2>Contenu</h2>
                        <pre><?php echo $ctn; ?></pre>
                    <?php } ?>
    <!-- 4. METHODES PEDAGOGIQUES -->
                    <?php if ($metp) { ?> 
                        <h2>Méthodes pédagogiques</h2>
                        <pre><?php echo $metp; ?></pre>
                    <?php } ?>
    <!-- 5. MOYENS PEDAGOGIQUES -->
                    <?php if ($mop) { ?> 
                        <h2>Moyens pédagogiques</h2>
                        <pre><?php echo $mop; ?></pre>
                    <?php } ?>
    <!-- 6. RECONNAISSANCE DES ACQUIS -->
                    <?php if ($rcac) { ?> 
                        <h2>Reconnaissance des acquis</h2>
                        <pre><?php echo $rcac; ?></pre>
                    <?php } ?>
    <!-- 7. INTERVENANT --> 
                    <?php if ($int) { ?>               
                        <h2>Intervenant(e)(s)</h2>
                        <pre><?php echo $int; ?></pre>
                    <?php } ?>
    <!-- 8. CODIFICATION -->
                    <?php if ($forc or $corm) { ?> 
                    <h2>Codification de l'offre</h2>
                    <pre><?php  if ($forc) { 
                                    echo $forc ;
                                    if ($corm) { echo '<br/>'.$corm ; }
                                }
                                else { echo $corm ; } ?></pre>
                    <?php } ?>
                    <hr/>
                    
                    <div class="row">
                        <div class="col-lg-7">
                            <a href="/candidater" class="candidate"><button class="btn btn-action btn-candidate">Candidater</button></a>
                        </div>
                        <div class="col-lg-5">
                            <a href="/nous-contacter" class="contact-btn"><button class="btn">Demander plus d'informations</button></a>
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
                                    $size = 'tem';
                                    $thumb = $image['sizes'][ $size ]; 
                                ?>
                                <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
                                <?php endif; ?>
                            </figure>
                        </div>
                        <div class="col-md-9">
                            <h2 data-toggle="modal" data-target="#modalVideoTemoignage"><?php the_title() ?></h2>
                            <p><?php the_excerpt() ?></p>
                            <p style="font-weight: bold; color: #0956a1;" data-toggle="modal" data-target="#modalVideoTemoignage">Lire la suite</p>
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
                    <iframe class="embed-responsive-item" src="<?php the_field('post_video'); ?>" allowfullscreen></iframe>
                </div>
                <hr/>
                <div class="container">
                    <h2><?php the_title(); ?></h2></br>
                    <pre><?php the_content(); ?></pre>
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
