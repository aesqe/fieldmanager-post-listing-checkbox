<?php
/*
Plugin Name: Fieldmanager Post Listing Column Checkbox
Description: Adds toggleable checkboxes to the admin post listing screens programatically.
Version: 0.1
Author: Bruno "Aesqe" Babic
Author URI: http://skyphe.org
*/

function fieldmanager_postlist_checkbox_init ()
{
	require_once('class-fieldmanager-postlist-checkbox.php');
}
add_action('init', 'fieldmanager_postlist_checkbox_init');