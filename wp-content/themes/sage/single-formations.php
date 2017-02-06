<div class="secondary-navbar">
    <nav class="navbar container">
        <div class="row">
            <ul class="nav navbar-nav col-lg-8 hidden-md-down">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="formations-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Formations</a>
                    <div class="dropdown-menu" aria-labelledby="formations-dropdown">
                        
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Certifications et VAE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Financez votre formation</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="entreprise-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entreprise</a>
                    <div class="dropdown-menu" aria-labelledby="entreprise-dropdown">
                       
                    </div>
                </li>
            </ul>
            <form class="form-inline col-sm-12 col-xs-12 col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-sm-11 col-xs-10">
                        <input class="form-control"
                               type="text"
                               placeholder="Chercher une formation" />
                    </div>
                    <div class="col-sm-1 col-xs-2">
                        <button class="btn btn-outline-success" type="submit">OK</button>
                    </div>
                </div>
                <div class="row row-checkbox">
                    <div class="col-lg-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox1" value="option1">
                        Formations diplomantes
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox2" value="option2">
                        Formations éligibles au CPF
                        </label>
                    </div>
                </div>
            </form>
      </div>
    </nav>
</div>

<?php
  //require_once('DiogenHelper.php');
  the_post(); ?>

<div class="formation">
    <section class="introduction">
        <div class="container-fluid">
        <?php get_template_part('template-parts/breadcrumb'); ?>
            <ol class="breadcrumb">

                <li class="breadcrumb-item hidden-md-down"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item hidden-md-down"><a href="#">Formations</a></li>
                <li class="breadcrumb-item hidden-md-down"><a href="#">Art du bois</a></li>
                <li class="breadcrumb-item hidden-md-down active">Dessin d'ornement lié au patrimoine</li>
            </ol>
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
                    <span class="introduction-label">Formation éligible au CPF</span>
                    <hr/>
                    <div class="row">
                        <div class="col-lg-5">
                            <a href="/nous-contacter" class="candidate"><button class="btn btn-action btn-candidate">Candidater</button></a>
                        </div>
                        <div class="col-lg-7">
                            <button class="btn">Demander plus d'informations</button>
                        </div>
                    </div>
                    <hr/>
                    <?php the_content() ?>
                    <?php if (get_field( 'taux_reussite' ) ) { ?> 
                    <h2 class="introduction-success">Taux de réussite : <?php echo get_field( 'taux_reussite' ) ?> </h2>
                    <hr/>
                    <?php } ?>
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
                    <h2>Dates</h2>
                    <pre>Du 22/09/2016 au 01/06/2017

Un parcours par an. Rentrée en septembre.
Rentrée en cours d'année possible sur accord du formateur.</pre>
                    <h2>Public</h2>
                    <pre>Tout public, public en emploi, agent de la fonction publique, artisan, salarié, salarié dans le cadre du plan de formation, public sans emploi, demandeur d'emploi, autre public, particulier, individuel
Débutants acceptés.</pre>
                    <h2>Durée</h2>
                    <pre>90 H (en centre)
Les jeudis soir de 18 heures à 21 heures, sauf pendant les vacances scolaires, plus quelques mercredis soir de 18 heures à 21 heures.
Cours du soir
En 1 an</pre>
                    <h2>Effectif</h2>
                    <pre>Minimum : 8
Maximum : 15</pre>
                    <h2>Tarif(s)</h2>
                    <pre>Tarif tout public : 945,00 €</pre>
                    <h2>Lieu(x)</h2>
                    <pre>ESAA-Ecole Boulle - Lycée des métiers d'art, de l'architecture intérieure et du design 
9, rue Pierre Bourdan
75012 PARIS</pre>
                    <h2>Modalité de formation</h2>
                    <pre>Collectif, Cours du soir, Formation en présentiel, Hors temps de travail</pre>
                    <h2>Coordonnées</h2>
                    <pre>GRETA DE LA CRÉATION, DU DESIGN ET DES MÉTIERS D'ART
Agence administrative et commerciale
21 rue de Sambre et Meuse
75010 PARIS
info@cdma.greta.fr</pre>
                    <h2>Contact(s)</h2>
                    <pre>Julien BOGARD
Tél 1. 01 45 43 20 90
Tél 2. 
j.bogard@cdma.greta.fr</pre>
                </aside>
                <section class="content col-lg-8 col-md-8 ">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-more hidden-md-up navbar-toggle" data-toggle="offcanvas">Informations complémentaires</button>
                        </div>
                    </div>
                    <pre>Contenu de la formation préparatoire à la sculpture ornementale et pédagogie adaptés au stagiaire.
En fonction du niveau du stagiaire, acquérir des compétences de sculpteur ornemaniste et possibilité de :
- travailler différents projets, à partir de plâtres ou de modèles existants
- Etudier le bas-relief, le haut-relief et la statuaire à partir de plâtres fournis et choisis par le formateur
- Comprendre la chronologie des différents styles sur des ornements simples
- Comprendre les refends
- Savoir repérer des ornements simples de chaque style.
- Comprendre les différentes compositions de chaque style
- Information sur les différents styles et techniques de dessin.

Toutes les productions réalisées par les stagiaires pendant leur formation sont conservées par les stagiaires.
une session par an
Document non contractuel</pre>
                    <h2>Objectifs</h2>
                    <pre>Développer le travail d'observation.
Se former l'oeil à travers des plâtres.
Exécuter un dessin ombré. 
Acquérir la notion de volume à travers le dessin pour l'appliquer à la taille du bois, à la sculpture, à la reparure, à la gravure, à la ciselure, à la taille de la pierre ... et à tous les métiers qui touchent à l'ornement.
Comprendre et analyser les compositions des différents styles. 
Approcher la statuaire et la ronde-bosse.</pre>
                    <h2>Prérequis</h2>
                    <pre>Avoir le sens de l'observation ou aimer dessiner ou avoir un intérêt pour l'ornement.
Sculpteurs, doreurs, repareurs, restaurateurs de mobilier, graveurs, staffeurs, tailleurs de pierre ... sont les bienvenus. </pre>
                    <h2>Méthodes pédagogiques</h2>
                    <pre>Exposés théoriques, démonstrations et mises en pratique des techniques.
Travail personnalisé , progression individualisée, pédagogie adaptée au stagiaire.

Papier et supports fournis.</pre>
                    <h2>Moyens pédagogiques</h2>
                    <pre>document pédagogique, étude de cas, travaux pratiques
Lieu de formation : atelier de sculpture de l'Ecole Boulle
Collection de moulages. Gypsothèque.
Papier et supports fournis.
Prévoir l'achat de matériel et de fournitures de dessin. Une liste vous sera remise lors de l'entretien de recrutement.
</pre>
                    <h2>Reconnaissance des acquis</h2>
                    <pre>Attestation de fin de formation
Relevé des acquis de la formation.</pre>
                    <h2>Modalités d'admission et de recrutement</h2>
                    <pre>admission après entretien, admission après test
Envoyer votre candidature,CV + lettre de motivation détaillée, à Julien Bogard : j.bogard@cdma.greta.fr
Vous pouvez joindre à votre candidature des photos de vos réalisations ou votre book présentant vos croquis et ou vos carnets de dessins le cas échéant.
Test de positionnement pédagogique en dessin.
Voir également nos formations de " modelage ornemental " et de " sculpture ornementale " .
</pre>
                    <h2>Internant(e)(s)</h2>
                    <pre>Patrick BLANCHARD, professeur à l'école Boulle, sculpteur sur bois,
Meilleur Ouvrier de France 1997 MOF</pre>
                    <h2>Codification de l'offre</h2>
                    <pre>Formacode : 45096 - sculpture bois, 45057 - dessin art, 45076 - sculpture, 45066 - art plastique, 45554 - artisanat art
ROME B1302 - Décoration d'objets d'art et artisanaux ROME K1602 - Gestion de patrimoine culturel
IMPRIMER
</pre>
                    <hr/>
                    <button class="btn btn-action btn-candidate">Candidater</button>
                    <button class="btn">Demander plus d'informations</button>
                </section>
            </div>
        </div>
    </div>

<!-- TEMOIGNAGE -->
    <?php if (get_field ('temoignage') ) {
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
                    

<span class="display-none" id="coordo-email">alexandre@happy-dev.fr</span>