<?php
class lepopup extends sanity {
	var $version = '2.0';
	var $post;
	function __construct() {
		parent::__construct( __FILE__ );
		$this->editorButton = true;
		$this->url          = rtrim( WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ), 'lib' );
		$this->prefix       = '_lepopup_options_';
		global $post;
		add_action( 'init', array(
			 &$this,
			'create_post_type' 
		) );
		add_action( 'save_post', array(
			 &$this,
			'save_postdata2' 
		) );
		add_action( 'admin_init', array(
			 &$this,
			'lepopup_button' 
		), 12 );
		if ( !is_admin() ) {
			add_action( 'wp_footer', array(
				 &$this,
				'wp_hook' 
			) );
		}
	}
	function activate() {
	}
	function initialize() {
		global $post;
		$this->post_type = $post->post_type;
		if ( !is_admin() ) {
			$current_p = $post->ID;
			wp_register_style( 'LePopupStylesheet', $this->url . 'files/lepopup.css', array(), false, 'screen' );
			wp_register_script( 'LePopupScript', $this->url . 'files/lepopup.min.js', array(
				 'jquery' 
			), '1.3' );
			wp_register_script( 'LePopupInit', $this->url . 'files/lepopup_init.js', array(
				'LePopupScript' 
			), '1.1' );
			wp_enqueue_style( 'LePopupStylesheet' );
			wp_enqueue_script( 'LePopupInit' );
			$data = json_decode( $this->localize(), true );
			wp_localize_script( 'LePopupInit', 'lepopup_data', $data );
		}
	}
	function localize() {
		global $post;
		global $current_user;
		$pre     = $this->prefix;
		$fields  = array(
			'closeOnButton',
			'closeOnEsc',
			'closeOnClick',
			'closeOnContentClick',
			'autoShowDelay',
			'autoCloseDelay',
			'sessionInterval' 
		);
		
		$this_id = ( $this->getCurrent() );
		
		$data    = array();
		
		$temp    = array();
		
		$args    = array(
			'post_type' => 'lepopup',
			'posts_per_page' => -1 
		);
		
		$loop    = new WP_Query( $args );
		
		while ( $loop->have_posts() ):
			$loop->the_post();
			$id = get_the_ID();
			
			$custom = get_post_custom( $id );
			
			if ( is_user_logged_in() && ( $custom[$pre . 'rules'] != null ) && !in_array( ( $current_user->roles[0] ), array_values( $custom[$pre . 'rules'] ) ) ) {
				continue;
			}
			$reg = maybe_unserialize( $custom[$pre . 'register'][0] );
			if ( !is_user_logged_in() && empty( $reg ) ) {
				continue;
			}
			$temp         = array();
			$temp['ele']  = "lepopup-" . $id;
			$temp['skin'] = $temp['ele'];
			foreach ( $fields as $val ) {
				$ser = maybe_unserialize( $custom[$pre . $val][0] );
				if ( $val == 'autoShowDelay' ) {
					$s = ( ( get_post_meta( $id, '_lepopup_options_pages', true ) ) ) ? ( get_post_meta( $id, '_lepopup_options_pages', true ) ) : array();
					if ( is_array( $s ) && !in_array( $this_id, $s ) ) {
						$temp[$val] = false;
						continue;
					}
				}
				
				if ( $val == 'closeOnButton' ) {
					$tt = maybe_unserialize( $custom[$pre . 'closeOnButton_custom'][0] );
					if ( !empty( $tt ) ) {
						$temp[$val] = $custom[$pre . 'closeOnButton_custom'][0];
						continue;
					}
				}
				
				$temp[$val] = ( !is_array( $ser ) ) ? $ser : false;
				
			}
			$data[] = $temp;
		endwhile;
		wp_reset_postdata();
		return json_encode( array(
			 'l10n_print_after' => 'lepopup_data = ' . json_encode( $data ) . ';' 
		) );
	}
	function getCurrent() {
		global $post;
		return ( is_home() ) ? get_option( 'page_for_posts' ) : $post->ID;
	}
	function edit_columns( $columns ) {
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Podcast Title",
			"p30_description" => "Description",
			"p30_length" => "Length",
			"p30_speakers" => "Speakers" 
		);
		return $columns;
	}
	function get_shadow( $ar, $val, $col ) {
		$color = $col . ',' . $col . ',' . $col . ',';
		$str   = '';
		if ( in_array( 'inset', $ar ) )
			$str .= 'inset 0 0 40px rgba(' . $color . $val . ')';
		if ( count( $ar ) == 2 )
			$str .= ', ';
		if ( in_array( 'normal', $ar ) )
			$str .= '0 0 40px rgba(' . $color . $val . ')';
		$v = '-moz-box-shadow: ' . $str . ';';
		$v .= ' -webkit-box-shadow: ' . $str . ';';
		$v .= ' -ms-box-shadow: ' . $str . ';';
		$v .= ' -o-box-shadow: ' . $str . ';';
		$v .= ' box-shadow: ' . $str . ';';
		return $v;
	}
	function get_radius( $px ) {
		$v = '-moz-border-radius: ' . $px . 'px;';
		$v .= ' -webkit-border-radius: ' . $px . 'px;';
		$v .= ' -ms-border-radius: ' . $px . 'px;';
		$v .= ' -o-border-radius: ' . $px . 'px;';
		$v .= ' border-radius: ' . $px . 'px;';
		return $v;
	}
	function wp_hook() {
		$pre          = $this->prefix . 'style_';
		$styles_outer = array(
			"padding" => 'px',
			"border-width" => 'px',
			'width' => 'px',
			'height' => 'px',
			'border-width' => 'px',
			'border-color' => '',
			'border-radius' => 'px',
			'background-color' => '',
			'background-image' => '',
			'background-position-x' => '',
			'background-position-y' => '',
			'box-shadow' => ''
		);
		$data         = array();
		$temp         = array();
		$args         = array(
			'post_type' => 'lepopup',
			'posts_per_page' => -1 
		);
		$loop         = new WP_Query( $args );
		$i            = 0;
		while ( $loop->have_posts() ):
			$loop->the_post();
			$custom = get_post_custom( get_the_ID() );
			echo "<style type='text/css'>";
			echo '#lepopup-wrap > #lepopup-outer.lepopup-' . get_the_ID() . '{';
			foreach ( $styles_outer as $key => $val ) {
				if ( isset( $custom[$pre . $key] ) && (!empty( $custom[$pre . $key][0] ) || strlen($custom[$pre . $key][0]) != 0) ) {
					if ( $key == 'background-image' ) {
						echo $key . ': url("' . $custom[$pre . $key][0] . '");';
					} else if ( $key == 'box-shadow' ) {
						echo $this->get_shadow( $custom[$pre . $key], $custom[$pre . 'box-shadow-alpha'][0], $custom[$pre . 'box-shadow-color'][0] );
					} else if ( $key == 'border-radius' ) {
						echo $this->get_radius( $custom[$pre . $key][0] );
					} else {
						echo $key . ':' . $custom[$pre . $key][0] . $val . ';';
					}
				}
			}
			echo '}
';

			if ( $custom[$pre . 'close-text'][0] ) {
				echo '#lepopup-wrap > #lepopup-outer.lepopup-' . get_the_ID() . ' > #lepopup-footer > #lepopup-close::after{';
				echo 'content: "'.$custom[$pre . 'close-text'][0].'";';
				echo '}';
			}
			echo '</style>';
?>
            
            <div id="lepopup-<?php
			the_ID();
?>" style="display:none;">
                
                   <?php
			the_content();
?>
      
            </div>
<?php
		endwhile;
		wp_reset_postdata();
	}
	function save_postdata2( $post_id ) {
		if ( !wp_is_post_revision( $post_id ) && get_post_type( $post_id ) == 'lepopup' ) {
			$data = isset( $_POST["_lepopup_options_pages"] ) ? $_POST["_lepopup_options_pages"] : array();
			update_post_meta( $post_id, "_lepopup_options_pages", $data );
		}
	}
	function write_postdata() {
		global $post;
		$fields = array(
			 'autoShowDelay' => array(
				 'name' => 'autoShowDelay',
				'description' => 'Show Delay',
				'default' => 500,
				'unit' => 'miliseconds' 
			),
			'autoCloseDelay' => array(
				'name' => 'autoCloseDelay',
				'description' => 'Close Delay',
				'default' => false,
				'unit' => 'miliseconds' 
			),
			'sessionInterval' => array(
				 'name' => 'sessionInterval',
				'description' => 'Session Interval',
				'default' => 0,
				'unit' => 'hours' 
			) 
		);
		$data   = get_post_meta( $post->ID, "lepopup_options", true );
		echo '<p>' . esc_attr( __( 'Settings for automatic show referring to selected pages.' ) ) . '</p>';
		foreach ( $fields as $field ) {
			wp_nonce_field( plugin_basename( __FILE__ ), $field['name'] . '_noncename' );
			echo '<label for="' . $field['name'] . '" style="font-size: 11px;">';
			_e( '<span style="width:120px;display: inline-block;">' . $field['description'] . '</span>', 'myplugin_textdomain' );
			echo '<input type="text" ' . ' id="' . $field['name'] . '" name="lepopup_options[' . $field['name'] . ']" value="' . ( isset( $data[$field['name']] ) ? $data[$field['name']] : $field['default'] ) . '" size="7" />';
			_e( '<em style="display: inline-block;font-size: 11px;color: #7F7F7F; margin-left:5px;">' . $field['unit'] . '</em>', 'myplugin_textdomain' );
			echo '</label> ';
		}
		echo '<p><em style="font-size: 11px;color: #7F7F7F;">' . esc_attr( __( 'Note that 0 is equal to disabled.' ) ) . '</em></p>';
	}
	function write_popupclosingmeta() {
		global $post_type;
		$fields = array(
			 "Uncheck to disable popup closing method." => array(
				 'closeOnButton' => array(
					 'name' => 'closeOnButton',
					'description' => 'Close button',
					'default' => 'false' 
				),
				'closeOnEsc' => array(
					 'name' => 'closeOnEsc',
					'description' => 'Escape',
					'default' => 'false' 
				),
				'closeOnClick' => array(
					 'name' => 'closeOnClick',
					'description' => 'Mouse click outside popup',
					'default' => 'false' 
				) 
			),
			"Other options" => array(
				 'requireLogin' => array(
					 'name' => 'requireLogin',
					'description' => 'Require logged user',
					'default' => '1' 
				),
				'skin' => array(
					 'name' => 'skin',
					'description' => 'Choose Style',
					'default' => '1' 
				) 
			) 
		);
		$data   = get_post_meta( $post->ID, "lepopup_options", true );
		foreach ( $fields as $key => $section ) {
			echo '<p>' . esc_attr( __( $key ) ) . '</p>';
			foreach ( $section as $field ) {
				wp_nonce_field( plugin_basename( __FILE__ ), $field['name'] . '_noncename' );
				echo '<label for="option-' . $field['name'] . '" style="display:block;padding:3px;font-size: 11px;">';
				echo '<input type="checkbox" style="margin-right: 6px;" id="option-' . $field['name'] . '" name="lepopup_options[' . $field['name'] . ']" value="' . $field['default'] . '" ' . ( ( isset( $data[$field['name']] ) && $data[$field['name']] == $field['default'] ) ? 'checked="checked"' : '' ) . ' />';
				_e( '<span style="width:150px;display: inline-block;">' . $field['description'] . '</span>', 'myplugin_textdomain' );
				echo '</label> ';
			}
		}
		echo '<p><em style="font-size: 11px;color: #7F7F7F;">' . esc_attr( __( 'Note that 0 is equal to disabled.' ) ) . '</em></p>';
	}
	function custom_meta( $data ) {
		global $post;
		if ( empty( $data ) )
			$data = array(
				 '' 
			);
?>
    
            <?php
		echo '<p>' . esc_attr( __( 'Choose pages to apply popup automatic show feature.' ) ) . '</p>';
?>
             <?php
		$pages = get_pages( array () );
		$args  = array(
			'post_type' => 'lepopup',
			'posts_per_page' => -1 
		);
		$loop  = new WP_Query( $args );
		$obj =& $loop->get_posts();
		$not_in = array();
		foreach ( $obj as $item ) {
			$temp = get_post_meta( $item->ID, '_lepopup_options_pages', true );
			if ( !empty( $temp ) ) {
				foreach ( $temp as $val ) {
					if ( !in_array( $val, $data ) ) {
						$not_in[] = $val;
					}
				}
			}
		}
		foreach ( $pages as $pagg ) {
			
			echo '<label for="page-' . $pagg->ID . '" style="display:block;padding:3px;font-size: 11px;">';
			echo '<input class="page_check" type="checkbox" style="margin-right: 6px;" id="page-' . $pagg->ID . '" ' . ( ( in_array( $pagg->ID, $not_in ) ) ? 'disabled="disabled"' : '' ) . ' name="_lepopup_options_pages[]" value="' . $pagg->ID . '" ' . ( ( is_array( $data ) && in_array( $pagg->ID, $data ) ) ? 'checked="checked"' : '' ) . ' />';
			_e( '<span style="width:100px;display: inline-block;">' . $pagg->post_title . '</span>', 'myplugin_textdomain' );
			echo '</label> ';
		}
			
			echo '<label for="page-0" style="display:block;padding:3px;margin-top:3px;padding-top:6px;font-size: 11px;border-top:1px solid #e9e9e9;">';
			echo '<input class="page_check" type="checkbox" style="margin-right: 6px;" id="page-0" ' . ( ( in_array( 0, $not_in ) ) ? 'disabled="disabled"' : '' ) . ' name="_lepopup_options_pages[]" value="0" ' . ( ( is_array( $data ) && in_array( 0, $data ) ) ? 'checked="checked"' : '' ) . ' />';
			_e( '<span style="width:100px;display: inline-block;">Front Page</span>', 'myplugin_textdomain' );
			echo '</label> ';
			wp_nonce_field( plugin_basename( __FILE__ ), 'lepopup_pages_wpnonce' );
?>
        <script type="text/javascript">
            jQuery(function ($) {
                function toggleOptionMeta(){
                   //var ele = $("#new-meta-boxes2 .page_check:checked").filter(":disabled");
                   var ele = $("#new-meta-boxes2 .page_check").filter(":checked").not(":disabled");
                   if(ele.length){
                       $("#new-meta-boxes4").slideDown(200);//.find("input").removeAttr("disabled");
                   }else{
                       $("#new-meta-boxes4").slideUp(200);//.find("input").attr("disabled","disabled");
                   }

                    $("#new-meta-boxes2 .page_check").bind("click", function () {
                    toggleOptionMeta();
                });
               
                 }
                  toggleOptionMeta();
            });
           
        </script> 
<?php
		echo '<p><em style="font-size: 11px;color: #7F7F7F;">' . esc_attr( __( 'Note that single page can handle one autoShow popup.' ) ) . '</em></p>';
		wp_reset_postdata();
	}
	function write_postdatashow() {
		global $post;
		$data = get_post_meta( $post->ID, "_lepopup_options_pages", true );
		$this->custom_meta( $data );
	}
	function new_meta_boxes() {
		$new_meta_boxes = array(
			 "animspeed" => array(
				 "name" => "animspeed",
				"std" => "",
				"title" => "Animation speed",
				"description" => "Enter animation speed in ms." 
			) 
		);
		global $post;
		foreach ( $new_meta_boxes as $meta_box ) {
			$meta_box_value = get_post_meta( $post->ID, $meta_box['name'], true );
			if ( $meta_box_value == "" )
				$meta_box_value = $meta_box['std'];
			wp_nonce_field( plugin_basename( __FILE__ ), $meta_box['name'] . '_noncename' );
			echo '<label for="' . $meta_box['name'] . '" style="font-size: 11px;">';
			_e( $meta_box['description'], 'myplugin_textdomain' );
			echo '</label> ';
			echo '<input type="text" id="' . $meta_box['name'] . '" name="lepopup_options[animspeed]" value="' . $meta_box_value . '" size="25" />';
		}
		$this->custom_meta();
	}
	function sortable_columns() {
		return array(
			 'title' => 'title' 
		);
	}
	function fb_add_body_class( $class ) {
		if ( !is_tax() )
			return $class;
		$tax   = get_query_var( 'taxonomy' );
		$term  = $tax . '-' . get_query_var( 'term' );
		$class = array_merge( $classes, array(
			 'taxonomy-archive',
			$tax,
			$term 
		) );
		return $class;
	}
	function create_meta_box() {
		remove_filter( 'mce_buttons', array(
			 &$this,
			'register_button' 
		) );
		remove_filter( 'mce_external_plugins', array(
			 &$this,
			'add_plugin' 
		) );
		if ( function_exists( 'add_meta_box' ) ) {
			add_meta_box( 'new-meta-boxes2', 'Page Show Options', array(
				 &$this,
				'write_postdatashow' 
			), 'lepopup', 'side' );
		}
	}
	function plugin_mce_css( $mce_css ) {
		if ( !empty( $mce_css ) )
			$mce_css .= ',';
		$mce_css .= $this->url . '/files/editor.css';
		return $mce_css;
	}
	function save_postdata( $post_id ) {
		global $post;
		$new_meta_boxes = array(
			 "pages",
			"animspeed" 
		);
		foreach ( $new_meta_boxes as $meta_box ) {
			if ( !wp_verify_nonce( $_POST[$meta_box . '_noncename'], plugin_basename( __FILE__ ) ) ) {
				return $post_id;
			}
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ) )
					return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ) )
					return $post_id;
			}
			$data = $_POST[$meta_box];
			if ( get_post_meta( $post_id, $meta_box ) == "" )
				add_post_meta( $post_id, $meta_box, $data, true );
			elseif ( $data != get_post_meta( $post_id, $meta_box, true ) )
				update_post_meta( $post_id, $meta_box, $data );
			elseif ( $data == "" )
				delete_pospost_meta( $post_id, $meta_box, get_post_meta( $post_id, $meta_box, true ) );
		}
	}
	function lepopup_button() {
		global $post;
		if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
			return;
		}
		if ( get_user_option( 'rich_editing' ) == 'true' ) {
			add_filter( 'mce_external_plugins', array(
				 &$this,
				'add_plugin' 
			) );
			add_filter( 'mce_buttons', array(
				 &$this,
				'register_button' 
			) );
		}
	}
	function register_button( $buttons ) {
		array_push( $buttons, "separator", "lepopup" );
		return $buttons;
	}
	function add_plugin( $plugin_array ) {
		$plugin_array['lepopup'] = $this->url . 'files/editor_plugin.js.php';
		return $plugin_array;
	}
	function create_post_type() {
		register_post_type( 'lepopup', array(
			 'labels' => array(
				 'name' => __( 'LePopup' ),
				'singular_name' => __( 'LePopup' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Create LePopup' ),
				'edit_item' => __( 'Edit LePopup' ),
				'new_item' => __( 'New LePopup' ),
				'all_items' => __( 'All LePopups' ),
				'view_item' => __( 'View LePopup' ),
				'search_items' => __( 'Search LePopups' ),
				'menu_name' => 'LePopup' 
			),
			'capability_type' => 'post',
			'_builtin' => false,
			'_edit_link' => 'post.php?post=%d',
			'rewrite' => array(
				 "slug" => "lepopup" 
			),
			'query_var' => "lepopup",
			'public' => true,
			'show_ui' => true,
			'menu_position' => 100,
			'menu_icon' => $this->url . 'files/mioo.png',
			'has_archive' => true,
			'hierarchical' => true,
			'supports' => array(
				 'title',
				'editor' 
			),
			'register_meta_box_cb' => array(
				 &$this,
				'create_meta_box' 
			) 
		) );
		$data = get_post_custom_values();
	}
}
?>