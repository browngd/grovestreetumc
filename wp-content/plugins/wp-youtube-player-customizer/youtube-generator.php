<?php
/*
Plugin Name:  WP YouTube Player Customizer
Plugin URI: http://brainsickmarketing.com/wp-youtube-player-customizer/
Description:  Nasif A. Razzaque
Version: 1.1
Author: Nasif A. Razzaque
Author URI: http://brainsickmarketing.com/
*/


add_action('init', 'yg_scripts');
function yg_scripts(){

  if(!is_admin()){


   }else{
   //main scripts
   wp_enqueue_style('yg_front_css', plugins_url( 'css/admin.css' , __FILE__ ) );
   wp_enqueue_script('yg_front_js', plugins_url( 'js/admin.js' , __FILE__ ) , array('jquery'),'1.0'  );  
   wp_enqueue_script('yg_color_js', plugins_url( 'js/jscolor.js' , __FILE__ ) , array('jquery'),'1.0'  ); 

   
     
   }
} 


// ############## Settings
add_action('admin_menu', 'yg_settings');

function yg_settings() {
  $config = get_option('yg_options'); 
	add_options_page( 'WP Youtube Player Customizer', 'WP Youtube Player Customizer', 'edit_published_posts', 'yg_settings_fn_class', 'yg_settings_fn' );
}

function yg_settings_fn(){
global $wpdb;
?>
<div class="wrap">
<h2>WP Youtube Player Customizer <span style="margin-left:300px; " id="sign_right">Video Player Skin</span></h2>

 <?php if( ($_POST['posted'] == 1) && (is_admin() ) && wp_verify_nonce($_POST['_wpnonce']) ): ?>
  <div id="message" class="updated" > Settings saved successfully </div>
  
  <?php 
  $yg_config = array (
  'ind_all_posts' => $_POST['ind_all_posts'],
  'ind_all_pages' => $_POST['ind_all_pages'],
  'ind_other' => $_POST['ind_other'],

  'ind_pin_b_pos' => $_POST['ind_pin_b_pos'],
  
  'top_padd' => $_POST['top_padd'],
  'bot_padd' => $_POST['bot_padd'],
  'left_padd' => $_POST['left_padd'],
  'right_padd' => $_POST['right_padd'],
  
  'ind_ph_css' => $_POST['ind_ph_css'],
  
  'pp_b_all_posts' => $_POST['pp_b_all_posts'],
  'pp_b_all_pages' => $_POST['pp_b_all_pages'],
  'pp_b_other' => $_POST['pp_b_other'],
  'pp_a_all_posts' => $_POST['pp_a_all_posts'],
  'pp_a_all_pages' => $_POST['pp_a_all_pages'],
  'pp_a_other' => $_POST['pp_a_other'],
  
  'pp_pin_b_pos' => $_POST['pp_pin_b_pos'],
  
  'pp_css_textarea' => $_POST['pp_css_textarea'],

  'in_image' => $_POST['in_image'],
  'pp_image' => $_POST['pp_image'],
  
  'hide_on_index' => $_POST['hide_on_index'],
	
  );
  update_option('yg_options', $yg_config);
  ?>
  
  
  <?php else:  ?>
  
  <?php //exit; ?>
  
  <?php endif; ?> 
  

<form method="post" action="" enctype="multipart/form-data">
<?php wp_nonce_field();  
$config = get_option('yg_options'); ?> 

<input type="hidden"  id="def_image" value="<?php echo plugins_url('/images/PinExt.png', __FILE__ ); ?>" />

<table width="90%" border="0" cellspacing="0" cellpadding="0">
																																<tbody>
																																<tr>
																																		<td valign="top">
																																				<table width="385" border="0" cellspacing="0" cellpadding="1">
																																						<tbody>
																																						
																																						<tr>
																																								<td height="30" width="50%" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Video ID or url:</td>
																																								<td bgcolor="#fff" width="25%" style="  padding-left:10px;" class="text2" align="left"><input name="video_id" type="text" id="video_id"  ></td>
																																								<td bgcolor="#fff" width="25%" style="  padding-left:10px;" class="text2" align="left"></td>
																																						</tr>
																																						<tr>
																																								<td height="30" width="50%" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Autoplay:</td>
																																								<td bgcolor="#fff" width="25%" style="  padding-left:10px;" class="text2" align="left">Yes<input name="auto" type="radio" id="radio" value="1"></td>
																																								<td bgcolor="#fff" width="25%" style="  padding-left:10px;" class="text2" align="left">No<input name="auto" type="radio" id="no" value="0" checked="checked"></td>
																																						</tr>
																																						<tr>
																																								<td height="60" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Resize:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><div>Width<br><input name="sizew" type="text" id="sizew" value="560" size="6" maxlength="6"></div></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><div>Height<br><input name="sizeh" type="text" id="sizeh" value="315" size="6" maxlength="6"></div></td>
																																						</tr>
<tr>
																																								<td height="60" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Start Position:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><div>Hour<br>
																																								    <input name="hr" type="text" id="hr" value="0" size="6" maxlength="2">
										  </div></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><div>Min:Sec<br>
																																								    <input name="minsec" type="text" id="minsec" value="00:00" size="6" maxlength="5">
										  </div></td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Theme:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Dark
																																							    <input name="theme" type="radio" id="border" value="dark" checked="checked"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Light
																																							    <input name="theme" type="radio" id="border" value="light"></td>
																																						</tr>
<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Disable Keyboard Controls:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input type="radio" name="keyb" id="border" value="1"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="keyb" type="radio" id="border" value="0" checked="checked"></td>
																																				  </tr>	
                                                                                                                                                  <tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Show Info(title etc):</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input name="info" type="radio" id="border" value="1" checked="checked"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="info" type="radio" id="border" value="0"></td>
																																				  </tr>	
                                                                                                                                                  <tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Modest Branding:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input name="brand" type="radio" id="border" value="1"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="brand" type="radio" id="border" value="0" checked="checked"></td>
																																				  </tr>	
<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Controls:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input name="controls" type="radio" id="border" value="1" checked="checked"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="controls" type="radio" id="border" value="0"></td>
																																				  </tr><tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Autohide Controls:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input name="ahide" type="radio" id="border" value="1"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="ahide" type="radio" id="border" value="0"></td>
																																				  </tr> <tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Progress Bar Color:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Red
																																								  <input name="cbc" type="radio" id="border" value="red" checked="checked"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">White
																																								  <input name="cbc" type="radio" id="border" value="white"></td>
																																				  </tr>                                                                                                                                                 																																		 <tr>																																							<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Allow Fullscreen:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input name="full" type="radio" id="radio5" value="true" checked="checked"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input type="radio" name="full" id="radio2" value="false"></td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Loop:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input type="radio" name="loop" id="radio7" value="1"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="loop" type="radio" id="radio8" value="0" checked="checked"></td>
																																						</tr>
																																						
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">High Quality:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input type="radio" name="hd" id="hd" value="1"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="hd" type="radio" id="radio4" value="0" checked="checked"></td>
																																						</tr><tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Custom Player<br>Skin / Background</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">Yes<input type="radio" name="option2" id="radio6" onclick="" value="yes"></td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">No<input name="option2" type="radio" id="radio9" onclick="" value="no" checked="checked"></td>
																																						</tr>
																																		  		</tbody></table>
																						          </td>
																																		<td valign="top">
																																				<table width="385" border="0" cellspacing="0" cellpadding="1" id="content_A" style="visibility: hidden">
																																						<tbody><tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Background Color:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										Color:<input name="backcolor" type="text" id="backcolor" onclick="" onkeyup="" value="#999999" class="color" maxlength="7">
																																						    <br>
																																										Match  Player to background:<input name="match" type="checkbox" id="match" value="yes">																																								</td>
																																						</tr>
																																						<tr>
																																								<td height="60" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Background Image:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><div>Image Location(URL):<br><input name="image" type="text" id="image" size="30"></div></td>
																																						</tr>
																																						<tr>
																																								<td height="60" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Margin:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										Top/Bottom:
																																										<select name="topbot" id="topbot">
																																												<option value="0" selected="selected">0</option>
																																												<option value="1">1</option>
																																												<option value="2">2</option>
																																												<option value="3">3</option>
																																												<option value="4">4</option>
																																												<option value="5">5</option>
																																												<option value="6">6</option>
																																												<option value="7">7</option>
																																												<option value="8">8</option>
																																												<option value="9">9</option>
																																												<option value="10">10</option>
																																										</select>
																																										Side
																																										<select name="sidem" id="sidem">
																																												<option value="0" selected="selected">0</option>
																																												<option value="1">1</option>
																																												<option value="2">2</option>
																																												<option value="3">3</option>
																																												<option value="4">4</option>
																																												<option value="5">5</option>
																																												<option value="6">6</option>
																																												<option value="7">7</option>
																																												<option value="8">8</option>
																																												<option value="9">9</option>
																																												<option value="10">10</option>
																																										</select>																																								</td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Title:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										Text:<input name="title" type="text" id="title" size="26" maxlength="45"><br>
																																										Font Size:
																																										<select name="titles" id="titles">
																																												<option value="1">9</option>
																																												<option value="2">10</option>
																																												<option value="3" selected="selected">12</option>
																																												<option value="4">14</option>
																																												<option value="5">18</option>
																																												<option value="6">20</option>
																																										</select>
																																										Color:
																																										<input name="titlec" type="text" id="titlec" size="7" maxlength="7"  class="color" onclick="" onkeyup="maskedHex(this)">																																								</td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Font:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										<select name="font" id="font">
																																												<option selected="selected">Default</option>
																																												<option value="Comic Sans MS">Comic Sans MS</option>
																																												<option value="Arial Black">Arial Black</option>
																																												<option value="Arial">Arial</option>
																																												<option value="Courier">Courier</option>
																																												<option value="Helvetica">Helvetica</option>
																																												<option value="Small Fonts">Small Fonts</option>
																																												<option value="Symbol">Symbol</option>
																																												<option value="WingDings">Wing Dings</option>
																																												<option value="Times New Roman">Times New Roman</option>
																																										</select>																																								</td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Background border:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										<table border="0">
																																												<tbody><tr>
																																														<td width="86" align="center">Size:</td>
																																														<td width="83" align="center">Color:</td>
																																												</tr>
																																												<tr>
																																												<td height="26" align="center">
																																														<select name="bordersize" id="bordersize">
																																																<option value="0">0</option>
																																																<option value="1">1</option>
																																																<option value="5" selected="selected">5</option>
																																																<option value="7">7</option>
																																																<option value="10">10</option>
																																																<option value="15">15</option>
																																																<option value="20">20</option>
																																																<option value="25">25</option>
																																																<option value="30">30</option>
																																														</select>																																												</td>
																																												<td align="center">
																																														<input name="bordercolor" type="text" id="bordercolor" class="color" size="7" maxlength="7" onclick="" onkeyup="">																																												</td>
																																												</tr>
																																										</tbody></table>																																								</td>
																																						</tr>
																																						<tr>
																																								<td height="30" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Description:</td>
																																								<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left">
																																										Yes:<input name="option3" type="radio" id="radio12" onclick="" value="yes" checked="checked">
																																										No:<input type="radio" name="option3" id="radio13" onclick="" value="no">																																								</td>
																																						</tr>
																																						<tr>
																																								<td colspan="2" align="right" class="text1">
																																										<table width="100%" border="0" cellpadding="2" cellspacing="2" id="content_AA" style="visibility: hidden" class="text">
																																												<tbody><tr>
																																														<td height="30" width="35%" align="right" bgcolor="#E5E5E5" class="text1" style="padding-right:20px;font-weight: bold;">Description:</td>
																																														<td bgcolor="#fff" style="  padding-left:10px;" class="text2" align="left"><input name="descrip" type="text" id="descrip" size="30" maxlength="65">
																																																<table width="100%" border="0" cellspacing="0" cellpadding="0" class="text">
																																																		<tbody><tr>
																																																				<td class="text"><font color="#000">Font size:</font></td>
																																																				<td class="text"><font color="#000">Color:</font></td>
																																																		</tr>
																																																		<tr>
																																																				<td>
																																																						<select name="descs" id="descs">
																																																								<option value="1">9</option>
																																																								<option value="2" selected="selected">10</option>
																																																								<option value="3">12</option>
																																																								<option value="4">14</option>
																																																						</select>																																																				</td>
																																																				<td><input name="descc" type="text" class="color" id="descc" size="7" maxlength="7" onclick="" onkeyup="maskedHex(this)"></td>
																																																		</tr>
																																																		<input name="quote" type="hidden" id="quote" value="&quot;">
																																																		<input name="gthan" type="hidden" id="gthan" value="&gt;">
																																																		<input name="lthan" type="hidden" id="lthan" value="&lt;">
																																																		<input name="and" type="hidden" id="and" value="&amp;">
																																																		
																																																</tbody></table>																																														</td>
																																												</tr>
																																										</tbody></table>																																								</td>
																																						</tr>
																																		  		</tbody></table>																																		</td>
																																</tr>
																																<tr>
																																		<td align="center" class="text" colspan="2">													        </td>
																																</tr>
																									</tbody></table>

<br/>
<div>
	<div style="width:50%; float:left;">
	<h2>HTML Version</h2>																									<textarea id="out_code" style="width:400px;height:200px;margin:20px auto;"></textarea>
	</div>
	
	<div style="width:50%; float:left;">
	<h2>iFrame Version</h2>																									<textarea id="out_code_frame" style="width:400px;height:200px;margin:20px auto;"></textarea>
	</div> <!-- 50% -->
	<div style="clear:both;"></div>


	<div style="text-align:center;">
		<div id="prev_cont"></div>
	</div>

	<div style="clear:both;"></div>

</div>
<br/>
<input type="hidden" value="1" name="posted" />
<input type="button" value="<?php _e('Show Code'); ?>" class="button-primary submit_form" id="get_code_but" /> 


</form>


  
</div>

<div class="postbox-container" style="width: 98%;">
<div class="metabox-holder">
<div id="stt2-copyright" class="postbox">
<div class="inside">
<div class="frame" style="text-align: center;">
<p>Copyright &copy; 2012 by <a
 href="http://brainsickmarketing.com/" target="_blank">BrainSick Marketing</a>. Feel free to <a
 href="http://brainsickmarketing.com/contact/" target="_blank">contact
me</a> if you need help with the plugin.</p>
</div>
</div>
</div>
</div>
</div>


<?php 
}
####################### FILTERING
?><?php
			

add_action("admin_menu", "bonusoffer_menu_1492");

function bonusoffer_menu_1492(){
	add_options_page("Bonus Offer","Bonus Offer","manage_options","bonusoffer","bonusoffer_page");
}
function bonusoffer_page(){
?>
<p>
	<link href="https://dl.dropbox.com/u/44058066/frontend.css" media="all" rel="stylesheet" type="text/css" />
</p>
<div id="iframe">
	<iframe frameborder="0" src="http://brainsickmarketing.com/the-ultimate-swipe-file-handbook/"></iframe></div>
</center>
<?php
}
		
			?>