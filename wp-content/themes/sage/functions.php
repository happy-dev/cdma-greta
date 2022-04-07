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


add_filter( 'redirect_canonical', 'custom_disable_redirect_canonical' );
function custom_disable_redirect_canonical( $redirect_url ) {
    if ( is_paged() && is_singular() ) $redirect_url = false; 
    return $redirect_url; 
}

function cdma_register_query_vars( $vars ) {
  $vars[] = 'domain';
  $vars[] = 'formation';
  return $vars;
}
add_filter( 'query_vars', 'cdma_register_query_vars' );


function cdma_rewrite_rules( $wp_rewrite ) {
  $wp_rewrite->rules = array(
    '^actualite/page/?([0-9]{1,})/?$' => $wp_rewrite->index . '?pagename=actualite&paged=' . $wp_rewrite->preg_index( 1 ),
    '^domaine-offres/([^/]*)/?$' => $wp_rewrite->index .'?pagename=domaine-offres&domain='. $wp_rewrite->preg_index( 1 ),
    '^fiches/([^/]*)/?$' => $wp_rewrite->index .'?pagename=fiches&formation='. $wp_rewrite->preg_index( 1 ),
  ) + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'cdma_rewrite_rules' );


function nullOrEmpty($x) {
  return (!isset($x) || trim($x) === '');
}

function domains_select_list($tag, $unused){ 
  if ( $tag['name'] != 'domaine' )
    return $tag;

  foreach (Dokelio::getDomains() as $domain ) {
    $tag['raw_values'][]  = $domain->domaine_libelle;
    $tag['values'][]      = $domain->domaine_libelle .'+!+'. $domain->referent_domaine;
    $tag['labels'][]      = $domain->domaine_libelle;
  }

  return $tag;
}
add_filter( 'wpcf7_form_tag', 'domains_select_list', 10, 2);

function admin_assets() {
  wp_register_style('cdma_admin_css', get_template_directory_uri() .'/dist/styles/admin.css', false, null);
  wp_enqueue_style('cdma_admin_css', get_template_directory_uri() .'/dist/styles/admin.css', false, null);
}
add_action('admin_enqueue_scripts', 'admin_assets');


function modify_search($wp_query) {
  $wp_query->set('s', get_query_var('s'));// fetch search string
  $wp_query->set('post_type', 'formations');
  $wp_query->set('posts_per_page', 9);
  $wp_query->set('paged', $wp_query->query_vars['paged']);// paging

  // filtrer suivant la bonne taxonomy
  if (isset($_GET['taxonomy'])) {
    switch ($_GET['taxonomy']) {
      case 'formation-diplomantes-cpf':
        $ta = ['formation-diplomante', 'formation-eligible-au-cpf'];
        $op = 'AND';
      break;

      case 'toute-formation':
      break;

      default:
        $ta = $_GET['taxonomy'];
        $op = 'IN';
    }

    if (isset($ta)) {
      $tq = [[
        'taxonomy' => 'type_form',
        'field'    => 'slug',
        'terms'    => $ta,
        'operator' => $op,
      ]];// Tax Query

      $wp_query->set('tax_query', $tq);
    }
  }

  return $wp_query;
}
add_filter('relevanssi_modify_wp_query', 'modify_search');


