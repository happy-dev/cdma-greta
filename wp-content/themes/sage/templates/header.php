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
    <button type="button" class="navbar-toggle collapsed" data-toggle="offcanvasmobile">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <nav class="navbar navbar-full primary-navbar collapse hidden-md-down">
      <div id="en-dropdown">
        <ul class="menu">
            <li class="dropdown">
                <a id="dropdown-language" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">EN</a>
                <div  aria-labelledby="dropdown-language" class="dropdown-menu">
                    <span class='decoration'></span>
                    <div class="row">
                        <ul class="col-md-4">
                            <?php
                              $args = array(
                                'post_type' 	=> 'page',
                                'meta_key'  	=> 'english',
                                'meta_value'  	=> true,
                              );
                              $en_query = new WP_Query( $args );
                              while ( $en_query->have_posts()) {
                                $en_query->the_post(); 
                                echo '<li>';	
                                echo   '<a href="'. get_the_permalink() .'">';	
                                echo     get_the_title();
                                echo   '</a>';	
                                echo '</li>';	
                              }
                            ?>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
      </div>

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
