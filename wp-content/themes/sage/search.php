<?php get_search_form(); ?>

<?php if (!have_posts()) { ?>
  <div class="alert alert-warning">
    <?php _e('Aucun résultat ne correspond à la recherche', 'sage'); ?>
  </div>
<?php 
} 
else { ?>
	<h1>Formations pour "<?php the_search_query(); ?>"</h1>
	<?php 
		while (have_posts()) : the_post(); 
			if ( 'formations' == get_post_type() ) { 
				get_template_part('templates/content', 'search');
			}
			elseif ( 'post' == get_post_type()){
			}
			else {
					echo 'Aucune formation ne correspond à la recherche';
				}
		endwhile; 
	?>

	<h1>Actualités pour "<?php the_search_query(); ?>"</h1>
	<?php 
		while (have_posts()) : the_post(); 
			if ( 'post' == get_post_type() ) { 
				get_template_part('templates/content', 'search');
			}
			elseif ( 'formations' == get_post_type()){
			}
			else {
					echo 'Aucune actualité ne correspond à la recherche';
			}
		endwhile; 
} ?>

<?php the_posts_navigation(); ?>
