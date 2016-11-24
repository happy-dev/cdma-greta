<?php while (have_posts()) : the_post(); ?>

	<!-- IMAGE / VIDEO -->
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

<?php endwhile; ?>