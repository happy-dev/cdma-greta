<?php while (have_posts()) : the_post(); ?>
	
<h1><?php the_title(); ?></h1>
<?php the_field('commune_stage'); ?>
<div><?php the_field('nature_stage'); ?></div>
<div>Date de début : <?php the_field('debut_stage'); ?></div>
<div>Profil recherché : <?php the_field('profil_stage'); ?></div>
<div>Personne à contacter : <?php the_field('contact_stage'); ?></div>
<div>Email : <?php the_field('email_stage'); ?></div>
<div><?php the_excerpt(); ?></div>					

<?php endwhile; ?>