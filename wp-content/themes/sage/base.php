<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Extras\Custom_Walker;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <div class="container-fluid" role="document">
        <div class="row row-offcanvas-menu row-offcanvas-left-menu row-offcanvas-mobile">
            <div class="sidecontent">
                <?php
                  do_action('get_header');
                  get_template_part('templates/header');
                ?>
                    <main>
                      <?php include Wrapper\template_path(); ?>
                    </main><!-- /.main -->
                    <?php if (Setup\display_sidebar()) : ?>
                      <aside class="sidebar">
                        <?php include Wrapper\sidebar_path(); ?>
                      </aside><!-- /.sidebar -->
                    <?php endif; ?>
                <?php
                  do_action('get_footer');
                  get_template_part('templates/footer');
                  wp_footer();
                ?>
            </div>
            <aside class="sidebar-offcanvas-menu hidden-lg-up" id="sidebar-mobile">
                <div class="container-fluid">
                <?php wp_nav_menu([ 'theme_location'   => 'primary_navigation',
                                    'walker'           => new Custom_Walker,
                                    'container'        => '']); ?>
                </div>
                <ul class="menu">
                    <li class="dropdown">
			<a href="/actualite">Actualités</a>
		    </li>
		</ul>
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
                  			'orderby' 	=> 'date',
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
            </aside>
          </div>
      </div>
  </body>
</html>
