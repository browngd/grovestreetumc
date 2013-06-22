<?php
/*
Plugin Name: Facebook AWD App Requests
Plugin URI: http://facebook-awd.ahwebdev.fr/plugins/app-requests/
Description: This plugin will help you to create special facebook app requests. Allow your users to invite their friends
Version: 1.3
Author: AHWEBDEV
Author URI: http://facebook-awd.ahwebdev.fr
License: Copywrite AHWEBDEV
Text Domain: AWD_facebook_app_requests
Last modification: 18/03/2012
*/

/**
 *
 * @author alexhermann
 *
 */
add_action('plugins_loaded', 'initial_app_request');
function initial_app_request()
{
	global $AWD_facebook;
	if(is_object($AWD_facebook)){
		$model_path = $AWD_facebook->get_plugins_model_path();
		require_once($model_path);
		require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_app_requests.php');
		$AWD_facebook_app_requests = new AWD_facebook_app_requests(__FILE__,$AWD_facebook,array('connect' => 1));
	}
}
?>