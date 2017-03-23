<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Menu 1 (Primary Navigation)', 'sage'),
    'secondary_navigation' => __('Menu 2', 'sage'),
    'secondary_navigation_bis' => __('Menu 2bis', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));

// CUSTOM POST TYPES

  register_post_type( 'domaines',

          array(

              'labels' => array(
              'name' => __( 'Domaines de formation' ),
              'singular_name' => __( 'Domaine de formation' ),
              'add_new' => __( 'Add New Domaine' ),
              'add_new_item' => __( 'Add New Domaine' ),
              'edit_item' => __( 'Edit Domaine' ),
              'new_item' => __( 'Add New Domaine' ),
              'view_item' => __( 'View Domaine' ),
              'search_items' => __( 'Search Domaine' ),
              'not_found' => __( 'No Domaine found' ),
              'not_found_in_trash' => __( 'No Domaine found in trash' )
              ),

              'public'      => true,
              'supports'      => array( 'title','editor','revisions'),
              'capability_type'   => 'post',
              'menu_position'   => 4,
              'hierarchical'    => true,
              'menu_icon'   => 'dashicons-art'
          )
   );
        
  register_post_type( 'formations',

          array(

              'labels' => array(
              'name' => __( 'Formations' ),
              'singular_name' => __( 'Formation' ),
              'add_new' => __( 'Add New Formation' ),
              'add_new_item' => __( 'Add New Formation' ),
              'edit_item' => __( 'Edit Formation' ),
              'new_item' => __( 'Add New Formation' ),
              'view_item' => __( 'View Formation' ),
              'search_items' => __( 'Search Formation' ),
              'not_found' => __( 'No Formation found' ),
              'not_found_in_trash' => __( 'No Formation found in trash' )
              ),

              'public'      => true,
              'supports'      => array( 'title','editor','revisions'),
              'capability_type'   => 'post',
              'menu_position'   => 5,
              'hierarchical'    => true,
              'menu_icon'   => 'dashicons-welcome-learn-more'
          )
   );

  register_post_type( 'stages',

          array(

              'labels' => array(
              'name' => __( 'Offres de stage' ),
              'singular_name' => __( 'Offre de stage' ),
              'add_new' => __( 'Add New Offre de stage' ),
              'add_new_item' => __( 'Add New Offre de stage' ),
              'edit_item' => __( 'Edit Offre de stage' ),
              'new_item' => __( 'Add New Offre de stage' ),
              'view_item' => __( 'View Offre de stage' ),
              'search_items' => __( 'Search Offre de stage' ),
              'not_found' => __( 'No Offre de stage found' ),
              'not_found_in_trash' => __( 'No Offre de stage found in trash' )
              ),

              'public'      => true,
              'supports'      => array( 'title','editor','revisions'),
              'capability_type'   => 'post',
              'menu_position'   => 6,
              'hierarchical'    => true,
              'menu_icon'   => 'dashicons-businessman'
          )
   );

  register_post_type( 'temoignages',

          array(

              'labels' => array(
              'name' => __( 'Témoignages' ),
              'singular_name' => __( 'Témoignage' ),
              'add_new' => __( 'Add New Témoignage' ),
              'add_new_item' => __( 'Add New Témoignage' ),
              'edit_item' => __( 'Edit Témoignage' ),
              'new_item' => __( 'Add New Témoignage' ),
              'view_item' => __( 'View Témoignage' ),
              'search_items' => __( 'Search Témoignage' ),
              'not_found' => __( 'No Témoignage found' ),
              'not_found_in_trash' => __( 'No Témoignage found in trash' )
              ),

              'public'      => true,
              'supports'      => array( 'title','editor','revisions'),
              'capability_type'   => 'post',
              'menu_position'   => 7,
              'hierarchical'    => true,
              'menu_icon'   => 'dashicons-format-chat'
          )
   );
  
}

add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);
  wp_enqueue_style('sage/css', Assets\asset_path('styles/flickity.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


/**
 * Nav Menu Counts
 */
add_filter('wp_nav_menu_objects', function($sorted_menu_objects) {
    foreach($sorted_menu_objects as &$item) {
        $item->_children_count = 0;
        for($i=1, $l=count($sorted_menu_objects); $i<=$l; ++$i) {
            if($sorted_menu_objects[$i]->menu_item_parent == $item->ID) {
                $item->_children_count++;
            }
        }        
    }
    foreach($sorted_menu_objects as &$item) {
        $item->_parent_children_count = 0;
        for($i=1, $l=count($sorted_menu_objects); $i<=$l; ++$i) {
            if($item->menu_item_parent == $sorted_menu_objects[$i]->ID) {
                $item->_parent_children_count = $sorted_menu_objects[$i]->_children_count;
                break;                    
            }
        }
    }
    unset($item);
    return $sorted_menu_objects;    
});

add_image_size( 'news', 500, 282, true ); // 500 pixels wide by 282 pixels tall, hard crop mode
add_image_size( 'single_f', 600, 407, true ); // 600 pixels wide by 407 pixels tall, hard crop mode
add_image_size( 'tem', 160, 160, true ); // 160 pixels wide by 160 pixels tall, hard crop mode


add_filter('next_posts_link_attributes', function($output) {
    return 'class="btn btn-next"';
});
add_filter('previous_posts_link_attributes', function($output) {
    return 'class="btn btn-previous"';
});
