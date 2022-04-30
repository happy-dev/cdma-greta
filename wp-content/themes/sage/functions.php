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
  $vars[] = 'index';
  return $vars;
}
add_filter( 'query_vars', 'cdma_register_query_vars' );


function cdma_rewrite_rules( $wp_rewrite ) {
  $wp_rewrite->rules = array(
    '^actualite/page/?([0-9]{1,})/?$' => $wp_rewrite->index . '?pagename=actualite&paged=' . $wp_rewrite->preg_index( 1 ),
    '^domaine-offres/([^/]*?)/?([0-9]*?)/?$' => $wp_rewrite->index .'?pagename=domaine-offres&domain='. $wp_rewrite->preg_index( 1 ) .'&index='. $wp_rewrite->preg_index(2),
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
    $tag['raw_values'][]  = $domain->lib_domaine;
    $tag['values'][]      = $domain->lib_domaine .'+!+'. $domain->referent_domaine;
    $tag['labels'][]      = $domain->lib_domaine;
  }

  return $tag;
}
add_filter( 'wpcf7_form_tag', 'domains_select_list', 10, 2);

function admin_assets() {
  wp_register_style('cdma_admin_css', get_template_directory_uri() .'/dist/styles/admin.css', false, null);
  wp_enqueue_style('cdma_admin_css', get_template_directory_uri() .'/dist/styles/admin.css', false, null);
}
add_action('admin_enqueue_scripts', 'admin_assets');
