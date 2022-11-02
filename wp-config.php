<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'avocado' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '#-::{9aSws4hs(AP(W%m$*gv<:IoXeGfn]YK?b7 ET?jv1W0QLoj)IJ6H:/Pn]RE' );
define( 'SECURE_AUTH_KEY',  '[!T Mja$(G69F5~AUFZkU8nf[4ZQp(i^T+[HT7mkI(@W3*3DisDO&]A$E7n5<f-F' );
define( 'LOGGED_IN_KEY',    'tD5o`tD?7e^rI0Db<Rc1L-s&WnA#9_peO+?`H0F ?(0~L Wc0Lk4Jl1wO_q`m:F5' );
define( 'NONCE_KEY',        'Qg1WeuB)1(2?h;s]$pB:7BHd|kwbNZn8GCS]]N&0%v:@V=$v3N0#ZsbiZmJr<=+G' );
define( 'AUTH_SALT',        'Nvm4` =U5>*Yt?vX!x[mqyQ+o?vEsO)0&PDc;GR&l|HHYl%lEmg}T4+;D^4y!8Y/' );
define( 'SECURE_AUTH_SALT', ']f}O93k9r([~g6x^fU8HS~xu*.u$T5&W_$xk!gg,X!E1MmByD*W//A:x$f!XRz5Z' );
define( 'LOGGED_IN_SALT',   'OKcFRMe86cmxX?oL<=42:pTs!(mF[2Zh7eYPM//{74t5j$3mEiNp4d2R|@Qo?|*n' );
define( 'NONCE_SALT',       'c!VB/g%`uX*U;`h)7j +fJt!=$OY/+;<^Gr>U-q>zX+N4XsbaU<$uh {~$@FW:k^' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
