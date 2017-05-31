<?php
// Include & setup custom metabox and fields
$lepopup_prefix = '_lepopup_options_'; // start with an underscore to hide fields from custom fields list
add_filter( 'cmb_meta_boxes', 'lepopup_metaboxes' );
function lepopup_metaboxes( $meta_boxes ) {
	global $lepopup_prefix;

	$prefix = $lepopup_prefix;
	$meta_boxes[] = array(
		'id' => 'lepopup_stylebox',
		'title' => 'Custom Styles',
		'pages' => array('lepopup'), // post type
		'context' => 'normal',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Custom styles',
				'type' => 'title',
				'id' => $prefix . 'title_customstyles'
			),
			array(
				'name' => 'Padding',
				'id' => $prefix . 'style_padding',
				'type' => 'select',
				'options' => array(
					array('name' => 'Medium (30px)', 'value' => 30),
					array('name' => 'Small (15px)', 'value' => 15),
					array('name' => 'High (50px)', 'value' => 50),
					array('name' => 'None', 'value' => 0)			
				)
			),
			array(
				'name' => 'Width',
				'desc' => 'px',
				'id' => $prefix . 'style_width',
				'type' => 'text_small'
			),
			array(
				'name' => 'Height',
				'desc' => 'px',
				'id' => $prefix . 'style_height',
				'type' => 'text_small'
			),

			array(
				'desc' => 'Background',
				'type' => 'title',
				'id' => $prefix . 'title_customstyles'
			),
			array(
				'name' => 'Background Color',
				'desc' => 'Choose color',
				'id' => $prefix . 'style_background-color',
				'type' => 'text_small',
				'std' => '#ffffff'
			),
			array(
				'name' => 'Background Image',
				'desc' => 'Insert image',
				'id' => $prefix . 'style_background-image',
				'type' => 'file'
			),
			array(
				'name' => 'Horizontal Position',
				'desc' => '',
				'id' => $prefix . 'style_background-position-x',
				'type' => 'select',
				'options' => array(
					array('name' => 'Left', 'value' => 'left'),
					array('name' => 'Center', 'value' => 'center'),
					array('name' => 'Right', 'value' => 'right')				
				)
			),
			array(
				'name' => 'Vertical Position',
				'desc' => '',
				'id' => $prefix . 'style_background-position-y',
				'type' => 'select',
				'options' => array(
					array('name' => 'Top', 'value' => 'top'),
					array('name' => 'Center', 'value' => 'center'),
					array('name' => 'Bottom', 'value' => 'bottom')				
				)
			),

			array(
				'desc' => 'Border',
				'type' => 'title',
				'id' => $prefix . 'title_customstyles'
			),
			array(
				'name' => 'Border Width',
				'desc' => 'px',
				'id' => $prefix . 'style_border-width',
				'type' => 'text_small',
				'std' => 0
			),
			array(
				'name' => 'Border Color',
				'desc' => 'Choose color',
				'id' => $prefix . 'style_border-color',
				'type' => 'text_small',
				'std' => '#ffffff'
			),
			array(
				'name' => 'Border Radius',
				'desc' => 'px',
				'id' => $prefix . 'style_border-radius',
				'type' => 'text_small',
				'std' => 5
			),

			array(
				'desc' => 'Box Shadow',
				'type' => 'title',
				'id' => $prefix . 'title_customstyles'
			),
			array(
				'name' => 'Box Shadow',
				'desc' => 'Which type of box shadow is visible',
				'id' => $prefix . 'style_box-shadow',
				'std' => 'true',
				'type' => 'multicheck',
				'options' => array(
					'normal' => 'Outside',
					'inset' => 'Inset'
				)
			),
			array(
				'name' => 'Box Shadow Intensity',
				'desc' => 'Choose shadow intensity',
				'id' => $prefix . 'style_box-shadow-alpha',
				'type' => 'select',
				'options' => array(
					array('name' => 'Normal', 'value' => 0.35),
					array('name' => 'Strong', 'value' => 0.80)			
				)
			),
			array(
				'name' => 'Shadow Color',
				'desc' => 'Choose color',
				'id' => $prefix . 'style_box-shadow-color',
				'type' => 'select',
				'options' => array(
					array('name' => 'Black', 'value' => 0),
					array('name' => 'White', 'value' => 255)			
				)
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'new-meta-boxes4',
		'title' => 'Automatic Show Options',
		'pages' => array('lepopup'), // post type
		'context' => 'side',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Show Delay',
				'desc' => '',
				'id' => $prefix . 'autoShowDelay',
				'type' => 'select',
				'options' => array(
					array('name' => 'Normal (0.5s)', 'value' => 500),
					array('name' => 'Late (5s)', 'value' => 5000)			
				)
			),
			array(
				'name' => 'Close Timer',
				'desc' => '',
				'id' => $prefix . 'autoCloseDelay',
				'type' => 'select',
				'options' => array(
					array('name' => 'Disabled', 'value' => 0),
					array('name' => '3s', 'value' => 3000),
					array('name' => '5s', 'value' => 5000),
					array('name' => '10s', 'value' => 10000),
					array('name' => '15s', 'value' => 15000),
					array('name' => '30s', 'value' => 30000),
					array('name' => '60s', 'value' => 60000)		
				)
			),
			array(
				'name' => 'Session Interval',
				'desc' => '',
				'id' => $prefix . 'sessionInterval',
				'type' => 'select',
				'options' => array(
					array('name' => 'Disabled', 'value' => 0),
					array('name' => 'One Time', 'value' => 99999),
					array('name' => 'Once a Hour', 'value' => 1),
					array('name' => 'Once a Day', 'value' => 24),
					array('name' => 'Once a Week', 'value' => 168),
					array('name' => 'Once a Month', 'value' => 672)	
				)
			)
		)
	);

	$meta_boxes[] = array(
		'id' => 'lepopup_metabox2',
		'title' => 'Close Settings',
		'pages' => array('lepopup'), // post type
		'context' => 'side',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Close Button',
				'desc' => 'Show the basic button for closing',
				'id' => $prefix . 'closeOnButton',
				'std' => 'true',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Esc Key',
				'desc' => 'Close using the Escape key',
				'id' => $prefix . 'closeOnEsc',
				'std' => 'true',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Outside click',
				'desc' => 'Mouse click on overlay to close',
				'id' => $prefix . 'closeOnClick',
				'std' => 'true',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Inside click',
				'desc' => 'Mouse click inside popup to close',
				'id' => $prefix . 'closeOnContentClick',
				'type' => 'checkbox'
			),
			array(
				'name' => 'Custom Close Button',
				'desc' => 'Element Selector (eg ".close")',
				'id' => $prefix . 'closeOnButton_custom',
				'type' => 'text_small'
			),
			array(
				'name' => 'Custom Close',
				'desc' => 'Set the button text',
				'id' => $prefix . 'style_close-text',
				'std' => 'Close',
				'type' => 'text_small'
			)
		)
	);

global $wp_roles;
if ( ! isset( $wp_roles ) ) {
    $wp_roles = new WP_Roles();
}
$roles = $wp_roles->get_names();
foreach($roles as $key => $val){
	
}
	$meta_boxes[] = array(
		'id' => 'lepopup_show_rules',
		'title' => 'Showing Rules',
		'pages' => array('lepopup'), // post type
		'context' => 'side',
		'priority' => 'low',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'User Roles',
				'id' => $prefix . 'rules',
				'type' => 'multicheck',
				'std' => 'true',
				'options' => $roles
			),
			array(
				'name' => '',
				'desc' => '<strong style="font-style:normal; color:black;">Guest</strong><p>Show popup for not registered users</p>',
				'id' => $prefix . 'register',
				'std' => 'true',
				'type' => 'checkbox'
			)
		),
		
	);

	
	return $meta_boxes;
}


// Initialize the metabox class
add_action( 'init', 'lepopup_metaboxes_initialize', 9999 );
function lepopup_metaboxes_initialize() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'init.php' );
	}
}