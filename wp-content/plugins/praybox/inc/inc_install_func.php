<?php
//DATABASE TABLE CREATION FUNCTIONS

global $gd_pb_db_version;
$gd_pb_db_version = "1.0";

function gd_pb_db_install() {
   global $wpdb;
   global $gd_pb_db_version;
   
   $date_now=time();

   $table_name = $wpdb->prefix."pb_requests";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") !=$table_name) {
      
      $sql = "CREATE TABLE " .$table_name. " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  first_name VARCHAR(64) NOT NULL,
	  last_name VARCHAR(64) NOT NULL,
	  anon tinyint(1) NOT NULL,
	  email VARCHAR(64) NOT NULL,
	  authcode VARCHAR(12) NOT NULL,
	  submitted bigint(11) DEFAULT '0' NOT NULL,
	  closed bigint(11) DEFAULT '0' NOT NULL,
	  closed_comment text NOT NULL,
	  title VARCHAR(64) NOT NULL,
	  body text NOT NULL,
	  notify tinyint(1) DEFAULT '1' NOT NULL,
	  ip_address VARCHAR(15) NOT NULL,
	  active tinyint(1) DEFAULT '1' NOT NULL,
	  UNIQUE KEY id (id)
	);";

      	$wpdb->query($sql); 
		$wpdb->insert($wpdb->prefix.'pb_requests',array('first_name'=>'John','last_name'=>'Doe','anon'=>1,'email'=>'test@test.com','authcode'=>'000000','submitted'=>$date_now,'closed'=>1,'title'=>'Please Pray For Me','body'=>'Please pray for me.','notify'=>0,'ip_address'=>'0.0.0.0','active'=>1));
   }

   $table_name = $wpdb->prefix."pb_prayedfor";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
      
      $sql = "CREATE TABLE ".$table_name." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  request_id mediumint(9) DEFAULT '0' NOT NULL,
	  prayedfor_date bigint(11) DEFAULT '0' NOT NULL,
	  ip_address VARCHAR(15) NOT NULL,
	  UNIQUE KEY id (id)
	);";

      	$wpdb->query($sql);
      	$wpdb->insert($wpdb->prefix.'pb_prayedfor',array('request_id'=>1,'prayedfor_date'=>$date_now,'ip_address'=>'0.0.0.0'));
   }

   $table_name = $wpdb->prefix."pb_flags";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
      
      $sql = "CREATE TABLE ".$table_name." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  request_id mediumint(9) NOT NULL,
	  ip_address VARCHAR(15) NOT NULL,
	  flagged_date bigint(11) DEFAULT '0' NOT NULL,
	  UNIQUE KEY id (id)
	);";

      	$wpdb->query($sql);
      	$wpdb->insert($wpdb->prefix.'pb_flags',array('request_id'=>1,'ip_address'=>'0.0.0.0','date'=>$date_now));
   }

   $table_name = $wpdb->prefix."pb_banned_ips";
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name) {
      
      $sql = "CREATE TABLE ".$table_name." (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  ip_address VARCHAR(15) NOT NULL,
	  banned_date bigint(11) DEFAULT '0' NOT NULL,
	  reason VARCHAR(64) NOT NULL,
	  UNIQUE KEY id (id)
	);";

		$wpdb->query($sql);
		$wpdb->insert($wpdb->prefix.'pb_banned_ips',array('ip_address'=>'0.0.0.0','date'=>$date_now,'reason'=>'an example of a banned ip listing'));
 
      add_option("gd_pb_db_version",$gd_pb_db_version);
   }
   
   add_option("pb_flag_threshhold","3");
   add_option("pb_request_form_intro","Fill out the form below with details about your prayer request.");
   add_option("pb_request_list_intro","When you pray for one of the requests below, be sure to click on the I prayed for you button so that we can let the requestor know how many times their request has been lifted up.");
   add_option("pb_management_page","1");
   add_option("pb_email_subject","You Have Been Prayed For");
   add_option("pb_reply_to_email","no-reply@mydomain.com");
   add_option("pb_email_prefix","Greetings,");
   add_option("pb_email_suffix","God Bless,The Staff");
   //add_option("pb_send_notify_checkbox","0");
   add_option("pb_send_notify_hours","0");
   add_option("pb_send_notify_email","test@email.com");
   add_option("pb_admin_moderation","0");
   add_option("pb_timeframe_display","0");
   add_option("pb_page_display","0");
}