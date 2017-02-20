<?php while (have_posts()) : the_post(); ?>

<div class="stage">
    <article class="presentation presentation-page">
        <div class="container">
            <div class="row row-intro">
                <div class="col-md-3"></div>
                <div class="intro col-md-6 col-sm-12 col-xs-12">
                    <h1><?php the_title(); ?></h1>
                    <div>Publié le <?php the_date(); ?></div>
                    <p>
                        Profil recherché : <?php echo get_field('profil_stage'); ?><br/>
                        Date de début : <?php the_field('debut_stage'); ?><br/>
                        Commune : <?php the_field('commune_stage'); ?><br/>
                    </p>
                    <?php //the_excerpt(); ?>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
        <?php get_template_part('templates/breadcrumb'); ?>
    </article>

    <div class="formation container">
        <div class="formation-detail">
            <div class="row row-offcanvas row-offcanvas-left">
                <aside class="column col-lg-4 col-md-4 sidebar-offcanvas" id="sidebar">
                    <h2>Intitulé du poste</h2>
                    <pre><?php the_title(); ?></pre>
                    <h2>Lieu</h2>
                    <pre><?php the_field('lieu_stage'); ?></pre>
                    <h2>Date de début</h2>
                    <pre><?php the_field('debut_stage'); ?></pre>
                    <h2>Nature</h2>
                    <pre><?php the_field('nature_stage'); ?></pre>
                    <h2>Durée</h2>
                    <pre><?php the_field('duree_stage'); ?></pre>
                    <h2>Commune</h2>
                    <pre><?php the_field('commune_stage'); ?></pre>

                    <h2>Société ou organisme :</h2>
                    <pre><?php the_field('societe_stage'); ?></pre>
                    <h2>Site web : </h2>
                    <pre><a href="<?php the_field('site_stage'); ?>" target="_blank"><?php the_field('site_stage'); ?></a></pre>
                    <h2>Personne à contacter : </h2>
                    <pre><?php the_field('contact_stage'); ?></pre>
                    <h2>Email : </h2>
                    <pre><?php the_field('email_stage'); ?></pre>
                    <h2>Téléphone : </h2>
                    <pre><?php the_field('tel_stage'); ?></pre>
                </aside>
                <section class="content col-lg-8 col-md-8 ">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-more hidden-md-up navbar-toggle navbar-toggle-more" data-toggle="offcanvas">Informations complémentaires</button>

                            <h2>Description de la société</h2>
                            <div><?php the_field('text_societe_stage'); ?></div>

                            <h2>Informations sur le poste</h2>

                            <h3>Description de l'activité</h3>
                            <div><?php the_field('activite_stage'); ?></div>
                            <h3>Profil souhaité : </h3>
                            <div><?php the_field('profil_stage'); ?></div>
                            <h3>Date d'expiration de l'offre de stage : </h3>
                            <div><?php the_field('exp_stage'); ?></div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>
