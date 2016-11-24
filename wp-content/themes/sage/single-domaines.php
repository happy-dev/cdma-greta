<?php while (have_posts()) : the_post(); ?>

<!-- LE DOMAINE -->
	<!-- IMAGE/VIDEO -->
	<?php $image = get_field('post_image');
					if( !empty($image) ): 
						$url = $image['url'];
						$title = $image['title'];
						$alt = $image['alt'];
						$size = 'thumbnail';
						$thumb = $image['sizes'][ $size ]; ?>
							<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
					<?php endif; ?>

	<!-- TEXTE -->
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>

<!-- LISTE DOMAINES -->
	<!-- THE QUERY -->
	<?php 
	$args=( array( 	'post_type' => 'domaines', 'orderby' => 'title', 'order' => 'ASC' ) );  
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
	        	<?php $image = get_field('post_image');
					if( !empty($image) ): 

						$url = $image['url'];
						$title = $image['title'];
						$alt = $image['alt'];
						$size = 'thumbnail';
						$thumb = $image['sizes'][ $size ]; ?>

						<a href="<?php echo $url; ?>" title="<?php echo $title; ?>">
							<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
						</a>
					<?php endif; ?>
	            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	        </div>
	    <?php endforeach; ?>
	    <?php wp_reset_postdata(); ?>
	<?php endif; ?>

<?php endwhile; ?>