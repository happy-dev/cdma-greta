<?php while (have_posts()) : the_post(); ?>
<article class="presentation presentation-page">
    <div class="container">
        <div class="row row-intro">
            <div class="col-md-3"></div>
            <div class="intro col-md-6 col-sm-12 col-xs-12">
                <h1><?php the_title(); ?></h1>
                <span>Date de début : <?php the_field('debut_stage'); ?> - <?php the_field('nature_stage'); ?></span>
                <p>
                    Profil recherché : <?php the_field('profil_stage'); ?><br/>
                    Personne à contacter : <?php the_field('contact_stage'); ?><br/>
                    Email : <?php the_field('email_stage'); ?><br/>
                </p>
                <?php //the_excerpt(); ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</article>

<!-- SYLVIA -->

<h1><?php the_title(); ?></h1>
<h2><?php the_field('nature_stage'); ?> / <?php the_field('duree_stage'); ?></h2>
<div><?php the_field('commune_stage'); ?></div>
<div>Publié le <?php the_date(); ?></div>

<br/>
<br/>
<h3>Informations sur la société</h3>
<h4>Société ou organisme :</h4><div><?php the_field('societe_stage'); ?></div>
<h4>Site web : </h4>
    <a href="<?php the_field('site_stage'); ?>" target="_blank">
        <?php the_field('site_stage'); ?>
    </a>
</div>
<h4>Personne à contacter : </h4><?php the_field('contact_stage'); ?>
<div><h4>Email : </h4><?php the_field('email_stage'); ?></div>
<div><h4>Téléphone : </h4><?php the_field('tel_stage'); ?></div>
<h4>Description : </h4>
<div><?php the_field('text_societe_stage'); ?></div>

<br/>
<br/>
<h3>Informations sur le poste</h3>
<div><h4>Intitulé du poste : </h4><?php the_title(); ?></div>
<div><h4>Lieu : </h4><?php the_field('lieu_stage'); ?></div>
<div><h4>Date de début : </h4><?php the_field('debut_stage'); ?></div>
<h4>Description de l'activité : </h4>
<div><?php the_field('activite_stage'); ?></div>
<h4>Profil souhaité : </h4>
<div><?php the_field('profil_stage'); ?></div>
<h4>Date d'expiration de l'offre de stage : </h4>
<div><?php the_field('exp_stage'); ?></div>


<?php endwhile; ?>
