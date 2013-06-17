<?php
if($_POST['action']=="edit_request"){
	$req_id=$_POST['pb_request_id'];
	$request=$wpdb->get_row("SELECT first_name,last_name,email,title,body,ip_address,submitted FROM ".$wpdb->prefix."pb_requests WHERE id='$req_id'");
	$first_name=stripslashes($request->first_name);
	$last_name=stripslashes($request->last_name);
	$email=$request->email;
	$title=stripslashes($request->title);
	$body=stripslashes($request->body);
	
?>	
<form method="post" action="">
		<input type="hidden" name="action" value="edit_request_exec" />
		<input type="hidden" name="pb_request_id" value="<?php echo $req_id; ?>" />

    <table class="form-table">
        <tr valign="top">
        <th scope="row">First Name</th>
        <td><input type="text" name="first_name" value="<?php echo $first_name; ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Last Name</th>
        <td><input type="text" name="last_name" value="<?php echo $last_name; ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Email Address</th>
        <td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Request Title</th>
        <td><input type="text" name="title" value="<?php echo $title; ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Request Body</th>
        <td><textarea name="body"><?php echo $body; ?></textarea></td>
        </tr>

    </table>
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
<?php }