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
      <div id="en-dropdown" class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAHzSURBVHjaYkxOP8IAB//+Mfz7w8Dwi4HhP5CcJb/n/7evb16/APL/gRFQDiAAw3JuAgAIBEDQ/iswEERjGzBQLEru97ll0g0+3HvqMn1SpqlqGsZMsZsIe0SICA5gt5a/AGIEarCPtFh+6N/ffwxA9OvP/7//QYwff/6fZahmePeB4dNHhi+fGb59Y4zyvHHmCEAAAW3YDzQYaJJ93a+vX79aVf58//69fvEPlpIfnz59+vDhw7t37968efP3b/SXL59OnjwIEEAsDP+YgY53b2b89++/awvLn98MDi2cVxl+/vl6mituCtBghi9f/v/48e/XL86krj9XzwEEEENy8g6gu22rfn78+NGs5Ofr16+ZC58+fvyYwX8rxOxXr169fPny+fPn1//93bJlBUAAsQADZMEBxj9/GBxb2P/9+S/R8u3vzxuyaX8ZHv3j8/YGms3w8ycQARmi2eE37t4ACCDGR4/uSkrKAS35B3TT////wADOgLOBIaXIyjBlwxKAAGKRXjCB0SOEaeu+/y9fMnz4AHQxCP348R/o+l+//sMZQBNLEvif3AcIIMZbty7Ly6t9ZmXl+fXj/38GoHH/UcGfP79//BBiYHjy9+8/oUkNAAHEwt1V/vI/KBY/QSISFqM/GBg+MzB8A6PfYC5EFiDAABqgW776MP0rAAAAAElFTkSuQmCC" title="English" alt="English"> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
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
