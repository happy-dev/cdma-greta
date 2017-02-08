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
      //if (is_front_page()) { 
          wp_nav_menu(['theme_location'   => 'primary_navigation',
                       'walker'           => new Custom_Walker]);
      // OTHER PAGES
      //} else { 
      //wp_nav_menu(array('theme_location' => 'secondary_navigation', 'menu_class' => 'nav'));
      //} ?>
    </nav>
</header>

<?php // SECONDARY MENU

if (!is_front_page()) { ?>
<div class="secondary-navbar">
    <nav class="navbar container">
          <?php //wp_nav_menu(array('theme_location' => 'secondary_navigation_bis', 'menu_class' => 'nav')); ?>
        <div class="row">
            <ul class="nav navbar-nav col-lg-8 hidden-md-down">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="formations-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Formations</a>
                    <div class="dropdown-menu" aria-labelledby="formations-dropdown">
                        
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Certifications et VAE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Financez votre formation</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="entreprise-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entreprise</a>
                    <div class="dropdown-menu" aria-labelledby="entreprise-dropdown">  
                    </div>
                </li>
            </ul>
            <?php get_search_form(); ?>
      </div>
    </nav>
</div>
<?php } ?>