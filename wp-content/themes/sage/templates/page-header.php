<?php use Roots\Sage\Titles; ?>

<div class="secondary-navbar">
    <nav class="navbar container">
          <?php //wp_nav_menu(array('theme_location' => 'secondary_navigation_bis', 'menu_class' => 'nav')); ?>
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
            <?php get_search_form(); ?>
      </div>
    </nav>
</div>

<section class="presentation presentation-page">
    <div class="container">
        <figure>
            <img class="image-background" src="http://127.0.0.1/~pauline/cdma/greta-cdma/wp-content/uploads/2016/12/page-intro.jpg" alt="">
        </figure>
        <div class="row row-intro">
            <div class="col-md-3"></div>
            <div class="intro col-md-6 col-sm-12 col-xs-12">
                <h1><?= Titles\title(); ?></h1>
                <p>Le GRETA de la Création, du Design et Métiers d’Art est une structure de l’Éducation nationale qui propose des formations pour adultes. Ces formations sont organisées en cours du soir ou en journée pour répondre aux besoins en compétences des entreprises et des particuliers.</p>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php get_template_part('templates/breadcrumb'); ?>
</section>