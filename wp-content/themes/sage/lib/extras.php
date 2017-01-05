<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

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

    function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
  
        $atts = array();
        $atts['aria-labelledby']    = 'dropdown-'.$this->parent_item->ID;
        $atts['class']              = 'dropdown-menu';
        
        $attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        
        $output .= "\n$indent<div $attributes>\n";
        $output .= "\n$indent<span class='decoration'></span>\n";
        $output .= "\n$indent<div class=\"row\">\n";
		$output .= "\n$indent<ul class=\"col-md-4\">\n";
        
        $this->children_cpt = 0;
        $this->children_total = 0;
	}

    function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
        $this->parent_item = $item;
        if ($depth > 0) {
            if ($this->children_cpt > 5) {
                $this->children_cpt = 0;
                $output .= '<ul class="col-md-4">';
            }
        }
        
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if ($depth > 0) {
            $output .= $indent . '<li class="dropdown">';
        } else {
            $output .= $indent . '<li>';
        }

        $atts = array();
		$atts['title']            = ! empty( $item->attr_title ) ? $item->attr_title : '';
    
        if ($args->walker->has_children) {
          //  $href = 'dropdown'. $item->ID;
            $atts['id']         = 'dropdown-'. $item->ID;
            $atts['class']            = 'dropdown-toggle';
            $atts['data-toggle']      = 'dropdown';
            $atts['aria-haspopup']    = 'true';
            $atts['aria-expanded']    = 'false';
        } else {
            //$href = $item->url;
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
        $output .= "</li>\n";
        
        if ($depth > 0) {
            $this->children_total++;

            if ($this->children_total >= $item->_parent_children_count) {
                //$output .= "</ul></div>\n";
            } else if ($this->children_cpt >= 5) {
                $output .= '</ul>';
            }

            $this->children_cpt++;
        }
    }
    
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        if ($this->children_cpt < 5 || $this->children_total >= $item->_parent_children_count) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul></div></div>\n";
        }
    }
}
