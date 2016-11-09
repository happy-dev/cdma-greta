<?php while (have_posts()) : the_post(); ?>

<!-- LE DOMAINE -->
	<!-- VIDEO -->

	<!-- TEXTE -->
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>

<!-- LISTE DOMAINES -->
	<!-- THE QUERY -->
	<?php 
	$args=( array( 	'post_type' => 'domaines' ) );  
	$the_query = new WP_Query( $args ); ?>

	<h2>Domaines de formation</h2>
	<ul>
		<?php while ( $the_query->have_posts()) : $the_query->the_post(); ?>
			<li>
				<a href= <?php the_permalink(); ?> >
					<?php the_title(); ?>
				</a>
			</li>	
		<?php endwhile; ?>
	<?php wp_reset_postdata();?>
	</ul>

<!-- LISTE FORMATIONS -->
	<!-- THE QUERY -->
	<h2>Formations</h2>
	<?php $posts = get_field('formations_dom');
	if( $posts ): ?>
	    <?php foreach( $posts as $post): ?>
	        <?php setup_postdata($post); ?>
	        <div>
	            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	        </div>
	    <?php endforeach; ?>
	    <?php wp_reset_postdata(); ?>
	<?php endif; ?>

<?php endwhile; ?>