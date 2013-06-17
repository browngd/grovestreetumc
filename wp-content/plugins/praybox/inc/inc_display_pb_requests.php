<?php
function display_pb_requests($atts) {
	global $wpdb;
	global $post;
	
	$page_id=$post->ID;
	$permalink=get_permalink($page_id);
	
if((isset($_GET['req']))&&(is_numeric($_GET['req']))){

//VIEW DETAILS OUTPUT
	$req_id=$_GET['req'];
	$prayer_request=$wpdb->get_row("SELECT first_name,last_name,anon,title,body FROM ".$wpdb->prefix."pb_requests WHERE id='$req_id'");
	$first_name=stripslashes($prayer_request->first_name);
	$last_name=stripslashes($prayer_request->last_name);
	$anon=$prayer_request->anon;
	if($prayer_request->title!=""){$title=stripslashes($prayer_request->title);}else{$title="<em>Untitled</em>";}
	$body=prePgphOutput($prayer_request->body);
	if($anon!=1){$display_name=$first_name." ".$last_name;}else{$display_name="<em>Anonymous</em>";}
	
	$view_details_output="<div id='praybox'>";
	$view_details_output.="<div class='back'><a href='$permalink'><< Back to Request List</a><div style='clear:both;'></div></div>";
	$view_details_output.="<div class='title'>$title<div style='clear:both;'></div></div>";
	$view_details_output.="<table class='details'>";
	$view_details_output.="<tr><td class='label'>Submitted By:</td><td class='content'>$display_name";
	$view_details_output.="<form class='flag' method='post' action='$permalink'><input type='hidden' name='action' value='flag_this_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' value='Report Abuse' /></form>";
	$view_details_output.="</td></tr>";
	$view_details_output.="<tr><td class='label'>Prayer Request:</td><td class='content'>$body</td></tr>";
	$view_details_output.="<tr><td class='response' colspan='2'>";
	$view_details_output.="<form method='post' action='$permalink'><input type='hidden' name='action' value='prayed_for' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' value='I Prayed For You' /></form>";
	$view_details_output.="</td></tr>";
	$view_details_output.="</table>";
	$view_details_output.="<div style='clear:both;'></div></div>";

return $view_details_output;

}elseif($_POST['action']=="flag_this_request"){

//PRAYED FOR INSERT SCRIPT AND CONTENT
	$req_id=$_POST['pb_request_id'];
	$time_now=time();
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$wpdb->insert($wpdb->prefix.'pb_flags',array('request_id'=>$req_id,'flagged_date'=>$time_now,'ip_address'=>$ip_address));

	if(isIPBanned($ip_address)=="pass"){
		$flag_action_output="<div id='praybox'>";
		$flag_action_output.="<div class='back'><a href='$permalink'><< Back to Request List</a><div style='clear:both;'></div></div>";
		$flag_action_output.="<div class='thankyou'>Thank you for reporting inappropriate content.<div style='clear:both;'></div></div>";
		$flag_action_output.="<div style='clear:both;'></div></div>";
	}else{
		$flag_action_output="<div id='praybox'>";
		$flag_action_output.="<div class='back'><a href='$permalink'><< Back to Request List</a><div style='clear:both;'></div></div>";
		$flag_action_output.="<div class='thankyou'>Sorry, you're not allowed to do that.<div style='clear:both;'></div></div>";
		$flag_action_output.="<div style='clear:both;'></div></div>";
	}
	
return $flag_action_output;

}elseif($_POST['action']=="prayed_for"){

//PRAYED FOR INSERT SCRIPT AND CONTENT
	$req_id=$_POST['pb_request_id'];
	$time_now=time();
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$wpdb->insert($wpdb->prefix.'pb_prayedfor',array('request_id'=>$req_id,'prayedfor_date'=>$time_now,'ip_address'=>$ip_address));
		
	$view_details_output="<div id='praybox'>";
	$view_details_output.="<div class='back'><a href='$permalink'><< Back to Request List</a><div style='clear:both;'></div></div>";
	$view_details_output.="<div class='thankyou'>Thank you for lifting up this request in prayer.<div style='clear:both;'></div></div>";
	$view_details_output.="<div style='clear:both;'></div></div>";

return $view_details_output;

}else{

//REQUEST LIST OUTPUT CONTENT
	if(isset($_GET['page'])){$page=$_GET['page'];}else{$page=1;}
	
	return displayRequests($page,$permalink);
	
}
}
