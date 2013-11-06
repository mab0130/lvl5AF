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
$services = getenv("VCAP_SERVICES");
$services_json = json_decode($services,true);
$mysql_config = $services_json["mysql-5.1"][0]["credentials"];
define('DB_NAME', $mysql_config["name"]);
define('DB_USER', $mysql_config["user"]);
define('DB_PASSWORD', $mysql_config["password"]);
define('DB_HOST', $mysql_config["hostname"]);
define('DB_PORT', $mysql_config["port"]);

// define('DB_NAME', 'wordpress');

/** MySQL database username */
// define('DB_USER', 'wordpress');

/** MySQL database password */
//define('DB_PASSWORD', '9zihuruk');

/** MySQL hostname */
//define('DB_HOST', '192.168.16.215');

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
define('AUTH_KEY',         'H|xgey7zsJYL@>.u242T=eva(%|Dg,J+sbF JKmA-jP|9qo.]2q;^5Wk2%T:DptP');
define('SECURE_AUTH_KEY',  'NYwwr@0wc~^cIkkJz/0T/YHiGEq5e,rP>m7yA(BQ^z&hmHNJ^6N@ HVUwn`:`hV1');
define('LOGGED_IN_KEY',    'U8y-(NX;>1]h[eagBe_.FH}cY-%(-;Q/VTO+=:gX-3m4;=utXO#}nKg}7*3c @T&');
define('NONCE_KEY',        'dbF}MCD[u+OM<9Gk?:*KPXIEl++`-PNug=9!AGIPK^l_zEVHomVxJ*1;$~&C@(.M');
define('AUTH_SALT',        'Ab-${-dkw]h#YZY4+#Mrp?jaz?|5h.>Q!:7`NH9PO;,F-2|o9@00^xrWT-K]bKS!');
define('SECURE_AUTH_SALT', '{J}*ZlVRLn{poI[a502_+^CpZrxr@oOL1lJpRSu!f`9+G8oxWYW@O@-BH5x#F`%>');
define('LOGGED_IN_SALT',   'Yp~Ln_kHh0+ #P4qfcUhxc::i{ -FU$8(JexMa/uy70IVjQ6~)U+]X7Lbn[|(b-;');
define('NONCE_SALT',       'L3`:yDcbL-cD?FJ+QYc][I>Hy_V-Iq3=T0b=3{J1`LL}@?ugbMxQ@~DQBul}4CAr');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
