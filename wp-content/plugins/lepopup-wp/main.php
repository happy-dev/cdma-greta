<?php
/*
Plugin Name: LePopup WordPress
Plugin URI: http://bestforwebs.com/lepopup/
Description: Successful LePopup plugin of LeScripts series is now available also in WordPress version! Clear and simple management, easy and reliable handling, this all comfortly in WordPress administration.
Set up sessions, automatic show and close and many more, also upcoming features that will renew and boost your site like no other popup before!
Simple way to be popupped!
Author: Mioo
Author URI: http://bestforwebs.com/
Version: 1.5.0
*/

	$classes = array('sanity', 'lepopup');
	$plugin_path = dirname(__FILE__).'/';

	foreach ($classes as $val) {
		if (class_exists($val) != true) {
			require_once($plugin_path . 'lib/class.' . $val . '.php');
		}
	}

	// Initalize your plugin
	$LePopup = new lepopup();

	// Add an activation hook
	register_activation_hook(__FILE__, array(&$LePopup, 'activate'));

	// Run the plugins initialization method
	add_action('wp_enqueue_scripts', array(&$LePopup, 'initialize'));
	include_once($plugin_path . 'metaboxes/admin-panel.php');

?>