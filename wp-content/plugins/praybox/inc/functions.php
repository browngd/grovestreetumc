<?php
/* PLUGIN FUNCTIONS */
function clean($string){
	return strip_tags(nl2br($string),"<br>");
}

function howManyFlags($req_id){
	global $wpdb;
	$flags=$wpdb->get_results("SELECT id FROM ".$wpdb->prefix."pb_flags WHERE request_id='$req_id'");
	return $wpdb->num_rows;
}
function howManyPrayers($req_id){
	global $wpdb;
	$flags=$wpdb->get_results("SELECT id FROM ".$wpdb->prefix."pb_prayedfor WHERE request_id='$req_id'");
	return $wpdb->num_rows;
}
function isIPBanned($ip){
	global $wpdb;
	$result=count($wpdb->get_results("SELECT id FROM ".$wpdb->prefix."pb_banned_ips WHERE ip_address='$ip'"));
	if($result==0){return "pass";}else{return "fail";}
}
function prePgphOutput($input){
	$reporder=array("\\r\\n","\\n","\\r");
	$badwords=array("fuck","shit","cunt","penis","bastard");

	$step1=str_replace($reporder,"||",$input);
	$step2=str_replace($badwords,"[omitted]",$step1);
	$step3=stripslashes($step2);
	$output=str_replace("||","<br />",$step3);

	return $output;
}
function isRequestActive($authcode){
	global $wpdb;
	$wpdb->get_results("SELECT id FROM ".$wpdb->prefix."pb_requests WHERE authcode='$authcode' AND active='1'");
	if($wpdb->num_rows==0){
		return "no";
	}else{
		return "yes";
	}
}
function rand_chars() {
	for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != 12; $x = rand(0,$z), $s .= $a{$x}, $i++);
	return $s;
}
function isDuplicate($fname,$lname,$email,$title,$ipaddy){
	global $wpdb;
	$result = count($wpdb->get_results("SELECT id FROM ".$wpdb->prefix."pb_requests WHERE first_name='$fname' AND last_name='$lname' AND email='$email' AND title='$title' AND ip_address='$ipaddy'"));
	if($result==0){return "pass";}else{return "fail";}
}

function getRequestList($status){
	//THIS FUNCTION IS FOR PENDING, ACTIVE, CLOSED, OR ARCHIVED PRAYER REQUESTS
	if($status=="pending"){$querycond="WHERE active='0' AND closed='0'";}
	if($status=="active"){$querycond="WHERE active='1'";}
	if($status=="closed"){$querycond="WHERE active='2'";}
	if($status=="archived"){$querycond="WHERE active='3'";}
	
	global $wpdb;
	$requests=$wpdb->get_results("SELECT id,first_name,last_name,email,title,body,ip_address,submitted FROM ".$wpdb->prefix."pb_requests $querycond ORDER BY submitted DESC");
	
	foreach($requests as $req){
		$req_id=$req->id;
		$first_name=stripslashes($req->first_name);
		$last_name=stripslashes($req->last_name);
		$email=$req->email;
		$title=stripslashes($req->title);
		$body=prePgphOutput($req->body);
		$ip=$req->ip_address;
		$submitted=date("m-d-y",$req->submitted);
		$num_prayers=howManyPrayers($req_id);
		
		$output.="<tr class='datarow'><td>$req_id</td><td>$first_name $last_name<br />$email</td><td><strong>$title</strong><br />$body</td><td>$ip</td><td>$submitted</td><td>$num_prayers</td><td align='center'>";

		if($status=="pending"){
			$output.="<form method='post'><input type='hidden' name='action' value='approve_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Approve Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='edit_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Edit Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='remove_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Remove Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='remove_ban' /><input type='hidden' name='pb_ip_address' value='$ip' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Remove and Ban IP' /></form>";
		}
		if($status=="active"){
			//$output.="<form method='post'><input type='hidden' name='action' value='edit_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Edit Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='remove_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Remove Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='close_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Close Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='remove_ban' /><input type='hidden' name='pb_ip_address' value='$ip' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Remove and Ban IP' /></form>";
		}
		if($status=="closed"){
			//$output.="<form method='post'><input type='hidden' name='action' value='archive_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Archive Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='remove_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Remove Request' /></form>";
			$output.="<form method='post'><input type='hidden' name='action' value='reopen_request' /><input type='hidden' name='pb_request_id' value='$req_id' /><input type='submit' class='button-secondary' value='Reopen Request' /></form>";
		}
		
		$output.="</td></tr>";
	}
	return $output;
}

function displayRequests($page,$permalink){
	global $wpdb;
	
	$url_pos=strpos($permalink,"?");
	if($url_pos===false){$varprefix="?";}else{$varprefix="&";}
	
	$link=$permalink.$varprefix;
	
	$flag_thresh=get_option('pb_flag_threshhold');
	if(get_option('pb_timeframe_display')==0){$time_condition="";}else{$timeframe=strtotime("-".get_option('pb_timeframe_display')." days");$time_condition="AND submitted>$timeframe";}
	$listingsperpage=get_option('pb_page_display');
	
	if($listingsperpage!=0){$page_condition="LIMIT ".($page-1)*$listingsperpage.",".$page*$listingsperpage;}
	
	$this_display_qry_from="FROM ".$wpdb->prefix."pb_requests WHERE active='1' $time_condition ORDER BY submitted DESC $page_condition";
	$total_display_qry_from="FROM ".$wpdb->prefix."pb_requests WHERE active='1' $time_condition";
	
	$active_requests=$wpdb->get_results("SELECT id,title,body,submitted $this_display_qry_from");
	$num_requests=count($wpdb->get_results("SELECT id $this_display_qry_from"));
	$total_num_requests=count($wpdb->get_results("SELECT id $total_display_qry_from"));
		
	$req_list_output.="<div id='praybox'>";
	$req_list_output.="<div class='intro'>".get_option('pb_request_list_intro')."<div style='clear:both;'></div></div>";
	
	if($listingsperpage!=0){
		$total_pages=ceil($total_num_requests/$listingsperpage);
		if($total_pages!=1){
		$i=1;
		$req_list_output.="<div class='pagination'>Page: ";
		while($i<=$total_pages){
			if($page==$i){$linkclass=" class='active'";}else{$linkclass="";}
			$req_list_output.=" <a href='$link"."page=$i' $linkclass>$i</a>";
		$i++;
		}
		$req_list_output.="</div>";
		}
	}
	
	$req_list_output.="<table class='praybox'>";
	$req_list_output.="<tr class='pb-titlerow'><td>Request Title</td><td># Prayers</td><td>Submitted On</td><td>&nbsp;</td>";
	
	foreach($active_requests as $a_req){
		$req_id=$a_req->id;
		$title=stripslashes($a_req->title);
		if($a_req->title!=""){$title=stripslashes($a_req->title);}else{$title="<em>Untitled</em>";}
		$body=stripslashes($a_req->body);
		$submitted=date("F j, Y",$a_req->submitted);
		$num_prayers=howManyPrayers($req_id);
		$num_flags=howManyFlags($req_id);
		
		if($flag_thresh!=0){$flag_ratio=$num_flags/$flag_thresh;}else{$flag_ratio=0;}
		
		if($flag_ratio<1){
		$req_list_output.="<tr class='pb-datarow'><td>$title</td><td>$num_prayers</td><td>$submitted</td><td class='input'>";
		$req_list_output.="<a href='$link"."req=$req_id'>View Details</a>";
		$req_list_output.="</td></tr>";
		}
	}
	$req_list_output.="</table>";

	if($listingsperpage!=0){
		$total_pages=ceil($total_num_requests/$listingsperpage);
		if($total_pages!=1){
		$i=1;
		$req_list_output.="<div class='pagination'>Page: ";
		while($i<=$total_pages){
			if($page==$i){$linkclass=" class='active'";}else{$linkclass="";}
			$req_list_output.=" <a href='$link"."page=$i' $linkclass>$i</a>";
		$i++;
		}
		$req_list_output.="</div>";
		}
	}

	$req_list_output.="<div style='clear:both;'></div></div>";

	return $req_list_output;
}

function getManagementUrl($authcode){
	$management_permalink=get_permalink(get_option('pb_management_page'));
	
	$pos=strpos($management_permalink,"?");
	
	if($pos===FALSE){
		$url_char="?";
	}else{	
		$url_char="&";
	}
	
	$management_url=$management_permalink.$url_char."pbid=".$authcode;
	
	return $management_url;

}