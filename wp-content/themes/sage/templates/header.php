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
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-nav-primary" aria-expanded="false" aria-controls="collapse-nav-primary">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <nav class="navbar navbar-full primary-navbar collapse" id="collapse-nav-primary">
      <?php 
      // FRONT PAGE
      if (is_front_page()) { 
          wp_nav_menu([ 'theme_location'   => 'primary_navigation',
                        'walker'           => new Custom_Walker,
                        'container'        => '']);
      // OTHER PAGES
      } else { 
        wp_nav_menu([   'theme_location' => 'secondary_navigation',
                        'walker' => new Custom_Walker,
                        'container'         => '']);
      } ?>
    </nav>
</header>

<?php // SECONDARY MENU
if (!is_front_page()) { ?>
<div class="secondary-navbar">
    <nav class="navbar container">
        <div class="row">
        <?php wp_nav_menu([
            'theme_location'    => 'secondary_navigation_bis',
            'menu_class'        => 'menu nav navbar-nav col-lg-8 hidden-md-down',
            'walker'            => new Custom_Walker,
            'container'         => '']); ?>
        <?php get_search_form(); ?>
        </div>
    </nav>
</div>
<?php } ?>