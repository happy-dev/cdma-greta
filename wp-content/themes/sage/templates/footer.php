<footer class="content-info">

  <div class="container">
    <?php //dynamic_sidebar('sidebar-footer'); ?>

    <!-- LOGO -->
	    <?php 
		$image = get_field('logo_footer', 'option');
			if( !empty($image) ): 
				$alt = $image['alt'];
				$size = 'thumbnail';
				$thumb = $image['sizes'][ $size ]; ?>

				<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
			<?php endif; ?>

	<!-- COORDONNEES -->
		<div><?php the_field('address_1', 'option'); ?></div>
		<div><?php the_field('address_2', 'option'); ?></div>
		<div><?php the_field('telephone', 'option'); ?></div>

	<!-- LOGOS QUALITE -->
		<?php 
		$image = get_field('logo_qualite_1', 'option');
			if( !empty($image) ): 
				$alt = $image['alt'];
				$size = 'thumbnail';
				$thumb = $image['sizes'][ $size ]; ?>

				<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
			<?php endif; ?>

			<?php 
		$image = get_field('logo_qualite_2', 'option');
			if( !empty($image) ): 
				$alt = $image['alt'];
				$size = 'thumbnail';
				$thumb = $image['sizes'][ $size ]; ?>

				<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
			<?php endif; ?>

	<!-- TEXTE -->
		<div><?php the_field('texte_footer', 'option'); ?></div>

	<!-- LIENS -->
		<?php while ( have_rows('liens_footer', 'option') ) : the_row(); ?>
			<a href="<?php the_sub_field('lien_footer', 'option'); ?>">
			    <?php the_sub_field('texte_lien_footer', 'option'); ?>
			</a>
		<?php endwhile; ?>

  </div>
</footer>
