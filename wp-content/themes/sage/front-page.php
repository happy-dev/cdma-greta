<?php while (have_posts()) : the_post(); ?>

<!-- OPENING IMAGE/VIDEO -->

<?php the_field('titre_slider'); ?>

<?php if ( have_rows('slider_home') ): ?>
	<div class="main-carousel js-flickity" data-flickity-options='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
		<?php while ( have_rows('slider_home') ) : the_row(); ?>
     		<?php
			$imageArray = get_sub_field('slides_home');
			$image = $imageArray['url']; ?>
			<div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); background-size:cover; padding-top:40%; width:100%">
			</div>
		<?php endwhile; ?>
	</div>
<?php endif ?>

<?php if ( get_field('video_home') ): 
the_field('video_home');
endif ?>

<!-- FORMATIONS -->

<h2>Formations à la une</h2>
<a href="">Voir toutes les formations</a>

<div class="row">
	<!-- THE QUERY -->
	<?php $posts = get_field('formations_une');
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

			            <a href="<?php the_permalink(); ?>">
			            	<?php the_title(); ?>
			            </a>
			            <?php //the_excerpt(); ?>
			        </div>
		    <?php endforeach; ?>
		    <?php wp_reset_postdata(); ?>
		<?php endif; ?>
</div><!-- row end -->

<!-- PREZ GRETA -->

<h2><?php the_field('prez_titre'); ?></h2>
<?php the_field('prez_texte'); ?>
<?php the_field('prez_video'); ?>

<!-- ACTUALITES -->

<h2>Actualités</h2>
<a href="/actualites">Voir toute l'actualité</a>

<div class="row">
	<!-- THE QUERY -->
	<?php 
	$args=( array( 	'post_type' => 'post' ,
					'category_name'  => 'a-la-une',
					'posts_per_page' => 3  ) );  
	$the_query = new WP_Query( $args ); 
		while ( $the_query->have_posts()) : $the_query->the_post(); ?>
			<div>
				<?php the_post_thumbnail('thumbnail'); ?>
				<a href= <?php the_permalink(); ?> >
					<?php the_title(); ?>
				</a>
				<?php //the_excerpt(); ?>
			</div>	
		<?php endwhile; ?>
	<?php wp_reset_postdata();?>
</div><!-- row end -->


<!-- LIEUX DE FORMATION -->

<h2>Lieux de formation</h2>

<?php if ( have_rows('lieux_formation') ): ?>
	<div class="main-carousel js-flickity" data-flickity-options='{ "autoPlay": false, "pauseAutoPlayOnHover": false, "wrapAround": true }'>
		<?php while ( have_rows('lieux_formation') ) : the_row(); ?>
     		<?php
			$imageArray = get_sub_field('logos_lieux');
			$image = $imageArray['url']; ?>
			<div class="carousel-cell" style="background-image:url(<?php echo $image; ?>); width: 50px; height:50px;">
			</div>
		<?php endwhile; ?>
	</div>
<?php endif ?>

<?php endwhile; ?>