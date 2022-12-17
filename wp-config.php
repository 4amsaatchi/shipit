<?php

/*ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);*/
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'shipit' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'desarrolloSaatchi2019!' );

/** Database hostname */
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
define( 'AUTH_KEY',         'VKbUDXH}m^lR1QdF5UeTd$0yLF)SKlV<wb]AIEpe{}d-D!+Eac,+mS[JOPM(!/W-' );
define( 'SECURE_AUTH_KEY',  'M)0(%y&T#4F;dtxGgD;a3vldnoG3:4JHY|,n@-hZ,hasz72F/hL(rvTn5y+J*otb' );
define( 'LOGGED_IN_KEY',    ';=h,}cy<HjCxw#w&wG4UU[jb6w]FW0w=TLwFy2p ~?WyGJWD~b[_KEMa_slm>fG4' );
define( 'NONCE_KEY',        ' uLha6vN^OkVgH?`YKk$PipB:L2,Z2W;,S2hJv<rq4nLo>MSEvyPPyyZgPyd1RYp' );
define( 'AUTH_SALT',        'q8wgm(Z|!<TVYZmqANO&+X^GM[x>heLB@g3Q$>xA3H1=82DnII,&g=|:EuMCKx|8' );
define( 'SECURE_AUTH_SALT', 'X|hRx]?!iE/)hU~AKf-yewR%l^~U4LIIQwM2CxH]rcEKmjg<T|<lpc5+PxaH9&GN' );
define( 'LOGGED_IN_SALT',   'jnd#U1?5o]T4mWz_}1reCXd*2!8(]F8fo70<=h 7eX.M?5nMrVTb7?2 g#@X@G5s' );
define( 'NONCE_SALT',       'LolP2;do{WI%Msf}$E|r`)q5210QfkQJx?*M*_L-zAaZ67j`aCk(v0`]q-6{C~(3' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
