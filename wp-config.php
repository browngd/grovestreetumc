<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'grovestreetumc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'HAkr3@$|]O)3Xs|oNJ %xq>WQ9p-?yQbYb)Z+UE }V-4QHk48;zvU(SrLLBmPg>!');
define('SECURE_AUTH_KEY',  'Ve@+xj>_L*FwXtLG5/D]|[CO?q#:v{_ {2LN BDBH_P4_;-OLz&ypHP[v5e6S(2.');
define('LOGGED_IN_KEY',    'cGAGx7*ctG-mAR~F5|oqQS3M99Hy)wQTMmynqV/O%v#vDJ? 25,2+[Y:bUGK#F:q');
define('NONCE_KEY',        '[6J-FJEVb57j!16X,R(?Y93Q+cH+Jv# {+k`zttc+a5{YLVMyrW,:E`BDW}#Pz!H');
define('AUTH_SALT',        'uWR/b{cTZ}%O=5M|m_RR2vy+_~h^f95nYGZWyCpy*RNXIDH*1gi@0KtQ3DRU(wXl');
define('SECURE_AUTH_SALT', ' q]q][2/>te3_=SbVXE]*+f[t&WXv~|/?(r#p[=y~p_m_7| F5Is$&j|j-!$8e{[');
define('LOGGED_IN_SALT',   '-QLQ]_b D2;u6tB(S_FJX6] &L>Xq#Z3[kk=B4{`cHk DF7(Gz;|^^9$9pWFBlL[');
define('NONCE_SALT',       '.Z0F+R:F+C=4`%j5SKz/Qqdau)Qk}+M}aW;j%2P+A;5L|f66eKz2$&*gfz$?al|[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gs_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
