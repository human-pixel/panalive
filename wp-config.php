<?php require_once($_SERVER['DOCUMENT_ROOT'].'/redirect.php');
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/lumixpropanasoni/public_html/wp-content/plugins/wp-super-cache/' );
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'lumixpro_ci' );

/** MySQL database username */
define( 'DB_USER', 'lumixpro_ci' );

/** MySQL database password */
define( 'DB_PASSWORD', 'w?u.Ls[pSKsC' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'K$J:7Cu(q5<@,U3l =@e^M3w3JO`COuEHCKHR![&X:T88F)RT)mBaZB y,&GIf*V' );
define( 'SECURE_AUTH_KEY',  'B,;c-27ad;&H3b6.RYD_I% ib(b(_sod;1#VrZ%rATb;1tbUyULP:eY;ng5A.cB}' );
define( 'LOGGED_IN_KEY',    '7P%XA)]AH)i yUW3{imftg;DlPJI.1=!fM#i;2nZ931K^[IPp#uS6Je$S(A-mL9=' );
define( 'NONCE_KEY',        '|Q`Lx4@URlR ~:7{*ZjS(gEorA*cN[KY^PUp(hUi[%#A2RcI=,s}1%$ jLQk=O32' );
define( 'AUTH_SALT',        'LJ47S%=31FLBPHYoxy5(=41 4L=5is[8G`i$78F-kI-D$#4yPBD+;a`NsIf*Ymy0' );
define( 'SECURE_AUTH_SALT', '=5*OcAO>,j*N2y_Q!h$j}dI`V(1xf[cx$OF14OM7P9~Jf]_59C{=#mS?.D)7[]JI' );
define( 'LOGGED_IN_SALT',   'z;cvb,p*Q<[ >Bo#LJg)8Se~kj5530(8X%q`EP:&lQ=$e][)P9A[`_JL^)PU J=r' );
define( 'NONCE_SALT',       'cH=2c<{^}VC}v#?o !Kc|qjG ,htS8IMv@6S_)XJfK)iUoJ9LO4@+<FJ.1.]_uA=' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';