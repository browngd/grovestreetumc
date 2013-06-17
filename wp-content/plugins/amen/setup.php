<?php

/**************************************
* CREATE OR UPDATE DATABASE AND OPTIONS
**************************************/

function amen_install () {
	global $wpdb;
	global $amen_options;
	$amen_version = get_option( 'amen_version', '' );

	if( $amen_version != AMEN_VERSION || '' == $amen_version ) {
		// SETS AMEN TABLES IN DB
		$request_table = $wpdb->prefix . "amen_requests";
		$prayers_table = $wpdb->prefix . "amen_prayers";
		$sql = "
			CREATE TABLE $request_table (
				id mediumint(11) NOT NULL AUTO_INCREMENT,
				prayer_item longtext NOT NULL,
				prayer_updated longtext NOT NULL,
				urgency TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
				active TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
				privacy TINYINT(1) UNSIGNED DEFAULT 0 NOT NULL,
				approved TINYINT(1) UNSIGNED DEFAULT 1 NOT NULL,
				created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				created_by varchar(255) NOT NULL,
				praying_tag varchar(255) NOT NULL,
				updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
				PRIMARY KEY  id (id)
			);
			CREATE TABLE $prayers_table (
				id mediumint(11) NOT NULL AUTO_INCREMENT,  
				session_id varchar(255) NOT NULL,
				request_id mediumint(11) NOT NULL,
				PRIMARY KEY  id (id),
				UNIQUE KEY prayer_id (request_id, session_id)
			);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		$wpdb->query("ALTER TABLE {$wpdb->prefix}amen_requests CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE {$wpdb->prefix}amen_prayers CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");

		// SETS OPTIONS
		update_option( 'amen_version', AMEN_VERSION );

		if ( ! $amen_options || '2.0.1' == AMEN_VERSION ) {
			$amen_settings = array(
				'privatize_prayers' => TRUE,
				'author_display' => 'displayname',
				'public_user' => 'Public User',
				'submission_title' => 'Submit New Prayer Request',
				'submission_button_text' => 'Submit Request',
				'submission_note' => 'Please note: Public requests require approval.',
				'management_title' => 'Manage Prayer Requests',
				'enable_submit_count' => TRUE,
				'submit_text' => 'Pray Now.',
				'submitted_state_one' => '{count} praying.',
				'submitted_state_two' => 'Amen. You are praying.',
				'submitted_state_three' => 'Amen. You and {count-1} other{s} are praying.',
				'tweet_public_requests' => TRUE,
				'custom_hashtag' => 'Amen',
				'hashtag_in_button' => TRUE,
				'tweet_type' => 'hashtag',
				'moderate_public_requests' => TRUE,
			);
			update_option( 'amen_settings', $amen_settings );
		}
	}
}
register_activation_hook( __FILE__, 'amen_install' );

/**************************************
* CHECKS FOR INSTALL OF UPDATE
**************************************/

function amen_update_check() {
	$amen_version = get_option( 'amen_version', '' );

	if( $amen_version != AMEN_VERSION ) {
		amen_install();
	}
}
add_action( 'plugins_loaded', 'amen_update_check' );

?>