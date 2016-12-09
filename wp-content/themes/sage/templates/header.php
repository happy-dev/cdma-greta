<?php use Roots\Sage\Extras\Custom_Walker; ?>

<header class="header">
  <!-- LOGO HEADER -->
  <?php $image = get_field('logo_header', 'option');
    if( !empty($image) ): 
      $alt = $image['alt'];
      $size = 'large';
      $thumb = $image['sizes'][ $size ]; ?>

      <a class="brand" href="<?= esc_url(home_url('/')); ?>">
      <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
      </a>
    <?php endif; ?>
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" href="#collapse-nav-primary" aria-expanded="false" aria-controls="collapse-nav-primary">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <nav class="navbar navbar-full primary-navbar collapse" id="collapse-nav-primary">
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location'   => 'primary_navigation',
                     'walker'           => new Custom_Walker]);
      endif;
      ?>
    </nav>
</header>

