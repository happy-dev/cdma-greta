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

add_action( 'init', 'create_stages_tax' );

function create_stages_tax() {
  register_taxonomy(
    'contrat',
    'stages',
    array(
      'label' => __( 'Type de contrat' ),
      'rewrite' => array( 'slug' => 'contrat' ),
      'hierarchical' => true,
    )
  );
}

if( function_exists('acf_add_options_page') ) { 
  acf_add_options_page();
}

// Test if neither null not empty string
function isNotNull($str) {
  return isset($s->SSDateCommentaire) AND $s->SSDateCommentaire != '';
}
