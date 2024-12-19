<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost:3306');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         '6W.Am%jGHY_9ytwowN,z-)4|f8xaU{9n1E^Gi(,+8nZCq]~L=_0cIO &l0n!(ReM');
define('SECURE_AUTH_KEY',  '0aIgY#n(`*=bX@qG1IQqlZ$5p8q@-,+8_JsA!zmFwpR!Cy}oE8H8vQn5Osko.08_');
define('LOGGED_IN_KEY',    'b%5LS9rgZf-+Eg~oBGs5pk1g-{Ga<}!0*-%ml:#q/y 6&mhNDq!~!R.cX?%_{[)R');
define('NONCE_KEY',        'p2TlBL:!.Vyf<rJEaLc+48&[W[svqsON=cuSa@kA]c/40X H2_69DzXNKWIOBYC-');
define('AUTH_SALT',        'Is<?%?:cv>pg>sfCjJ~@H_#i<y5Bd>VQ60}sayUY-cf3]uVd8jfnRhr*}b=l);ig');
define('SECURE_AUTH_SALT', 'xYL$.TZaskc|c>YG!NW7!KdhLys(aB,6QEfrGT5J($h/Ad#KwS[}hw<@`)Ny)><+');
define('LOGGED_IN_SALT',   '_P:O{<jEG{tySt=$(aRm[d?*vFyJBP~I0[ySi|7E=@g{uL^h({S/CYCdsWqc7F[<');
define('NONCE_SALT',       '}B(nw#J>7mv@*R;`(;%]p+rY$_%yB]|N~Y2uW;~e@M.$UZ0#F.lP ak81Q$o=W*+');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';