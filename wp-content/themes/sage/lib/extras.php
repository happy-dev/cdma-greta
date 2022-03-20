<?php
namespace Roots\Sage\Extras;

require_once(__DIR__ .'/../Dokelio/Dokelio.php');

use Roots\Sage\Setup;
use Dokelio;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  //return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

use Walker_Nav_Menu;

class Custom_Walker extends Walker_Nav_Menu {

    private $_rand = 0; 

    function __construct() {
      $this->_rand = rand();
    }

    function start_lvl( &$output, $depth = 0, $args = array() ) {
      $atts = array();
      $atts['aria-labelledby']    = 'dropdown-'.$this->parent_item->ID . $this->_rand;
      $atts['class']              = 'dropdown-menu';
      $attributes = '';

        foreach ( $atts as $attr => $value ) {
      	  if ( ! empty( $value ) ) {
      	    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
      	    $attributes .= ' ' . $attr . '="' . $value . '"';
      	  }
      	}
      
      $output .= "<div $attributes>";
      $output .= "<span class='decoration'></span>";
      $output .= "<div class=\"row\">";

      if ('Formations' == $args->walker->parent_item->title) {// Hack to hide "Formation" first submenu
        $output .= "<ul class=\"col-md-3 display-none\">";
      }
      else {
        $output .= "<ul class=\"col-md-3 boom\">";
      }
      
      $this->children_cpt = 0;
      $this->children_total = 0;
    }

    function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
        $this->parent_item = $item;
        if ($depth > 0) {
            if ($this->children_cpt > 4) {
                $this->children_cpt = 0;
                $output .= '<ul class="col-md-3">';
            }
        }
        
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if ($args->walker->has_children /* $depth > 0 */) {
            $output .= $indent . '<li class="dropdown">';
        } else {
            $output .= $indent . '<li>';
        }

        $atts = array();
		$atts['title']            = ! empty( $item->attr_title ) ? $item->attr_title : '';
    
        if ($args->walker->has_children) {
            $atts['id']         = 'dropdown-'. $item->ID . $this->_rand;
            $atts['class']            = 'dropdown-toggle';
            $atts['data-toggle']      = 'dropdown';
            $atts['aria-haspopup']    = 'true';
            $atts['aria-expanded']    = 'false';
        } else {
            if (in_array('current-menu-item', $item->classes) ){
                $atts['class']        = 'active';
            }
            $atts['target']           = ! empty( $item->target )     ? $item->target     : '';
            $atts['rel']              = ! empty( $item->xfn )        ? $item->xfn        : '';
        }
        
		$atts['href']             = ! empty( $item->url )             ? $item->url             : '';
		
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );
        
        $attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        
        $item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
        
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>";

        if ($depth > 0) {
            $this->children_total++;

            if ($this->children_total >= $item->_parent_children_count) {
                //$output .= "</ul></div>\n";
            } else if ($this->children_cpt >= 4) {
                $output .= '</ul>';
            }

            $this->children_cpt++;
        }
    }
    
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
	if ('Dokelio' == $args->walker->parent_item->title) {// Hack to customize "Formations" submenus
          $domains = Dokelio::getDomains();
	  $columns_count = ceil(count($domains)/4);// Compute the items per column in the menu

	  foreach(Dokelio::getDomains() as $idx => $domain) {
            if ($idx%$columns_count==0) {// Enforce the number of items per column in the menu
              $output .= '</ul><ul class="col-md-3">';
            }
	    $output .= '<li><a href="/domaine-offres/'. Dokelio::toSlug($domain) .'">'. $domain .'</a></li>';
	  }
	}

        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div></div>\n";
    }
}
