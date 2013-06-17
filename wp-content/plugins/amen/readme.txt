=== Amen ===
Contributors: UaMV
Donate link: http://wmpl.org/blogs/vandercar/give
Tags: prayer, pray, amen, mission, church, christian, twitter, tweet, custom
Requires at least: 3.0
Tested up to: 3.5
Stable tag: trunk
License: MIT
License URI: http://www.opensource.org/licenses/mit-license.php

Prayer request management with counter. Alternatively, can be used as custom tweet platform.

== Description ==

The Amen plugin adds prayer request, custom tweet, custom counter functionality to WordPress.

View additional documentation and examples [here](http://wmpl.org/blogs/vandercar/wp/amen/ "Amen Documentation").

= Shortcode =

> **[amen]**<br /><br />
> **Description:** List and/or manage prayer requests.<br />
> **Attributes:**<br />
> type="_manage_" (Displays management form and list. Also on admin page.)<br />
> exclude="_[options:author,counter,tweet]_" (Comma-separated options exclude elements from display)<br />
> page="_page-id_" (Lists prayers tagged with a specific page id.)<br />
> author="_username1,username2_" (Comma-separated authors limits list.)<br />
> count="_integer_" (Integer value lists specific number of requests.)<br />
> title="_text_" (Displays title for list.)<br />
> random="true" (Selects random requests and random order. Best used with count.)<br />
> id="_AmenID1,AmenID2_" (Comma-separated ids to include.)<br />
> noid="_AmenID1,AmenID2_" (Comma-separated ids to exclude.)<br />
> submit="_text_" (Override counter submit text. Accepts {count}, {count-1}, {count+1}, {s}, {1s})<br />
> state1="_text_" (Override counter state one. Accepts {count}, {count-1}, {count+1}, {s}, {1s})<br />
> state2="_text_" (Override counter state two. Accepts {count}, {count-1}, {count+1}, {s}, {1s})<br />
> state3="_text_" (Override counter state three. Accepts {count}, {count-1}, {count+1}, {s}, {1s})<br />

= Custom Settings =

> **Privacy:** Public posting | Post Privatization (visible to logged in users)<br />
> **Displayed Text:** author display | submission form (title, button, note) | public user name | title for management form<br />
> **Javascript Submit/Count:** enable/disable | displayed text<br />
> **Tweet Settings:** allow/disallow tweeting | tweet via | tweet type (hashtag or page share) | add hashtag | customize hashtag | add author name<br />
> **Moderation:** require approval for all public requests | require approval for all requests | disable approval notifications | set custom email(s) for approval notifications<br />
> **Database:** disable auto-confirmation prayer | custom table prefix (advanced: i only use this to integrate across a multi-site and single-site install)<br />
> **Users Allowed to Post to Pages:** comma-separated list of usernames<br />
> **Allowed Pages:** check available pages

== Installation ==

1. Upload the `amen` directory to your `/wp-content/plugins/`
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Add the [amen type="manage"] shortcode in order to allow front-end logged users to manage requests.
1. Add the [amen] shortcode in order to list requests.

== Screenshots ==

1. Prayer Request List
2. Prayer Request Management
3. Amen Settings Page

== Frequently Asked Questions ==

= Why does the submission form not show? =

You may still need to enable public posting from the settings page. Alternatively, you may have an early version of the plugin which used the shortcode [amen_manage]. This shortcode should be changed to [amen type="manage"].

== Changelog ==

= 2.1.0 =
* Added UTF-8 support

= 2.0.8 =
* Added shortcode parameters

= 2.0.7 =
* Customization of approval notifications

= 2.0.4 =
* Fixed Twitter share button to include link to request
* Disables widget (not working)

= 2.0.3 =
* Added Amen widget

= 2.0.2 =
* Add shortcode parameter to list request by id

= 2.0.1 =
* Customization options
* Allow editing of posted requests
* Admin notification on new request/update/edit
* Additional shortcode parameters

= 1.0.2 =
* Additional Tweet options
* Fixed call to database table
* Added randomizing attribute to shortcode

= 1.0.1 =
* Added Twitter integration
* Allows custom database table prefix for connecting on multisite install

= 0.3.0 =
* Added functionality for public users to post requests *
* Added request approval option *
* Added data sanitization *

= 0.2.1 =
* Rewrote install/update functions
* Minor changes to shortcode

= 0.0.1 =
* Initial Release

== Upgrade Notice ==

= 2.1.0 =
* Adds UTF-8 support

= 2.0.8 =
* Adds shortcode parameters (noid, exclude, submit, state1, state2, state3) and extends 'id' parameter

= 2.0.7 =
* Allows customization of approval notifications (disable and send-to)

= 2.0.4 =
* Fixed Twitter share button to include link to request

= 2.0.3 =
* Adds Amen widget (Note: if updating from 1.0.2 or earlier, check settings and shortcodes)

= 2.0.2 =
* Please, check settings and shortcode, if you encounter troubles after update (New manage shortcode: [amen type="manage"])

= 2.0.1 =
* NOTICE: This update will reset your options. Check options and shortcodes after update. (New manage shortcode: [amen type="manage"])

= 1.0.2 =
* Additional Tweet options
* Fixed call to database table
* Added randomizing attribute to shortcode

= 1.0.1 =
* Added Twitter integration
* Allows custom database table prefix for connecting on multisite install

= 0.3.0 =
* Additional functionality and data sanitization

= 0.2.1 =
* Fixes database table creation
