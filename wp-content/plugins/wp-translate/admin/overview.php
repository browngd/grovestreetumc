<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

	if (isset($_POST["editOptions"])) {
		$wpTranslateOptions['default_language'] = $_POST["defaultLanguage"];
		if (isset($_POST["trackingEnabled"]))
			$wpTranslateOptions['tracking_enabled'] = true;
		else
			$wpTranslateOptions['tracking_enabled'] = false;
			
		$wpTranslateOptions['tracking_id'] = $_POST["trackingId"];
				
		update_option("wpTranslateOptions", $wpTranslateOptions);
		?>  
        <div class="updated"><p><strong><?php _e('WP Translate settings have been saved.', 'wp-translate' ); ?></strong></p></div>  
        <?php
	}
	$wpTranslateOptions = get_option("wpTranslateOptions");
?>
<div id='wrap'>
	<h2><?php _e('WP Translate - Settings', 'wp-translate'); ?></h2>
    
    <h3 style="float: left; width 50%;"><?php _e('Default Language', 'wp-translate'); ?></h3>
    <p style="float: right; width 50%; margin-right: 14px;"><strong><em><a href="http://labs.hahncreativegroup.com/wp-translate-pro/"><?php _e('Try WP Translate Pro'); ?></a></em></strong></p>
    <div style="clear: both;"></div>
    <form name="wp_translate_settings_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
    <input type="hidden" name="editOptions" vale="true" />
    <select id="defaultLanguage" name="defaultLanguage">
                    <option value="auto" <?php if($wpTranslateOptions['default_language'] == 'auto') echo 'selected'; ?>>Detect language</option>
                    <option value="af" <?php if($wpTranslateOptions['default_language'] == 'af') echo 'selected'; ?>>Afrikaans</option>
                    <option value="sq" <?php if($wpTranslateOptions['default_language'] == 'sq') echo 'selected'; ?>>Albanian</option>
                    <option value="ar" <?php if($wpTranslateOptions['default_language'] == 'ar') echo 'selected'; ?>>Arabic</option>
                    <option value="hy" <?php if($wpTranslateOptions['default_language'] == 'hy') echo 'selected'; ?>>Armenian</option>
                    <option value="az" <?php if($wpTranslateOptions['default_language'] == 'az') echo 'selected'; ?>>Azerbaijani</option>
                    <option value="eu" <?php if($wpTranslateOptions['default_language'] == 'eu') echo 'selected'; ?>>Basque</option>
                    <option value="be" <?php if($wpTranslateOptions['default_language'] == 'be') echo 'selected'; ?>>Belarusian</option>
                    <option value="bg" <?php if($wpTranslateOptions['default_language'] == 'bg') echo 'selected'; ?>>Bulgarian</option>
                    <option value="ca" <?php if($wpTranslateOptions['default_language'] == 'ca') echo 'selected'; ?>>Catalan</option>
                    <option value="zh-CN" <?php if($wpTranslateOptions['default_language'] == 'zh-CN') echo 'selected'; ?>>Chinese (Simplified)</option>
                    <option value="zh-TW" <?php if($wpTranslateOptions['default_language'] == 'zh-TW') echo 'selected'; ?>>Chinese (Traditional)</option>
                    <option value="hr" <?php if($wpTranslateOptions['default_language'] == 'hr') echo 'selected'; ?>>Croatian</option>
                    <option value="cs" <?php if($wpTranslateOptions['default_language'] == 'cs') echo 'selected'; ?>>Czech</option>
                    <option value="da" <?php if($wpTranslateOptions['default_language'] == 'da') echo 'selected'; ?>>Danish</option>
                    <option value="nl" <?php if($wpTranslateOptions['default_language'] == 'nl') echo 'selected'; ?>>Dutch</option>
                    <option value="en" <?php if($wpTranslateOptions['default_language'] == 'en') echo 'selected'; ?>>English</option>
                    <option value="et" <?php if($wpTranslateOptions['default_language'] == 'et') echo 'selected'; ?>>Estonian</option>
                    <option value="tl" <?php if($wpTranslateOptions['default_language'] == 'tl') echo 'selected'; ?>>Filipino</option>
                    <option value="fi" <?php if($wpTranslateOptions['default_language'] == 'fi') echo 'selected'; ?>>Finnish</option>
                    <option value="fr" <?php if($wpTranslateOptions['default_language'] == 'fr') echo 'selected'; ?>>French</option>
                    <option value="gl" <?php if($wpTranslateOptions['default_language'] == 'gl') echo 'selected'; ?>>Galician</option>
                    <option value="ka" <?php if($wpTranslateOptions['default_language'] == 'ka') echo 'selected'; ?>>Georgian</option>
                    <option value="de" <?php if($wpTranslateOptions['default_language'] == 'de') echo 'selected'; ?>>German</option>
                    <option value="el" <?php if($wpTranslateOptions['default_language'] == 'el') echo 'selected'; ?>>Greek</option>
                    <option value="ht" <?php if($wpTranslateOptions['default_language'] == 'ht') echo 'selected'; ?>>Haitian Creole</option>
                    <option value="iw" <?php if($wpTranslateOptions['default_language'] == 'iw') echo 'selected'; ?>>Hebrew</option>
                    <option value="hi" <?php if($wpTranslateOptions['default_language'] == 'hi') echo 'selected'; ?>>Hindi</option>
                    <option value="hu" <?php if($wpTranslateOptions['default_language'] == 'hu') echo 'selected'; ?>>Hungarian</option>
                    <option value="is" <?php if($wpTranslateOptions['default_language'] == 'is') echo 'selected'; ?>>Icelandic</option>
                    <option value="id" <?php if($wpTranslateOptions['default_language'] == 'id') echo 'selected'; ?>>Indonesian</option>
                    <option value="ga" <?php if($wpTranslateOptions['default_language'] == 'ga') echo 'selected'; ?>>Irish</option>
                    <option value="it" <?php if($wpTranslateOptions['default_language'] == 'it') echo 'selected'; ?>>Italian</option>
                    <option value="ja" <?php if($wpTranslateOptions['default_language'] == 'ja') echo 'selected'; ?>>Japanese</option>
                    <option value="ko" <?php if($wpTranslateOptions['default_language'] == 'ko') echo 'selected'; ?>>Korean</option>
                    <option value="lv" <?php if($wpTranslateOptions['default_language'] == 'lv') echo 'selected'; ?>>Latvian</option>
                    <option value="lt" <?php if($wpTranslateOptions['default_language'] == 'lt') echo 'selected'; ?>>Lithuanian</option>
                    <option value="mk" <?php if($wpTranslateOptions['default_language'] == 'mk') echo 'selected'; ?>>Macedonian</option>
                    <option value="ms" <?php if($wpTranslateOptions['default_language'] == 'ms') echo 'selected'; ?>>Malay</option>
                    <option value="mt" <?php if($wpTranslateOptions['default_language'] == 'mt') echo 'selected'; ?>>Maltese</option>
                    <option value="no" <?php if($wpTranslateOptions['default_language'] == 'no') echo 'selected'; ?>>Norwegian</option>
                    <option value="fa" <?php if($wpTranslateOptions['default_language'] == 'fa') echo 'selected'; ?>>Persian</option>
                    <option value="pl" <?php if($wpTranslateOptions['default_language'] == 'pl') echo 'selected'; ?>>Polish</option>
                    <option value="pt" <?php if($wpTranslateOptions['default_language'] == 'pt') echo 'selected'; ?>>Portuguese</option>
                    <option value="ro" <?php if($wpTranslateOptions['default_language'] == 'ro') echo 'selected'; ?>>Romanian</option>
                    <option value="ru" <?php if($wpTranslateOptions['default_language'] == 'ru') echo 'selected'; ?>>Russian</option>
                    <option value="sr" <?php if($wpTranslateOptions['default_language'] == 'sr') echo 'selected'; ?>>Serbian</option>
                    <option value="sk" <?php if($wpTranslateOptions['default_language'] == 'sk') echo 'selected'; ?>>Slovak</option>
                    <option value="sl" <?php if($wpTranslateOptions['default_language'] == 'sl') echo 'selected'; ?>>Slovenian</option>
                    <option value="es" <?php if($wpTranslateOptions['default_language'] == 'es') echo 'selected'; ?>>Spanish</option>
                    <option value="sw" <?php if($wpTranslateOptions['default_language'] == 'sw') echo 'selected'; ?>>Swahili</option>
                    <option value="sv" <?php if($wpTranslateOptions['default_language'] == 'sv') echo 'selected'; ?>>Swedish</option>
                    <option value="th" <?php if($wpTranslateOptions['default_language'] == 'th') echo 'selected'; ?>>Thai</option>
                    <option value="tr" <?php if($wpTranslateOptions['default_language'] == 'tr') echo 'selected'; ?>>Turkish</option>
                    <option value="uk" <?php if($wpTranslateOptions['default_language'] == 'uk') echo 'selected'; ?>>Ukrainian</option>
                    <option value="ur" <?php if($wpTranslateOptions['default_language'] == 'ur') echo 'selected'; ?>>Urdu</option>
                    <option value="vi" <?php if($wpTranslateOptions['default_language'] == 'vi') echo 'selected'; ?>>Vietnamese</option>
                    <option value="cy" <?php if($wpTranslateOptions['default_language'] == 'cy') echo 'selected'; ?>>Welsh</option>
                    <option value="yi" <?php if($wpTranslateOptions['default_language'] == 'yi') echo 'selected'; ?>>Yiddish</option>
                </select>
                <h3><?php _e('Translation Tracking - Google Analytics', 'wp-translate'); ?></h3>
                <label><?php _e('Tracking enabled', 'wp-translate'); ?>:</label> <input type="checkbox" name="trackingEnabled" value="true"<?php echo ($wpTranslateOptions['tracking_enabled']) ? " checked='yes'" : ""; ?> />
                <br />
                <label><?php _e('Tracking ID (UA#)', 'wp-translate'); ?></label>: <input type="text" name="trackingId" value="<?php echo $wpTranslateOptions['tracking_id']; ?>" />                
                <p class="major-publishing-actions"><input type="submit" name="Submit" class="button-primary" value="<?php _e('Save Settings', 'wp-translate'); ?>" /></p>
                </form>
                <br />
                <div style="float: left; width: 60%; min-width: 488px;">
                <p><strong><a href="http://labs.hahncreativegroup.com/wp-translate-pro/"><?php _e('Try WP Translate Pro', 'wp-translate'); ?></a></strong><br /><em>Pro features include: Enhanced widget positioning, add free...</em></p>
<p><strong>Try WP Easy Gallery Pro</strong><br /><em>Pro Features include: Multi-image uploader, Enhanced admin section for easier navigation, Image preview pop-up, and more...</em></p>
<p><a href="http://labs.hahncreativegroup.com/wordpress-plugins/wp-easy-gallery-pro-simple-wordpress-gallery-plugin/?src=wpt" target="_blank"><img title="WP-Easy-Gallery-Pro_468x88" src="http://labs.hahncreativegroup.com/wp-content/uploads/2012/02/WP-Easy-Gallery-Pro_468x88.gif" alt="" border="0" width="468" height="88" /></a></p>
<p><strong>Try Custom Post Donations Pro</strong><br /><em>This WordPress plugin will allow you to create unique customized PayPal donation widgets to insert into your WordPress posts or pages and accept donations. Features include: Multiple Currencies, Multiple PayPal accounts, Custom donation form display titles, and more.</em></p>
<p><a href="http://labs.hahncreativegroup.com/wordpress-plugins/custom-post-donations-pro/?src=wpt"><img src="http://labs.hahncreativegroup.com/wp-content/uploads/2011/10/CustomPostDonationsPro-Banner.gif" width="374" height="60" border="0" alt="Custom Post Donations Pro" /></a></p>
<p><strong>Try ReFlex Gallery</strong><br /><em>ReFlex Gallery is a fully responsive WordPress image gallery plugin that is actually two galleries in one.</em></p>
<p><a href="http://wordpress-photo-gallery.com/?src=wpt"><img src="http://labs.hahncreativegroup.com/wp-content/uploads/2012/08/reflex_gallery_page_image_374x190_v4.jpg" width="374" height="190" alt="ReFlex Gallery - Responsive WordPress Photo Gallery" border="0" /></a></p>
<p><em>Please consider making a donatation for the continued development of this plugin. Thanks.</em></p>
<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EJVXJP3V8GE2J" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></a></p>
</div>
<div style="float: right; width: 25%; height: 700px; padding: 10px; min-width: 165px; margin-right: 14px; overflow: scroll;">
<?php
$url = "http://labs.hahncreativegroup.com/feed/";
$rss = simplexml_load_file($url);
if($rss)
{
  echo '<h3>'.$rss->channel->title.'</h3>';
  $items = $rss->channel->item;
  $count = 0;
  foreach($items as $item)
  {
	$count++;	
	$title = $item->title;
	$link = $item->link;
	$published_on = $item->pubDate;
	$description = $item->description;
	echo '<h4><a href="'.$link.'">'.$title.'</a></h4>';
	echo '<p>'.$description.'</p>';
	if ($count >= 5) {
		break;	
	}
  }
}
?>
</div>
</div>