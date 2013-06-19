<?php

/*
Plugin Name: WP Translate
Plugin URI: http://labs.hahncreativegroup.com/wordpress-plugins/wp-translate/
Description: Add Google Translate to your WordPress site
Author: HahnCreativeGroup
Version: 4.0.1
Author URI: http://labs.hahncreativegroup.com/
*/

register_activation_hook( __FILE__,  'wpTranslate_install' );

function wpTranslate_install() {
	$wpTranslateOptions = array(
								"default_language" => "auto",
								"tracking_enabled" => false,
								"tracking_id" => ""
								);
	
	add_option("wpTranslateOptions", $wpTranslateOptions);
}

function translate_Init() {
	$wpTranslateOptions = get_option("wpTranslateOptions");
	?>
    <script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: '<?php echo $wpTranslateOptions["default_language"]; ?>',
    <?php if ($wpTranslateOptions["tracking_enabled"]) { ?>
	gaTrack: true,
    gaId: '<?php echo $wpTranslateOptions["tracking_id"]; ?>',
	<?php } ?>
    floatPosition: google.translate.TranslateElement.FloatPosition.TOP_RIGHT
  });
}
</script><script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <?php	
}
add_action('wp_footer', 'translate_Init');

function create_translate_plugin_links($links, $file) {			
	if ( $file == plugin_basename(__FILE__) ) {			
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EJVXJP3V8GE2J">' . __('Donate', 'wp-translate') . '</a>';
	}
	return $links;
}
add_filter('plugin_row_meta', 'create_translate_plugin_links', 10, 2);

function add_wp_translate_menu() {
	add_menu_page(__('WP Translate','wp-translate'), __('WP Translate','wp-translate'), 'manage_options', 'wptranslate-admin', 'show_translate_menu' );
}
add_action( 'admin_menu', 'add_wp_translate_menu' );

function show_translate_menu()
{
	include("admin/overview.php");
}
?>