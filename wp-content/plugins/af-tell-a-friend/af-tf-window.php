<?php	
$af_tf_plugin_path = dirname(__FILE__);
$af_tf_plugin_path_lin = str_replace('wp-content/plugins/af-tell-a-friend', '', $af_tf_plugin_path);
$af_tf_plugin_wp_cf = str_replace('wp-content\plugins\af-tell-a-friend', '', $af_tf_plugin_path_lin);

require_once($af_tf_plugin_wp_cf  .'wp-config.php');
		
$var_af_tf_closingvariable=0;

//==options
$af_tf_temporary_array = get_option('af_tf_plugin_options');

$var_af_tf_title = $af_tf_temporary_array['af_tf_form_title'];
$var_af_tf_content_message = $af_tf_temporary_array['af_tf_form_content_message'];
$var_af_tf_content_greetings = $af_tf_temporary_array['af_tf_email_greetings'];
$var_af_tf_button_text = $af_tf_temporary_array['af_tf_button_text'];
$var_af_tf_subject = $af_tf_temporary_array['af_tf_email_title_message'];
$var_af_tf_subject_final = $var_af_tf_subject; //.get_bloginfo('name');

$var_af_tf_actionlink = "http://" . $_SERVER['HTTP_HOST']  . $_SERVER['REQUEST_URI'];
$var_af_tf_sender_name = '';

$af_tf_jslink = "http://" .dirname($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."/af-tf-js/af-tf-js.js";
$af_tf_stylelink = "http://" .dirname($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."/af-tf-css/af-tf-style.css";


if (isset($_POST['youremail']) && isset($_POST['friendemail']) && isset($_POST['sendermessage']))
{



$var_af_tf_from_name = "";
$var_af_tf_from_name = trim($_POST['youremail']);
$var_af_tf_friend_email = "";
$var_af_tf_friend_email = trim($_POST['friendemail']);
$var_af_tf_sender_name = trim($_POST['sendername']);
$var_af_tf_message = "";
$var_af_tf_message =  trim($_POST['sendermessage'])."\n\n";
$var_af_tf_message.= $var_af_tf_sender_name;

   $headers = 'From: '.$var_af_tf_sender_name.' <'.$var_af_tf_from_name.'>' . "\r\n";
   wp_mail($var_af_tf_friend_email, $var_af_tf_subject_final, $var_af_tf_message, $headers);  

 
 	$var_af_tf_closingvariable = 1;
  
}
							 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script type="text/javascript" src="<?php echo $af_tf_jslink; ?>"></script>
<link rel="stylesheet" href="<?php echo $af_tf_stylelink; ?>" type="text/css" />


</head>

<body  >
   

<?php 

if( $var_af_tf_closingvariable==0)
	   {
echo '<div >';
	echo $var_af_tf_title;
echo '</div><br>';	 
echo '<form name="af_tf_form" onsubmit="return validateForm()" method="post" action="'.$var_af_tf_actionlink.'">';
echo ' 
	  
<div ><span >Your name:</span><br><input name="sendername" type="text" id="sendername" size="45" maxlength="64"></div>	  
<div style=""><br>Your  email:<br><input name="youremail" type="text" id="youremail" size="45" maxlength="64"></div>	
<div style=""><br>Your\'s friend email:<br><input name="friendemail" type="text" id="friendemail" size="45" maxlength="64"></div>
<div style=""><br>Message content:<br>
            <textarea name="sendermessage" cols="50" rows="5" id="sendermessage" readonly>';
		echo $var_af_tf_content_message."\n\n";
	echo $_SERVER['HTTP_REFERER']."\n\n";		

 
 echo $var_af_tf_content_greetings."\n";
 echo $var_af_tf_sender_name."\n"; 		
			
			
	echo '</textarea>	</div>  ';
	echo '<div ><input type="submit" name="Submit"  value="';             
			echo $var_af_tf_button_text;	
				echo '" ></div></form>';
		 
		 }
	
	   else {	
	   		echo '<div></div>';
			echo '<div></div>';
	   	echo '<p align="center">Your message has been sent, thank you!</p>';  
		echo '<div></div>';
		
		if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
		{
	   	echo '<p align="center"><a href="';
		echo get_site_url();
		echo '">go back to main site page (within 5 seconds)</a> </p>';
		?>
	<script type="text/javascript">
<!--
setTimeout('window.location = "<?php echo get_site_url();  ?>"',5000);
//-->
</script>	


		<?php
		}
		else {
		echo '<p align="center"><a href="javascript:window.close();">CLOSE</a> </p>';
		
		}
	   }


?>
  
  
</body>
</html>
