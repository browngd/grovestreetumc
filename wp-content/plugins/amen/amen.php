<?php
/*
Plugin Name: Amen
Plugin URI: http://wmpl.org/blogs/vandercar/wp/amen
Description: Prayer request management with counter. Alternatively, can be used as custom tweet platform.
Version: 2.1.0
Author: Joshua Vandercar
Author URI: http://wmpl.org/blogs/vandercar
*/
?>
<?php
/*  === Amen ===
    Copyright 2012 World Mission Prayer League (wmpl.org)
    Revision of Pray With Us by Brendan Ribera

    Permission is hereby granted, free of charge, to any person obtaining
    a copy of this software and associated documentation files (the
    "Software"), to deal in the Software without restriction, including
    without limitation the rights to use, copy, modify, merge, publish,
    distribute, sublicense, and/or sell copies of the Software, and to
    permit persons to whom the Software is furnished to do so, subject to
    the following conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
    MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
    LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
    OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
    WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/**************************************
* INITIALIZE SETTINGS AND INCLUDES
**************************************/

define( 'AMEN_VERSION', '2.1.0' );
define( 'AMEN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

global $wpdb;

global $amen_plugin_name;
$amen_plugin_name = 'Amen';
global $amen_prefix;
$amen_prefix = 'amen_';

global $amen_options;
$amen_options = get_option( 'amen_settings' );

global $amen_db_prefix;
( '' == $amen_options['custom_db_prefix'] || ! $amen_options['custom_db_prefix'] ) ? $amen_db_prefix = $wpdb->prefix : $amen_db_prefix = $amen_options['custom_db_prefix'];

require_once dirname( __FILE__ ) . '/setup.php';
require_once dirname( __FILE__ ) . '/admin.php';
include_once dirname( __FILE__ ) . '/amen-submit-prayer.php';
include_once dirname( __FILE__ ) . '/amen-list-requests.php';
//include_once dirname( __FILE__ ) . '/amen-widget.php';
require_once dirname( __FILE__ ) . '/db.php';

require_once ABSPATH . WPINC . '/post-template.php';
require_once ABSPATH . WPINC . '/pluggable.php';

?>
