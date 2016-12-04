<?php while (have_posts()) : the_post(); ?>

	
<h1><?php the_title(); ?></h1>
<h2><?php the_field('nature_stage'); ?> / <?php the_field('duree_stage'); ?></h2>
<div><?php the_field('commune_stage'); ?></div>
<div>Publié le <?php the_date(); ?></div>

<br/>
<br/>
<h3>Informations sur la société</h3>
<h4>Société ou organisme : <?php the_field('societe_stage'); ?></h4>
<div>Site web : 
	<a href="<?php the_field('site_stage'); ?>" target="_blank">
		<?php the_field('site_stage'); ?>
	</a>
</div>
<h4>Personne à contacter : <?php the_field('contact_stage'); ?></h4>
<div>Email : <?php the_field('email_stage'); ?></div>
<div>Téléphone : <?php the_field('tel_stage'); ?></div>
<div>Description : <?php the_field('text_societe_stage'); ?></div>

<br/>
<br/>
<h3>Informations sur le poste</h3>
<h4>Intitulé du poste : <?php the_title(); ?></h4>
<div>Lieu : <?php the_field('lieu_stage'); ?></div>
<h4>Date de début : <?php the_field('debut_stage'); ?></h4>
<h4>Description de l'activité : </h4>
<div><?php the_field('activite_stage'); ?></div>
<h4>Profil souhaité : </h4>
<div><?php the_field('profil_stage'); ?></div>
					

<?php endwhile; ?>