<?php
/**
* Plugin Name: 			Watsonfinds
* Plugin URI: 			www.watsonfinds.com
* Description: 			Improve the impact of your content by combining the power of artificial intelligence and scientific investigations of human behavior.
* Version: 2.0.0
* Author: Watsonfinds
* License: GPLv2
* Text Domain: watsonfinds
* Domain Path: /lang
*/

if (is_admin())
{
	require_once(dirname(__FILE__) . '/admin/index.php');
}

register_activation_hook( __FILE__, 'activate_watsonfinds' );
register_deactivation_hook( __FILE__, 'deactivate_watsonfinds' );		



function activate_watsonfinds() {
	require_once(dirname(__FILE__) . '/admin/includes/watsonfinds_class.php');
	Watsonfinds::activate();
}



function deactivate_watsonfinds() {
	require_once(dirname(__FILE__) . '/admin/includes/watsonfinds_class.php');
	Watsonfinds::deactivate();
}