<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'minurgij_wp');

/** MySQL database username */
define('DB_USER', 'minurgij_wp');

/** MySQL database password */
define('DB_PASSWORD', '3={7i+Rh[Gdq');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '( 8+!SKU)Y[|C`df-ogfU/m9#Zc*vxOeeTcAvRAx1)x?ZH)}N$9o jJdQed]@u^Q');
define('SECURE_AUTH_KEY',  'I:0V8un?uCkNaRvGRf#!$lXAG18>[mi8h#|=P]u-sb$UCggc)I?Wc|@jg+SU~yil');
define('LOGGED_IN_KEY',    'y1XBC9 h>tH-;!pi<!<Z n|JBdJs8xuOH9U,j2F+D*H^rh-*q,]O]=q9_{x --kM');
define('NONCE_KEY',        'H|uw?P];r+v9L*>ECJiev~a9KOy<SMk45!rsB7R|[DeqI+T$0>VuQ#<K~jOp{b4*');
define('AUTH_SALT',        '37S%6%JXBYhpHdaGgE?!1J|YOM3(1T:+BOt~i7xW:ET[e_+_*-ln{/|aoAPZPp$~');
define('SECURE_AUTH_SALT', 'lqw 6RN3<NkRx;pBNB-nJW:i=B_:Ta[Z]-m%/3-Z}$9W#+(<:)&QKdR4CigV0an6');
define('LOGGED_IN_SALT',   'IfdDW7?m3 <<t5of0SRd_T[v:lY-?:1m#w*>O3AD<-C-.mJ+_H<Zl11_llsm <4k');
define('NONCE_SALT',       '.R`sl@,<:nhX]28yFB0gLOzK<w Q%$(`DwqrPe$:1W9l?2rr=5rYkWOC}W&adgX+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');