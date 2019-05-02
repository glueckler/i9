<?php

define('WP_HOME','http://i9design.peteprogr.zone');
define('WP_SITEURL','http://i9design.peteprogr.zone');
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
define('DB_NAME', 'mebsntcc_wp744');

/** MySQL database username */
define('DB_USER', 'mebsntcc_wp744');

/** MySQL database password */
define('DB_PASSWORD', 'b28pS5-1B!');

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
define('AUTH_KEY',         'cm8xc5iyw8vxj1whqmmgfohjcg5imof73b8utsz9oy6smt6iqujjgo0i7xzztlvz');
define('SECURE_AUTH_KEY',  'cqb553bz1xsipfd9f9yxvrekmfzc7iht1zclrymfh0hwkqry8knxdv4w2wog3obg');
define('LOGGED_IN_KEY',    'wxckceqyg7bspxcqvp9mvcpbookxn17arksyqdms26ncbcmwmb2djc04mfm7cnmw');
define('NONCE_KEY',        'dli4msvdwlyqywyqhi3hixm1riidgcq5w1cvsg0wn9xduaxrpspru8eex07kuyga');
define('AUTH_SALT',        'wefullhrsqenkr9ysjlumxqhrye4cdjbohiwkk1lt7cs54fyimutudhp2zzgnbjw');
define('SECURE_AUTH_SALT', 'njt14xlwamz64no6fyjk6c1bn3huoxokjyyfat1d6hx203wz7razztfwuch7cgqv');
define('LOGGED_IN_SALT',   'upzaclyifugd43gfvloz9pc95okyxjiwskwu4iru0c8qhkvuhhz0llv8onjyjlmk');
define('NONCE_SALT',       'dozrdtmd5c90ogdpp1kcqgw8ggc99ohmvpg7h9eniclhfhjyorxfgeehvrsburmc');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpcb_';

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
