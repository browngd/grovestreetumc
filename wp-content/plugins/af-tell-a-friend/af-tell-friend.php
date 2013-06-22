<?php
 /* 
 Plugin Name: AF Tell a Friend 
 Plugin URI: http://argonfactory.com/wordpress/af-tell-a-friend-plugin/
 Description: AF Tell a Friend Plugin create pop up window, with option for both sender email and friend's email. Inside email message box, AF Tell a Friend Plugin place full URL to the actual page where Tell a Friend button was installed. Website admin can modify content of message box, but message area is set to read only mode, so can not be used for inserting spam content.
 Version: 1.4 
Plugin URI: http://argonfactory.com/wordpress/af-tell-a-friend-plugin/
Author URI: http://argonfactory.com/
 */ 
 
 /* Copyright (c) 2013 Wladyslaw Madejczyk, AF Tell a Friend Plugin (email: wladyslawmadejczyk@yahoo.co.uk)
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


function af_tf_activation() { 

$plugins_url = plugins_url();
$thewindowURL = $plugins_url.'/af-tell-a-friend/af-tf-window.php';
//=== options zone ===
$af_tf_options_array = array(
'af_tf_form_title'	=> 'Send message about this page to your friend!', 
'af_tf_email_title_message' => 'Please see this page on >>website name<<',
'af_tf_form_content_message' => 'Hello, I think this page is interesting: ',
'af_tf_windowURL' => $thewindowURL,
'af_tf_email_greetings'	=> 'best regards',
'af_tf_button_text' => 'Tell a Friend',
'af_tf_text_visual' => 'Tell a Friend',
'af_tf_window_height' => 380,
'af_tf_window_width' => 500,
'af_tf_font_size' => '12px'
); 
update_option( 'af_tf_plugin_options', $af_tf_options_array );
//=== end of options zone

register_uninstall_hook( __FILE__, ‘af_tf_uninstall’ );

}  


function af_tf_deactivation() 
{
	// deactivation
}

function af_tf_uninstall() {
	// uninstall
}

//====== plugin menu zone ===
add_action( 'admin_menu', 'af_tf_menu_create_menu' );
function af_tf_menu_create_menu() {
//create a submenu under Settings 
add_options_page( 'AF TellaFriend Settings Page Title Tag', 'AF Tell a Friend',
'manage_options', __FILE__, 'af_tf_menu_settings_page' );
} 

function af_tf_menu_settings_page() {

		$af_tf_temporary_array = get_option('af_tf_plugin_options');
$var_af_tf_admin_popwindow_title = $af_tf_temporary_array['af_tf_form_title'];
$var_af_tf_admin_email_subject = $af_tf_temporary_array['af_tf_email_title_message'];//"Please see page on ";
$var_af_tf_admin_inside_email_title = $af_tf_temporary_array['af_tf_form_content_message'];
$var_af_tf_admin_content_greetings = $af_tf_temporary_array['af_tf_email_greetings'];
$var_af_tf_admin_button_text = $af_tf_temporary_array['af_tf_button_text'];	
$var_af_tf_admin_window_width = $af_tf_temporary_array['af_tf_window_width'];	
$var_af_tf_admin_window_height = $af_tf_temporary_array['af_tf_window_height'];
$var_af_tf_admin_text_visual = $af_tf_temporary_array['af_tf_text_visual'];
$var_af_tf_admin_font_size = $af_tf_temporary_array['af_tf_font_size'];

	if (@$_POST['af_tf_admin_setting']) 
	{
		
		$var_af_tf_admin_popwindow_title = stripslashes($_POST['af_tf_admin_popwindowtitle']);
		$var_af_tf_admin_email_subject = stripslashes($_POST['af_tf_admin_email_subject']);
		$var_af_tf_admin_inside_email_title = stripslashes($_POST['af_tf_admin_inside_email']);
		$var_af_tf_admin_content_greetings = stripslashes($_POST['af_tf_admin_email_greetings']);
		$var_af_tf_admin_button_text = stripslashes($_POST['af_tf_admin_button_text']);
		$var_af_tf_admin_window_width = stripslashes($_POST['var_af_tf_admin_window_width']);
		$var_af_tf_admin_window_height = stripslashes($_POST['var_af_tf_admin_window_height']);
		$var_af_tf_admin_text_visual = stripslashes($_POST['af_tf_admin_text_visual']);
		$var_af_tf_admin_font_size = stripslashes($_POST['af_tf_admin_font_size']);

$af_tf_options_array = array(
'af_tf_form_title'	=> $var_af_tf_admin_popwindow_title, 
'af_tf_email_title_message' => $var_af_tf_admin_email_subject,
'af_tf_form_content_message' => $var_af_tf_admin_inside_email_title,
'af_tf_email_greetings'	=> $var_af_tf_admin_content_greetings,
'af_tf_button_text' => $var_af_tf_admin_button_text,
'af_tf_text_visual' => $var_af_tf_admin_text_visual,
'af_tf_window_width' => $var_af_tf_admin_window_width,
'af_tf_window_height' => $var_af_tf_admin_window_height,
'af_tf_font_size' => $var_af_tf_admin_font_size
);
update_option( 'af_tf_plugin_options', $af_tf_options_array );

	}


echo '<div>';
	
	echo '<h3>AF Tell a Friend Form Settings</h3>'."\n\n";
		echo '<form name="af_tf_admin_form" method="post" action="" style="margin-bottom:20px">';
	
	echo '<p><b>Popup Window Title:</b><br><input  style="width: 300px;" type="text" value="';
	echo $var_af_tf_admin_popwindow_title . '" name="af_tf_admin_popwindowtitle" id="af_tf_admin_popwindowtitle" /></p>';
	
	echo '<p><b>Email Subject:</b><br><input  style="width: 300px;" type="text" value="';
	echo $var_af_tf_admin_email_subject . '" name="af_tf_admin_email_subject" id="af_tf_admin_email_subject" /></p>';
	
	echo '<p><b>Inside-email Title:</b><br><input style="width: 300px;" type="text" value="';
echo $var_af_tf_admin_inside_email_title . '" name="af_tf_admin_inside_email" maxlength="200" id="af_tf_admin_inside_email" /><br />';

	
	echo '<p><b>Email Greetings:</b><br><input style="width: 300px;" type="text" value="';
	echo $var_af_tf_admin_content_greetings . '" name="af_tf_admin_email_greetings" maxlength="200" id="af_tf_admin_email_greetings" /><br />';
	
	echo '<p>Button Text:<br><input style="width: 100px;" type="text" value="';
	echo $var_af_tf_admin_button_text . '" name="af_tf_admin_button_text" id="af_tf_admin_button_text" /><br />';
	
	echo '<p>Widget/Shortcode Text:<br><input style="width: 100px;" type="text" value="';
	echo $var_af_tf_admin_text_visual . '" name="af_tf_admin_text_visual" id="af_tf_admin_text_visual" /><br />';

	echo '<p>Window\'s Width:<br><input style="width: 100px;" type="text" value="';
	echo $var_af_tf_admin_window_width . '" name="var_af_tf_admin_window_width" id="var_af_tf_admin_window_width" /><br />';
	
	echo '<p>Window\'s Height:<br><input style="width: 100px;" type="text" value="';
	echo $var_af_tf_admin_window_height . '" name="var_af_tf_admin_window_height" id="var_af_tf_admin_window_height" /><br />';	

	echo '<p>Link Font Size (ie. 14px):<br><input style="width: 100px;" type="text" value="';
	echo $var_af_tf_admin_font_size . '" name="af_tf_admin_font_size" id="af_tf_admin_font_size" /><br />';		
	?>

    <?php
	
	echo '<br /><input type="submit" id="af_tf_admin_setting" name="af_tf_admin_setting" class="af_tf_admin_button" value="AF Tell a Friend Update" />';
	

	
	echo '</form>';

	echo '</div>';
	echo '<div style="margin-top:10px;margin-bottom:10px;font-weight:bold"><a href="http://argonfactory.com/web-development-web-applications/af-tell-a-friend-1-5-wordpress-plugin/">New advanced version AF Tell a Friend v. 1.5 available here</a></div>';
	
}

//=== plugin menu zone end ===

//=== registering scripts and styles ===
function af_tf_javascript_files() 
{
	//$plugins_url = plugins_url();
	if (!is_admin())
	{
wp_enqueue_script( 'af_tf_js', plugins_url().'/af-tell-a-friend/af-tf-js/af-tf-js.js');

	}
} 


//========== registering scripts and styles end ===
//====== widgets zone
function af_TellaFriend() 
{
	$temporaryholder = get_option('siteurl').'/wp-content/plugins/af-tell-a-friend/af-tf-window.php';
			$af_tmp_array = get_option('af_tf_plugin_options');
	
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	{
		echo '<a href="';
	    echo $temporaryholder;//$af_tmp_array['af_tf_windowURL'];
        echo '" target="_self">';
		echo '<span style="font-weight:bold;font-size:';
		echo $af_tmp_array['af_tf_font_size'];
		echo '">';
		echo $af_tmp_array['af_tf_text_visual'];
	    echo '</span></a>';
	}
	else {
		
		echo '<a href="';
        echo plugins_url().'/af-tell-a-friend/af-tf-window.php';
        echo '" onclick="af_tellafriendpopupwin(this.href,';
		echo $af_tmp_array['af_tf_window_height'];
		echo ',';
		echo $af_tmp_array['af_tf_window_width'];
		echo '); return false">';
		echo '<span style="font-weight:bold;font-size:';
		echo $af_tmp_array['af_tf_font_size'];
		echo '">';
		echo $af_tmp_array['af_tf_text_visual'];
	    echo '</span></a>';		
		
		
	}
}

function af_TellaFriend_widget($args) 
{
	extract($args);
	echo $before_widget;
	af_TellaFriend();
	echo $after_widget;
}
	
function af_TellaFriend_control() 
{

}

function af_tf_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget('AF Tell a Friend', 'AF Tell a Friend', 'af_TellaFriend_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control('AF Tell a Friend', array('AF Tell a Friend', 'widgets'), 'af_TellaFriend_control');
	} 
}

//======= end of widgets zone



// ======== shortcode zone ===

function af_tf_shortcode() {

$temporaryholder = plugins_url().'/af-tell-a-friend/af-tf-window.php';
    $af_tmp_array_sc = get_option('af_tf_plugin_options');
     
    $af_tf_sh='';
	
	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
	{
	 	$af_tf_sh = '<a href="';
        $af_tf_sh .= $temporaryholder;//$af_tmp_array['af_tf_windowURL'];
         $af_tf_sh .='" target="_self">';
		$af_tf_sh .= '<span style="font-weight:bold;font-size:'.$af_tmp_array_sc['af_tf_font_size'].'">';
		$af_tf_sh .= $af_tmp_array_sc['af_tf_text_visual'];
	    $af_tf_sh .= '</span></a>';			
	}
	else {
		
 	$af_tf_sh = '<a href="';
        $af_tf_sh .= get_option('siteurl').'/wp-content/plugins/af-tell-a-friend/af-tf-window.php';
        $af_tf_sh .= '" onclick="af_tellafriendpopupwin(this.href,';
		$af_tf_sh .= $af_tmp_array_sc['af_tf_window_height'];
		$af_tf_sh .= ',';
		$af_tf_sh .= $af_tmp_array_sc['af_tf_window_width'];
		$af_tf_sh .= '); return false">';
		$af_tf_sh .= '<span style="font-weight:bold;font-size:'.$af_tmp_array_sc['af_tf_font_size'].'">';
		$af_tf_sh .= $af_tmp_array_sc['af_tf_text_visual'];
	    $af_tf_sh .= '</span></a>';		
		
	}
	    return $af_tf_sh;
}

// shortcode in widgets
add_filter('widget_text', 'do_shortcode');
// === end of shortcode zone ===
add_shortcode( 'af_tf_form', 'af_tf_shortcode' );
add_action('wp_enqueue_scripts', 'af_tf_javascript_files');
add_action("plugins_loaded", "af_tf_widget_init");
register_activation_hook(__FILE__,'af_tf_activation');
register_deactivation_hook(__FILE__,'af_tf_deactivation');
register_deactivation_hook(__FILE__,'af_tf_deactivation');
add_action('init', 'af_tf_widget_init');


?>