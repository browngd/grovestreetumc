<?php

require_once dirname( __FILE__ ) . '/db.php';

/**************************************
* ADD ADMIN MENU ITEM
**************************************/

function load_amen_menu() {
	add_menu_page( 'Manage Prayer Requests', 'Amen', 'edit_posts', 'amen_manage_requests', 'amen_manage_requests_admin', plugin_dir_url( __FILE__ ) . 'amen.png', 37 );
}
add_action( 'admin_menu', 'load_amen_menu' );

/**************************************
* ADD SETTINGS MENU ITEM
**************************************/

function amen_add_options_link() {
	add_options_page('Amen Settings', 'Amen Settings', 'manage_options', 'amen-options', 'amen_options_page');
}
add_action('admin_menu', 'amen_add_options_link');

/**************************************
* REGISTER AMEN SETTINGS
**************************************/

function amen_register_settings() {
	register_setting('amen_settings_group', 'amen_settings');
}
add_action('admin_init', 'amen_register_settings');

/**************************************
* DISPLAY ADMIN OPTIONS
**************************************/

function amen_options_page() {
	global $amen_options;
	global $wpdb;

	// QUERY AVAILABLE PAGES
	$amen_all_pages = $wpdb->get_results( 
		"
		SELECT ID, post_title
		FROM $wpdb->posts
		WHERE post_type = 'page'
		ORDER BY post_title ASC
		"
	);

	?>
	<div class="wrap">
		<h2>Amen Settings</h2>

		<form method="post" action="options.php" class="amen-admin">

			<?php settings_fields('amen_settings_group'); ?>

			<div style="float:right;width:40%;border: solid 1px #222D23;background:#ECECEC;padding:7px;font-size:12px;">
				<strong>Amen</strong> was developed by Joshua Vandercar of <a href="http://wmpl.org">World Mission Prayer League</a>.<br /><br />
				<span style="font-size:11px;font-variant:italic;">Then he said to his disciples, "The harvest is plentiful, but the laborers are few; therefore pray earnestly to the Lord of the harvest to send out laborers into his harvest." - Matthew 9:37-38</span><br /><br />
				We are a praying “league”, a community of men and women who are committed to prayer as a key methodology for advancing the Gospel of Christ. Prayer is the working method of our mission.
			</div>

			<h4><?php _e('Privacy Settings', 'amen_domain'); ?></h4>
			<p>
				<?php if ( $amen_options[allow_public_requests] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_allow_public_requests" type="checkbox" name="amen_settings[allow_public_requests]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['allow_public_requests']"><?php _e( 'Allow public visitors to post requests', 'amen_domain'); ?></label>
				<br />
				<?php if ( $amen_options[privatize_prayers] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_privatize_prayers" type="checkbox" name="amen_settings[privatize_prayers]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['privatize_prayers']"><?php _e( 'Allow users to privatize prayers (privilege retained by admin & never allowed for public posters)', 'amen_domain'); ?></label>
				<br />
			<h4><?php _e('Displayed Text', 'amen_domain'); ?></h4>
			<p>
				
				<label class="description" for="amen_settings[author_display]"><?php _e('Display author as', 'amen_domain'); ?></label>
				<select id="amen_settings[author_display]" name="amen_settings[author_display]">
					<?php if( 'none' == $amen_options['author_display'] ) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
						<option <?php echo $selected; ?> value="none">Do not display</option>
					<?php if ( 'username' == $amen_options['author_display'] ) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
						<option <?php echo $selected; ?> value="username">Username</option>
					<?php if ( 'displayname' == $amen_options['author_display'] ) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
						<option <?php echo $selected; ?> value="displayname">Display Name</option>
				</select>
				<br />
				<input id="amen_settings[submission_title]" name="amen_settings[submission_title]" type="text" value="<?php echo $amen_options['submission_title']; ?>"/>
				<label class="description" for="amen_settings[submission_title]"><?php _e('Title for submission form', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[submission_button_text]" name="amen_settings[submission_button_text]" type="text" value="<?php echo $amen_options['submission_button_text']; ?>"/>
				<label class="description" for="amen_settings[submission_button_text]"><?php _e('Text for submission form button', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[submission_note]" name="amen_settings[submission_note]" type="text" value="<?php echo $amen_options['submission_note']; ?>"/>
				<label class="description" for="amen_settings[submission_note]"><?php _e('Note appended to submission form', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[public_user]" name="amen_settings[public_user]" type="text" value="<?php echo $amen_options['public_user']; ?>"/>
				<label class="description" for="amen_settings[public_user]"><?php _e('Display name for public user', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[management_title]" name="amen_settings[management_title]" type="text" value="<?php echo $amen_options['management_title']; ?>"/>
				<label class="description" for="amen_settings[management_title]"><?php _e('Title for management list', 'amen_domain'); ?></label>
				<br /><br />
				<?php if ( $amen_options[enable_submit_count] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_enable_submit_count" type="checkbox" name="amen_settings[enable_submit_count]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['enable_submit_count']"><?php _e('Enable javascript submit and count', 'amen_domain'); ?></label>
				<br /><br />
				<?php _e('<strong><em>&nbsp;Add {count}, {count-1}, or {count+1} to display current count. Add {s} to accommodate plural words when count is greater than one. Add {1s} to accomodate verbs when count is equal to one.</em></strong>'); ?><br />
				<input id="amen_settings[submit_text]" name="amen_settings[submit_text]" type="text" value="<?php echo $amen_options['submit_text']; ?>"/>
				<label class="description" for="amen_settings[submit_text]"><?php _e('Submit to counter text <em>(clickable text)</em>', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[submitted_state_one]" name="amen_settings[submitted_state_one]" type="text" value="<?php echo $amen_options['submitted_state_one']; ?>"/>
				<label class="description" for="amen_settings[submitted_state_one]"><?php _e('First state text <em>(if user is not praying)</em>', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[submitted_state_two]" name="amen_settings[submitted_state_two]" type="text" value="<?php echo $amen_options['submitted_state_two']; ?>"/>
				<label class="description" for="amen_settings[submitted_state_two]"><?php _e('Second state text <em>(if user is only one praying)</em>', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[submitted_state_three]" name="amen_settings[submitted_state_three]" type="text" value="<?php echo $amen_options['submitted_state_three']; ?>"/>
				<label class="description" for="amen_settings[submitted_state_three]"><?php _e('Third state text <em>(if user is praying with others)</em>', 'amen_domain'); ?></label>
				<br />
			</p>
			<h4><?php _e('Tweet Settings', 'amen_domain'); ?></h4>
			<p>
				<?php if ( $amen_options[tweet_public_requests] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_tweet_public_requests" type="checkbox" name="amen_settings[tweet_public_requests]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['tweet_public_requests']"><?php _e( 'Allow all visitors to tweet public requests (privilege retained by admin)', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[tweet_via]" name="amen_settings[tweet_via]" type="text" value="<?php echo $amen_options['tweet_via']; ?>"/>
				<label class="description" for="amen_settings[tweet_via]"><?php _e('Tweet via this twitter handle (do not include @)', 'amen_domain'); ?></label>
				<br />

				<label class="description" for="amen_settings[tweet_type]"><?php  _e('Tweet Type', 'amen_domain'); ?></label>
				<select id="amen_settings[tweet_type]" name="amen_settings[tweet_type]">
					<?php  if( 'share_count' == $amen_options['tweet_type'] ) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
						<option <?php  echo $selected; ?> value="share_count">Share Button w/ Counter (shares URL)</option>
					<?php  if ( 'hashtag' == $amen_options['tweet_type'] ) { $selected = 'selected="selected"'; } else { $selected = ''; } ?>
						<option <?php  echo $selected; ?> value="hashtag">Hashtag Button (standalone tweet)</option>
				</select><em>Note: Share button is not tweetable from management page.</em>
				<br />

				<?php if ( $amen_options[hashtag_in_button] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_hashtag_in_button" type="checkbox" name="amen_settings[hashtag_in_button]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['hashtag_in_button']"><?php _e( 'Display hashtag in the tweet button', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[custom_hashtag]" name="amen_settings[custom_hashtag]" type="text" value="<?php echo $amen_options['custom_hashtag']; ?>"/>
				<label class="description" for="amen_settings[custom_hashtag]"><?php _e('Include this custom hashtag in the tweet', 'amen_domain'); ?></label>
				<br />
				<?php if ( $amen_options[prepend_name_to_tweet] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_prepend_name_to_tweet" type="checkbox" name="amen_settings[prepend_name_to_tweet]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['prepend_name_to_tweet']"><?php _e( 'Prepend the name of the prayer requester to the tweet', 'amen_domain'); ?></label>
				<br />
			</p>

			<h4><?php _e('Moderation Settings', 'amen_domain'); ?></h4>
			<p>
				<?php if ( $amen_options[moderate_public_requests] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_moderate_public_requests" type="checkbox" name="amen_settings[moderate_public_requests]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['moderate_public_requests']"><?php _e( 'Require approval for all public requests', 'amen_domain'); ?></label>
				<br />
				<?php if ( $amen_options[moderate_all_requests] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_moderate_all_requests" type="checkbox" name="amen_settings[moderate_all_requests]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['moderate_all_requests']"><?php _e( 'Require approval for all requests', 'amen_domain'); ?></label>
				<br />
				<?php if ( $amen_options[disable_approval_notification] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
				<input id="amen_disable_approval_notification" type="checkbox" name="amen_settings[disable_approval_notification]" value="1" <?php echo $selected; ?> />
				<label class="description" for="amen_settings['disable_approval_notification']"><?php _e( 'Disable all email notifications for requests needing approval', 'amen_domain'); ?></label>
				<br />
				<input id="amen_settings[email_approval_notification_to]" name="amen_settings[email_approval_notification_to]" type="text" value="<?php echo $amen_options['email_approval_notification_to']; ?>"/>
				<label class="description" for="amen_settings[email_approval_notification_to]"><?php _e('Send request notifications only to listed address(es) (comma-separated emails) - disables notifications to admin email', 'amen_domain'); ?></label>
				<br />
			</p>

			<h4><?php _e('Database', 'amen_domain'); ?></h4>
			<p>
				<input id="amen_settings[custom_db_prefix]" name="amen_settings[custom_db_prefix]" type="text" value="<?php echo $amen_options['custom_db_prefix']; ?>"/>
				<label class="description" for="amen_settings[custom_db_prefix]"><?php _e('Enter a custom table prefix to access a different prayer table (table must exist in database)', 'eti_domain'); ?></label>
				<br />
			</p>

			<h4><?php _e('Users Allowed to Post to Pages', 'amen_domain'); ?></h4>
			<p>
				<label class="description" for="amen_settings['allowed_users']"><?php _e( 'Comma-separated list (privilege retained by admin even if not listed)', 'amen_domain'); ?></label><br />
				<textarea id="amen_allowed_users" name="amen_settings[allowed_users]" cols="75" rows="5" /><?php echo $amen_options['allowed_users']; ?></textarea>
			</p>

			<h4><?php _e('Allowed Pages', 'amen_domain'); ?></h4>
			<p>
				<?php
				// LOOP THROUGH AVAILALBE PAGES
				foreach ($amen_all_pages as $amen_page) { 
					if ( $amen_options[allowed_pages][$amen_page->ID] == "1" ) { $selected = 'checked="checked"'; } else { $selected = ''; } ?>
					<nobr><input id="<?php echo $amen_page->ID; ?>" type="checkbox" name="amen_settings[allowed_pages][<?php echo $amen_page->ID; ?>]" value="1" <?php echo $selected; ?> />
					<label class="description" for="amen_settings['allowed_pages'][<?php echo $amen_page->ID; ?>]"><?php _e( $amen_page->post_title, 'amen_domain'); ?></label>&nbsp; | &nbsp;</nobr>
				<?php } ?>
			</p>

			<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Options', 'amen_domain'); ?>" />
			</p>
		</form>
	</div><?php
}
?>