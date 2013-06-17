<?php
function display_pb_forms($atts) {
	global $wpdb;


if($_POST['action']=="update_request"){

//UPDATE REQUEST
	$req_id=$_POST['req_id'];
	if($_POST['anon']=='on'){$anon=1;}else{$anon=0;}	
	if($_POST['notify']=='on'){$notify=1;}else{$notify=0;}
	if($_POST['closed']=='on'){
		$closed=time();
		$active=2;
	$wpdb->update($wpdb->prefix.'pb_requests',array('anon'=>$anon,'closed'=>$closed,'notify'=>$notify,'active'=>$active),array('id'=>$req_id));
	}else{
	$wpdb->update($wpdb->prefix.'pb_requests',array('anon'=>$anon,'notify'=>$notify),array('id'=>$req_id));
	}

	
	if(!isset($closed)){
		$updated_request_output="<div id='praybox'>";
		$updated_request_output.="<div class='title'>Your Prayer Request Has Been Updated<div style='clear:both;'></div></div>";
		$updated_request_output.="<div class='intro'>Any changes that you have made to your prayer request have been updated.<div style='clear:both;'></div></div>";
		$updated_request_output.="<div style='clear:both;'></div></div>";	
	}else{
		$updated_request_output="<div id='praybox'>";
		$updated_request_output.="<div class='title'>Your Prayer Request Has Been Closed<div style='clear:both;'></div></div>";
		$updated_request_output.="<div class='intro'>You will no longer have access to edit this prayer request.<div style='clear:both;'></div></div>";
		$updated_request_output.="<div style='clear:both;'></div></div>";	
	}

return $updated_request_output;

}elseif($_POST['action']=="submit_request"){
//Submit Request to DB, Email Mgmt Link, and Display a Message
	if($_POST['first_name']!=""){$first_name=clean($_POST['first_name']);}else{$first_name="anon";}
	if($_POST['last_name']!=""){$last_name=clean($_POST['last_name']);}else{$last_name="anon";}
	if($_POST['anon']=='on'){$anon=1;}else{$anon=0;}	
	$email=$_POST['email'];	
	$authcode=rand_chars();
	$title=clean($_POST['title']);	
	$body=clean($_POST['body']);	
	if($_POST['notify']=='on'){$notify=1;}else{$notify=0;}
	$ip_address=$_SERVER['REMOTE_ADDR'];
	$time_now=time();
	if(get_option('pb_admin_moderation')==1){$active=0;}else{$active=1;}

	//THROW FLAGS IF ANY OF THESE CONDITIONS ARE MET
	if((isIPBanned($ip_address)=="fail")||(isDuplicate($first_name,$last_name,$email,$title,$ip_address)=="fail")){$flaggit=1;}else{$flaggit=0;}

	//IF NO FLAGS, RUN IT
	if($flaggit==0){
		$wpdb->insert($wpdb->prefix.'pb_requests',array('first_name'=>$first_name,'last_name'=>$last_name,'anon'=>$anon,'email'=>$email,'authcode'=>$authcode,'submitted'=>$time_now,'title'=>$title,'body'=>$body,'notify'=>$notify,'ip_address'=>$ip_address,'active'=>$active));
		
		$management_url=getManagementUrl($authcode);
		
	   	$email_from=get_option('pb_reply_to_email');
	   	$email_subject="Prayer Request Posted";
	   	$email_message=get_option('pb_email_prefix');
	   	$email_message.="\n\nYour prayer request has been posted. If you would like to edit your prayer request or submit a praise report for an answered prayer, click here: $management_url\n\nIf you have indicated that you would like to receive notifications, you will receive an email at the end of each day that your prayer request is lifted up to the Lord letting you know how many times you were prayed for that day.\n\n";
	   	$email_message.=get_option('pb_email_suffix');
		$headers .= 'Reply-To:'.$site_name.' <'.$email_from.'>'."\r\n";
		$headers.= 'From:'.$site_name.' <'.$email_from.'>'."\r\n";
	   	
	   	wp_mail($email,$email_subject,$email_message,$headers);

		$submitted_output="<div id='praybox'>";
		$submitted_output.="<div class='title'>Your Prayer Request Has Been Submitted<div style='clear:both;'></div></div>";
		$submitted_output.="<div class='intro'>You will be receiving an email shortly that contains a link that will allow you to update your prayer request. If you have indicated that you would like to be notified when you are prayed for, you will receive an email once a day letting you know how many times your prayer request has been lifted up.<div style='clear:both;'></div></div>";
		$submitted_output.="<div style='clear:both;'></div></div>";

	}else{

		$submitted_output="<div id='praybox'>";
		$submitted_output.="<div class='title'>Prayer Request Not Submitted<div style='clear:both;'></div></div>";
		$submitted_output.="<div class='intro'>Your prayer request submission has failed for the following reason(s):<ul>";
		if(isDuplicate($first_name,$last_name,$email,$title,$ip_address)=="fail"){
		$submitted_output.="<li>You have submitted an identical request and it is already listed.</li>";
		}
		if($_POST['required']!=""){
		$submitted_output.="<li>You seem to be a spam bot.</li>";
		}
		if(isIPBanned($ip_address)=="fail"){
		$submitted_output.="<li>You are banned from using this resource.</li>";
		}
		$submitted_output.="</ul><div style='clear:both;'></div></div>";
		$submitted_output.="<div style='clear:both;'></div></div>";

	}
		

return $submitted_output;

}else{

if($_GET['pbid']==""){

//INITIAL SUBMISSION FORM OUTPUT

	$sub_form_output="<div id='praybox'>";
	$sub_form_output.="<div class='title'>Submit Your Prayer Request<div style='clear:both;'></div></div>";
	$sub_form_output.="<div class='intro'>".get_option('pb_request_form_intro')."<div style='clear:both;'></div></div>";
	$sub_form_output.="<form method='post'><input type='hidden' name='action' value='submit_request' />";
	$sub_form_output.="<table class='subform'>";
	$sub_form_output.="<tr><td class='label'>First Name:</td><td class='input'><input type='text' name='first_name' /></td></tr>";
	$sub_form_output.="<tr><td class='label'>Last Name:</td><td class='input'><input type='text' name='last_name' /></td></tr>";
	$sub_form_output.="<tr><td class='label'>&nbsp;</td><td class='checkbox'><input type='checkbox' name='anon' /> I would like to remain anonymous. Please do not post my name.</td></tr>";
	$sub_form_output.="<tr><td class='label'>Email Address:</td><td class='input'><input type='text' name='email' /></td></tr>";
	$sub_form_output.="<tr><td class='label'>Prayer Request Title:</td><td class='input'><input type='text' name='title' /></td></tr>";
	$sub_form_output.="<tr><td class='label'>Prayer Request:</td><td class='input'><textarea name='body'></textarea></td></tr>";
	$sub_form_output.="<tr><td class='label'>&nbsp;</td><td class='checkbox'><input type='checkbox' name='notify' /> I would like to be notified (once per day) when I have been prayed for.</td></tr>";
	$sub_form_output.="<tr><td class='submit' colspan='2'><input type='submit' value='Submit My Prayer Request' /></td></tr>";
	$sub_form_output.="</table>";
	$sub_form_output.="</form>";
	$sub_form_output.="<div style='clear:both;'></div></div>";

return $sub_form_output;

}else{
	$authcode=$_GET['pbid'];
	
	if (isRequestActive($authcode)=="yes"){
		//IF REQUEST IS OPEN
		$prayer_request=$wpdb->get_row("SELECT id,first_name,last_name,anon,email,title,body,notify FROM ".$wpdb->prefix."pb_requests WHERE authcode='$authcode'");
		$req_id=$prayer_request->id;
		if($prayer_request->anon==1){$anon="checked";}else{$anon="";}
		if($prayer_request->notify==1){$notify="checked";}else{$notify="";}
		
		$mgmt_form_output="<div id='praybox'>";
		$mgmt_form_output.="<div class='title'>Make Changes to Your Prayer Request<div style='clear:both;'></div></div>";
		$mgmt_form_output.="<div class='intro'>Use the form below to make changes to your prayer request listing.<div style='clear:both;'></div></div>";
		$mgmt_form_output.="<form method='post'><input type='hidden' name='action' value='update_request' /><input type='hidden' name='req_id' value='$req_id' />";
		$mgmt_form_output.="<table class='subform'>";
		$mgmt_form_output.="<tr><td class='checkbox'><input type='checkbox' name='anon' $anon /> I would like to remain anonymous. Please do not post my name.</td></tr>";
		$mgmt_form_output.="<tr><td class='checkbox'><input type='checkbox' name='notify' $notify /> I would like to be notified (once per day) when I have been prayed for.</td></tr>";
		$mgmt_form_output.="<tr><td><hr /></td></tr>";
		$mgmt_form_output.="<tr><td class='checkbox'><input type='checkbox' name='closed' /> I would like to close this prayer request.</td></tr>";
		$mgmt_form_output.="<tr><td class='submit'><input type='submit' value='Update My Prayer Request' /></td></tr>";
		$mgmt_form_output.="</table>";
		$mgmt_form_output.="</form>";
		$mgmt_form_output.="<div style='clear:both;'></div></div>";
	}else{
		//IF REQUEST IS CLOSED
		$mgmt_form_output="<div id='praybox'>";
		$mgmt_form_output.="<div class='title'>This Request Has Been Closed<div style='clear:both;'></div></div>";
		$mgmt_form_output.="<div class='intro'>Sorry, this Prayer Request has been closed and can no longer be edited.<div style='clear:both;'></div></div>";
		$mgmt_form_output.="<div style='clear:both;'></div></div>";
	}

return $mgmt_form_output;

	
}

}
}
