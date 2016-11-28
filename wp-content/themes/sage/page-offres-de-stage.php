<h1><?php the_title() ?></h1>

<!-- THE QUERY -->
	<?php 
	$args=( array( 	'post_type' => 'stages' ,
					'posts_per_page' => 12  ) );  
	$the_query = new WP_Query( $args ); 
		while ( $the_query->have_posts()) : $the_query->the_post(); ?>
			<div>
				<a href= <?php the_permalink(); ?> >
					<?php the_title(); ?>
				</a>
				<?php the_field('commune_stage'); ?>
				<div><?php the_field('nature_stage'); ?></div>
				<div>Date de début : <?php the_field('debut_stage'); ?></div>
				<div>Profil recherché : <?php the_field('profil_stage'); ?></div>
				<div>Personne à contacter : <?php the_field('contact_stage'); ?></div>
				<div>Email : <?php the_field('email_stage'); ?></div>
				<div><?php the_excerpt(); ?></div>
			</div>	
		<?php endwhile; ?>
	<?php wp_reset_postdata();?>