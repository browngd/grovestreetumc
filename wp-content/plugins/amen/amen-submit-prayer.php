<?php

/**
* @package Amen
*/

require_once dirname( __FILE__ ) . '/db.php';

function include_amen_css() {
	wp_register_style('amencss', plugins_url('amen.css',__FILE__ ));
	wp_enqueue_style('amencss');
}
add_action( 'init', 'include_amen_css' );

global $amen_session;
$amen_session = NULL;

function amen_cookies() {
	global $amen_session;

	if ( isset($_COOKIE["wp_amen_session"]) ) {
		$amen_session = $_COOKIE["wp_amen_session"];
	}
	if ( empty($amen_session) ) {
		$amen_session = uniqid($_SERVER['REMOTE_ADDR'] . '-', true);
	}
	// expire in 20 years
	setcookie( "wp_amen_session", $amen_session, time() + 631138519, '/', COOKIE_DOMAIN );
}
add_action( 'init', 'amen_cookies' );
add_action( 'wp_ajax_pray', 'pray_submit' );
add_action( 'wp_ajax_nopriv_pray', 'pray_submit' );
add_action( 'wp_head', 'cssjs' );

function cssjs() {
	wp_register_script( 'amen.js', AMEN_PLUGIN_URL . 'amen.js', array('jquery'), AMEN_VERSION );
	wp_enqueue_script( 'amen.js' );
	wp_localize_script( 'amen.js', 'Amen', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}

function pray_submit() {
	global $amen_session;

	// get the submitted parameters
	$requestID = intval($_POST['requestID']);
	$the_amen = array(
		'submit' => $_POST['amen-submit'],
		'state1' => $_POST['amen-state1'],
		'state2' => $_POST['amen-state2'],
		'state3' => $_POST['amen-state3']
		);

	// insert it
	amen_add_prayer($requestID, $amen_session);

	$prayerRequest = amen_get_request($requestID);

	// generate the response
	$response = json_encode( array( 'success' => true, 'contents' => count_contents($prayerRequest->count, TRUE, $the_amen) ) );

	// response output
	header( "Content-Type: application/json" );
	echo $response;

	// IMPORTANT: don't forget to "exit"
	exit;
}

?>