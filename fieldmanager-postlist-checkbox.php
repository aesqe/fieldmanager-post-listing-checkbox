<?php
/*
Plugin Name: Fieldmanager Post Listing Column Checkbox
Plugin URi: https://github.com/aesqe/wordpress-fieldmanager-post-listing-checkbox
Description: Adds toggleable checkboxes to the admin post listing screens programatically.
Version: 0.1.1
Author: Bruno "Aesqe" Babic
Author URI: http://skyphe.org
*/

function fieldmanager_postlist_checkbox_after_setup_theme () {
	if ( defined( 'FM_VERSION' ) ) {
		require_once('class-fieldmanager-postlist-checkbox.php');
	}
}
add_action('after_setup_theme', 'fieldmanager_postlist_checkbox_after_setup_theme');
