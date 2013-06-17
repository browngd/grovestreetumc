<?php
function updateOptionsAlpha(){
	//add missing options
	add_option("pb_admin_moderation","0");
	add_option("pb_timeframe_display","0");
	add_option("pb_page_display","0");
	
	//reconcile old "active" field in requests table
	global $wpdb;
	$wpdb->query("UPDATE ".$wpdb->prefix."pb_requests SET active='2' WHERE closed!='0'");

	//DEACTIVATE PB CRONS
	deactivate_pb_crons();
	//REACTIVATE PB CRONS
	setup_pb_crons();
}