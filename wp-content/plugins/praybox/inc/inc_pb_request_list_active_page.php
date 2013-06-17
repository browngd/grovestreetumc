<?php
function pb_request_list_active_page() {
global $wpdb;
?>

<div class="wrap">
<h2 class="logo-title">PrayBox Active Prayer Request List</h2>

<?php include("edit_request_form.php"); ?>

<?php
if($_POST['action']=="edit_request_exec"){
	$req_id=$_POST['pb_request_id'];
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$email=$_POST['email'];
	$title=$_POST['title'];
	$body=$_POST['body'];
	$wpdb->update($wpdb->prefix.'pb_requests',array('first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'title'=>$title,'body'=>$body),array('id'=>$req_id));
?>
<p><strong><?php _e('Request Successfully Edited.','menu-test'); ?></strong></p>
<?php } ?>

<?php
if($_POST['action']=="remove_request"){
	$req_id=$_POST['pb_request_id'];
	$wpdb->query("DELETE FROM ".$wpdb->prefix."pb_requests WHERE id='$req_id'");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."pb_flags WHERE request_id='$req_id'");
?>
<p><strong><?php _e('Request Removed.','menu-test'); ?></strong></p>
<?php } ?>

<?php
if($_POST['action']=="close_request"){
	$req_id=$_POST['pb_request_id'];
	$time_now=time();
	$wpdb->update($wpdb->prefix.'pb_requests',array('closed'=>$time_now,'closed_comment'=>'closed by administrator.','active'=>2),array('id'=>$req_id));
?>
<p><strong><?php _e('Request Closed.','menu-test'); ?></strong></p>
<?php } ?>

<?php
if($_POST['action']=="remove_ban"){
	$req_id=$_POST['pb_request_id'];
	$ip=$_POST['pb_ip_address'];
	$time_now=time();
	$wpdb->query("DELETE FROM ".$wpdb->prefix."pb_requests WHERE id='$req_id'");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."pb_flags WHERE request_id='$req_id'");
	$wpdb->insert($wpdb->prefix.'pb_banned_ips',array('ip_address'=>$ip,'banned_date'=>$time_now,'reason'=>'request flagged as inappropriate'))
?>
<p><strong><?php _e('Request Removed and IP Address Banned.','menu-test'); ?></strong></p>
<?php } ?>

<h3>Active Prayer Requests</h3>

<table class="gdadmin">
<tr class="headrow"><td>ID</td><td>First/Last/Email</td><td width="250">Prayer Request</td><td>IP</td><td>Posted</td><td># Prayers</td><td>&nbsp;</td></tr>

<?php
echo getRequestList('active');
?>
</table>
</div>
<?php }