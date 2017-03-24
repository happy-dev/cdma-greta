<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);


// CUSTOM TAXONOMY

add_action( 'init', 'create_formations_tax' );

function create_formations_tax() {
  register_taxonomy(
    'domaine',
    'formations',
    array(
      'label' => __( 'Domaine' ),
      'rewrite' => array( 'slug' => 'domaine' ),
      'hierarchical' => true,
    )
  );
}

add_action( 'init', 'create_types_form_tax' );

function create_types_form_tax() {
  register_taxonomy(
    'type_form',
    'formations',
    array(
      'label' => __( 'Type de formation' ),
      'rewrite' => array( 'slug' => 'type_form' ),
      'hierarchical' => true,
    )
  );
}

//manage column custom post type for taxonomies
add_filter( 'manage_taxonomies_for_formations_columns', 'domaine_columns' );
function domaine_columns( $taxonomies ) {
    $taxonomies[] = 'domaine';
    return $taxonomies;
}

// OPTIONS

if( function_exists('acf_add_options_page') ) { 
  acf_add_options_page();
}

// Test if neither null not empty string
function isNotNull($str) {
  return isset($s->SSDateCommentaire) AND $s->SSDateCommentaire != '';
}

function remove_menus(){
  
  //remove_menu_page( 'edit.php?post_type=acf-field-group' ); 

}
add_action( 'admin_menu', 'remove_menus' );


// Enhanced search to enable taxonomy filtering
add_action('pre_get_posts', 'search_by_tax'); 
function search_by_tax() {     
  global $wp_query;

  // Some search filter selected
  if (is_search()) {
      $wp_query->query_vars["taxonomy"] 	= null;
      $wp_query->query_vars['post_type']      	= 'formations';
      $wp_query->query_vars['posts_per_page'] 	= 9;

      if (isset($_GET['taxonomy'])) {
        switch ($_GET['taxonomy']) {
          case 'formation-diplomantes-cpf':
            $ta = ['formation-diplomante', 'formation-eligible-au-cpf'];
            break;

          case 'toute-formation':
            break;

          default:
            $ta = $_GET['taxonomy'];
        }

        if (isset($ta)) {
          $tq = [[
            'taxonomy' => 'type_form',
            'field'    => 'slug',
            'terms'    => $ta,
          ]];// Tax Query

          $wp_query->query_vars['tax_query'] = $tq;   
        }
      }
  }
}

add_filter( 'redirect_canonical', 'custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url ) {
    if ( is_paged() && is_singular() ) $redirect_url = false; 
    return $redirect_url; 
}

// Builds a dropdown list based on Formations CPT
function domains_select_list($tag, $unused){ 
    if ( $tag['name'] != 'domaine' )
        return $tag;

    $args = array (
        'numberposts'   => -1,
        'post_type'     => 'domaines',
        'orderby'       => 'title',
        'order'         => 'ASC',
    );

    $domains = get_posts($args);

    if ( ! $domains ) {
        return $tag;
    } 

    foreach ( $domains as $domain ) {
        $tag['raw_values'][]  = $domain->post_title;
        $tag['values'][]      = $domain->post_title .'+!+'. get_field('coordo_email', $domain->ID);
        $tag['labels'][]      = $domain->post_title;
    }

    return $tag;
}
add_filter( 'wpcf7_form_tag', 'domains_select_list', 10, 2);


function custom_rewrite_rules( $wp_rewrite ) {
  $wp_rewrite->rules = array(
    'actualite/page/?([0-9]{1,})/?$' => $wp_rewrite->index . '?pagename=actualite&paged=' . $wp_rewrite->preg_index( 1 ),
 
  ) + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'custom_rewrite_rules' );
