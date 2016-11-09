<?php while (have_posts()) : the_post(); ?>

<!-- OPENING IMAGE/VIDEO -->

<h2>Formations à la une</h2>
<a href="">Voir toutes les formations</a>

<div class="row">
	<!-- THE QUERY -->
	<?php $posts = get_field('formations_une');
		if( $posts ): ?>
		    <?php foreach( $posts as $post): ?>
		        <?php setup_postdata($post); ?>
			        <div>
			            <a href="<?php the_permalink(); ?>">
			            	<?php the_title(); ?>
			            </a>
			            <?php //the_excerpt(); ?>
			        </div>
		    <?php endforeach; ?>
		    <?php wp_reset_postdata(); ?>
		<?php endif; ?>
</div><!-- row end -->

<h2>Le Greta CDMA</h2>
<?php the_content(); ?>

<h2>Actualités</h2>
<a href="/actualites">Voir toute l'actualité</a>

<div class="row">
	<!-- THE QUERY -->
	<?php 
	$args=( array( 	'post_type' => 'post' ,
					'category_name'  => 'a-la-une',
					'posts_per_page' => 6  ) );  
	$the_query = new WP_Query( $args ); 
		while ( $the_query->have_posts()) : $the_query->the_post(); ?>
			<div>
				<a href= <?php the_permalink(); ?> >
					<?php the_title(); ?>
				</a>
				<?php //the_excerpt(); ?>
			</div>	
		<?php endwhile; ?>
	<?php wp_reset_postdata();?>
</div><!-- row end -->

<h2>Lieux de formation</h2>



<?php endwhile; ?>