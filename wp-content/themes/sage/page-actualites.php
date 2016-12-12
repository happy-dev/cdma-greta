<?php if (have_posts()) : ?>sdfsdfsd
    <?php while (have_posts()) : the_post(); ?> 
		<?php the_title() ?>
		<?php the_content() ?>

			<!-- THE QUERY -->
			<?php 
			$args=( array( 	'post_type' => 'post' ,
							'posts_per_page' => 12  ) );  
			$the_query = new WP_Query( $args ); 
				while ( $the_query->have_posts()) : $the_query->the_post(); ?>
					<div>
			    		<a href=<?php the_permalink(); ?> >
			    			<?php the_post_thumbnail(); ?>
		    			</a>
						<a href= <?php the_permalink(); ?> >
							<?php the_title(); ?>
						</a>
						<?php the_excerpt(); ?>
					</div>	
				<?php endwhile; ?>
			<?php wp_reset_postdata();?>

	<?php endwhile; ?>
<?php endif; ?>