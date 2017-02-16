<?php use Roots\Sage\Titles; ?>

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