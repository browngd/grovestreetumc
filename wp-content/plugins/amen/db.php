<?php

function amen_create_request($prayer_item, $urgency, $privacy, $praying_tag, $sessionID) {
	global $wpdb;
	global $amen_options;
	global $amen_db_prefix;

	// NB: Using stripslashes_deep because... ugh, don't get me started.
	//
	// I tried. I really tried. But this is an obvious outgrowth of the
	// PHP fractal of bad design [1].
	//
	//  * There's PHP magic quotes, which automagically escapes incoming data.
	//  * On top of that, $wpdb insert, prepare, and other sensible
	//    default database methods that perform escaping.
	//  * On top of that, WordPress 3.0+ does its own magic-quoting. [2]
	//
	//  Gack. What a morass of gack. Give me any other language, please.
	// 
	// 1: http://me.veekun.com/blog/2012/04/09/php-a-fractal-of-bad-design/
	// 2: http://stackoverflow.com/questions/7341942/wpdb-update-or-wpdb-insert-results-in-slashes-being-added-in-front-of-quotes

	is_user_logged_in() ? $current_user_ID = wp_get_current_user()->ID : $current_user_ID = $sessionID;
	if ( current_user_can( 'delete_users' ) ) { $amen_approval = '1'; }
	elseif ( $amen_options['moderate_all_requests'] ) { $amen_approval = '0'; }
	elseif ( $amen_options['moderate_public_requests'] && !is_user_logged_in() ) { $amen_approval = '0'; }
	else { $amen_approval = '1'; }
	$request_table = $amen_db_prefix . "amen_requests";
	$rows_affected = $wpdb->query(
		$wpdb->prepare(
			"INSERT INTO $request_table (prayer_item, urgency, privacy, approved, created_at, created_by, praying_tag, updated_at)
			VALUES (%s, %d, %d, %d, NOW(), %s, %s, NOW())",
			array(
				sanitize_text_field( stripslashes_deep($prayer_item) ),
				$urgency,
				$privacy,
				$amen_approval,
				$current_user_ID,
				$praying_tag
			)
		)
	);
	$amen_ID = $wpdb->get_var( "SELECT MAX(id) FROM $request_table" );
	if ( !$amen_approval && !$amen_options['disable_approval_notification'] ) {
		$amen_email_to = '' != $amen_options['email_approval_notification_to'] ? $amen_options['email_approval_notification_to'] : get_option('admin_email');
		$amen_user = get_userdata( $current_user_ID ) ? get_userdata( $current_user_ID )->user_login . ' (' . get_userdata( $current_user_ID )->display_name . ')' : $amen_options['public_user'];
		$message = sprintf(__('%s: %s'), $amen_user, sanitize_text_field( stripslashes_deep($prayer_item) )) . "\r\n\r\n";
		$message .= sprintf(__('Privacy: %s'), $privacy ? 'Private' : 'Public') . "\r\n";
		$message .= sprintf(__('Urgency: %s'), $urgency ? 'Important' : 'Standard') . "\r\n";
		$message .= sprintf(__('Tagged? %s'), $praying_tag ? 'Yes' : 'No') . "\r\n\r\n";
		$message .= sprintf(__( 'Approve: ' . get_admin_url( NULL, 'admin.php' ) . '?page=amen_manage_requests&amen-action=approve&AmenID=' . $amen_ID )) . "\r\n";
		$message .= sprintf(__( 'Delete: ' . get_admin_url( NULL, 'admin.php' ) . '?page=amen_manage_requests&amen-action=delete&AmenID=' . $amen_ID )) . "\r\n";
		$message .= sprintf(__( 'View: ' . get_admin_url( NULL, 'admin.php' ) . '?page=amen_manage_requests&amen-action=view#AmenID-' . $amen_ID )) . "\r\n";
		wp_mail($amen_email_to, sprintf(__('Amen Request (Approval Pending)') ), $message);
	}
	return $rows_affected;
}

/**************************************
* ADD TO PRAYER COUNT
**************************************/

function amen_add_prayer($requestID, $sessionID) {
	global $wpdb;
	global $amen_db_prefix;
	$prayers_table = $amen_db_prefix . "amen_prayers";
	$rows_affected = $wpdb->query(
		$wpdb->prepare(
			"INSERT INTO $prayers_table	(request_id, session_id)
			VALUES (%d, %s)",
			array(
				$requestID,
				stripslashes_deep( $sessionID )
			)
		)
	);
	return $rows_affected;
}

/**************************************
* GET REQUESTS FOR MANAGEMENT PAGE
**************************************/

function amen_get_manageable_requests($sessionID) {
	global $amen_session;
	is_user_logged_in() ? $user_ID = wp_get_current_user()->ID : $user_ID = $amen_session;
	global $wpdb;
	global $amen_db_prefix;
	
	$request_table = $amen_db_prefix . "amen_requests";
	$prayers_table = $amen_db_prefix . "amen_prayers";
	
	if ( current_user_can('delete_users') ) {
		$requests = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
				FROM $request_table r
				LEFT OUTER JOIN
					(SELECT request_id, count(*) as count
					FROM $prayers_table
					GROUP BY request_id) p
				ON r.id = p.request_id
				LEFT OUTER JOIN
					(SELECT request_id, count(*) as count
					FROM $prayers_table
					WHERE session_id = %s
					GROUP BY request_id) s
				ON r.id = s.request_id
				ORDER BY r.active DESC, r.updated_at DESC",
				array( stripslashes_deep($sessionID) )
			)
		);
	} else {
		$requests = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
				FROM $request_table r
				LEFT OUTER JOIN
					(SELECT request_id, count(*) as count
					FROM $prayers_table
					GROUP BY request_id) p
				ON r.id = p.request_id
				LEFT OUTER JOIN
					(SELECT request_id, count(*) as count
					FROM $prayers_table
					WHERE session_id = %s
					GROUP BY request_id) s
				ON r.id = s.request_id
				WHERE r.created_by='$user_ID'
				ORDER BY r.active DESC, r.updated_at DESC",
				array( stripslashes_deep($sessionID) )
			)
		);
	}
	return $requests;
}

/**************************************
* GET REQUEST FOR UPDATING PRAYER COUNT
**************************************/

function amen_get_request($requestID) {
	global $wpdb;
	global $amen_db_prefix;

	$request_table = $amen_db_prefix . "amen_requests";
	$prayers_table = $amen_db_prefix . "amen_prayers";

	$request = $wpdb->get_row(
		$wpdb->prepare(
			"SELECT r.*, ifnull(p.count, 0) as count
			FROM $request_table r
			LEFT OUTER JOIN
				(SELECT request_id, count(*) as count
				FROM $prayers_table
				WHERE request_id = %d) p
			ON r.id = p.request_id
			WHERE r.id = %d
			LIMIT 1",
			$requestID,
			$requestID
		)
	);
	return $request;
}

/**************************************
* GET REQUESTS FOR DISPLAY THROUGH LIST SHORTCODE
**************************************/

function amen_get_active_requests($sessionID, $the_amen) {
	global $wpdb;
	global $amen_db_prefix;

	$request_table = $amen_db_prefix . "amen_requests";
	$prayers_table = $amen_db_prefix . "amen_prayers";

	if ( is_user_logged_in() ) {
		if ( $the_amen['random'] ) {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY RAND(), r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['noid'] )
				)
			);
		} elseif ( '' != $the_amen['id'] ) {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) != 0
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['id'], $the_amen['noid'] )
				)
			);
		} else {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['noid'] )
				)
			);
		}
	} else {
		if ( $the_amen['random'] ) {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.privacy = 0
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY RAND(), r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['noid'] )
				)
			);
		} elseif ( '' != $the_amen['id'] ) {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.privacy = 0
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) != 0
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['id'], $the_amen['noid'] )
				)
			);
		} else {
			$requests = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT r.*, ifnull(p.count, 0) as count, ifnull(s.count, 0) as praying
					FROM $request_table r
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						GROUP BY request_id) p
					ON r.id = p.request_id
					LEFT OUTER JOIN
						(SELECT request_id, count(*) as count
						FROM $prayers_table
						WHERE session_id = %s
						GROUP BY request_id) s
					ON r.id = s.request_id
					WHERE r.active = 1
					AND r.privacy = 0
					AND r.approved = 1
					AND FIND_IN_SET( r.id, %s ) = 0
					ORDER BY r.active DESC, r.updated_at DESC",
					array( stripslashes_deep($sessionID), $the_amen['noid'] )
				)
			);
		}
	}
	return $requests;
}

/**************************************
* GET REQUESTS FOR MANAGEMENT PAGE
**************************************/

function amen_update_request($requestId, $amen_update) {
	global $wpdb;
	global $amen_db_prefix;
	$request_table = $amen_db_prefix . "amen_requests";
	$nowFormat = date('Y-m-d H:i:s');
	$wpdb->update(
		$request_table,
		array( 
			'prayer_updated' => sanitize_text_field( stripslashes_deep( $amen_update ) ),
			'updated_at' => $nowFormat // Check how to enter date in update!!!! //
		),
		array( 'id' => $requestId ),
		array(
			'%s',
			'%s')
	);
}

function amen_edit_request($requestId, $amen_edit) {
	global $wpdb;
	global $amen_db_prefix;
	global $amen_options;

	if ( current_user_can( 'delete_users' ) ) { $amen_approval = '1'; }
	elseif ( $amen_options['moderate_all_requests'] ) { $amen_approval = '0'; }
	elseif ( $amen_options['moderate_public_requests'] && !is_user_logged_in() ) { $amen_approval = '0'; }
	else { $amen_approval = '1'; }

	$request_table = $amen_db_prefix . "amen_requests";
	$nowFormat = date('Y-m-d H:i:s');

	$amen_old_request = $wpdb->get_var( "SELECT prayer_item FROM $request_table WHERE id=$requestId" );

	$wpdb->update(
		$request_table,
		array( 
			'prayer_item' => sanitize_text_field( stripslashes_deep( $amen_edit ) ),
			'approved' => $amen_approval,
			'updated_at' => $nowFormat // Check how to enter date in update!!!! //
		),
		array( 'id' => $requestId ),
		array(
			'%s',
			'%s')
	);

	$amen_userID = $wpdb->get_var( "SELECT created_by FROM $request_table WHERE id=$requestId" );

	if ( !$amen_approval ) {
		$amen_user = get_userdata( $amen_userID ) ? get_userdata( $amen_userID )->user_login . ' (' . get_userdata( $amen_userID )->display_name . ')' : $amen_options['public_user'];
		$message = sprintf(__('%s:'), $amen_user) . "\r\n\r\n";
		$message .= sprintf(__('Original: %s'), sanitize_text_field( stripslashes_deep($amen_old_request) )) . "\r\n\r\n";
		$message .= sprintf(__('Updated: %s'), sanitize_text_field( stripslashes_deep($amen_edit) )) . "\r\n\r\n";
		$message .= sprintf(__( get_admin_url( NULL, 'admin.php' ) . '?page=amen_manage_requests&amen-action=approve&AmenID=' . $requestId )) . "\r\n";
		@wp_mail(get_option('admin_email'), sprintf(__('Amen Edit (Approval Pending)') ), $message);
	}
}

function amen_privatize_request($requestId) {
	amen_request_set_privacy($requestId, 1);
}

function amen_deprivatize_request($requestId) {
	amen_request_set_privacy($requestId, 0);
}

function amen_request_set_privacy($requestId, $privacyState) {
	global $wpdb;
	global $amen_db_prefix;
	$request_table = $amen_db_prefix . "amen_requests";
	$wpdb->update(
		$request_table,
		array('privacy' => $privacyState ),
		array('id' => $requestId ),
		array('%d'),
		array('%d')
	);
}

function amen_urgentize_request($requestId) {
amen_request_set_urgency($requestId, 1);
}

function amen_deurgentize_request($requestId) {
amen_request_set_urgency($requestId, 0);
}

function amen_request_set_urgency($requestId, $urgentState) {
	global $wpdb;
	global $amen_db_prefix;
	$request_table = $amen_db_prefix . "amen_requests";
	$wpdb->update(
		$request_table,
		array( 'urgency' => $urgentState ),
		array('id' => $requestId ),
		array('%d'),
		array('%d')
	);
}

function amen_activate_request($requestId) {
	amen_request_set_active_state($requestId, 1);
}

function amen_deactivate_request($requestId) {
	amen_request_set_active_state($requestId, 0);
}

function amen_request_set_active_state($requestId, $activeState) {
	global $wpdb;
	global $amen_db_prefix;
	$request_table = $amen_db_prefix . "amen_requests";
	$wpdb->update(
		$request_table,
		array( 'active' => $activeState ),
		array('id' => $requestId ),
		array('%d'),
		array('%d')
	);
}

function amen_approve_request($requestId) {
	amen_request_set_approved_state($requestId, 1);
}

function amen_request_set_approved_state($requestId, $approvedState) {
	global $wpdb;
	global $amen_db_prefix;
	$request_table = $amen_db_prefix . "amen_requests";
	$wpdb->update(
		$request_table,
		array( 'approved' => $approvedState ),
		array('id' => $requestId ),
		array('%d'),
		array('%d')
	);
}

function amen_delete_request($requestId) {
	global $wpdb;
	global $amen_db_prefix;
	
	$request_table = $amen_db_prefix . "amen_requests";
	$prayers_table = $amen_db_prefix . "amen_prayers";
	
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM $prayers_table
			WHERE request_id = %d",
			$requestId
		)
	);
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM $request_table
			WHERE id = %d",
			$requestId
		)
	);
}

?>