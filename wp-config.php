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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'XOsMHLKnIVmlGZkT2LcjmnRNPyn3GBbyrbF+fkzEPEXAsiEbTybsJOEiC4UeRSGHgDtcq2zko5dPP76pLEG2Zg==');
define('SECURE_AUTH_KEY',  'fdy/ACSXDZUSHsccro3C9snG9452iHMkD32aIUf4H4VblHXN5xS2WGGFiULvc8wtc0txuDL9TPgMGCjdrNfWEQ==');
define('LOGGED_IN_KEY',    'GnMruIaT/cDBERELSKkV9LpWvdAdYrgO1xIjTPgQTQ9h+v79GZyC4k60gqE5tS9UlcATgV46Cu2bJcUJUqB6iA==');
define('NONCE_KEY',        't1fgMJk88nN1b7j6A+V/2mSNx1br/SmwqXK1uGDO1kfKI5o0hRqOM/KjiOkQ/akQUjgZif5JPEsOyufvC8007Q==');
define('AUTH_SALT',        'zH5MH2v08m2VjdEFuO3nJ4wJVfx/aC3A2fXCjdQblk/dN0qcjlkyQH8KPLQ2GKW6l2M+Oy5184WvA3F72ACMqQ==');
define('SECURE_AUTH_SALT', '+D9cM+NVvsYN0kJaiQbGf5EIBSlfmY7SXzm+zQQyAg5Lzu0FHfmWuJ1sZIc9Lq5phK3tx8n3KoKepmOv2BCjfg==');
define('LOGGED_IN_SALT',   'ElTOfuLSLkIVfAGQCljDiIOhOp8UnJdWQU8BkUXRbq63T+IMjzVMo2jQGCEjCHbgEOZc2YeOra+xscnpS4ibCQ==');
define('NONCE_SALT',       'q3Ivv/5rZw+yKn0IlMCg6yZxJDKgyXrDzP0BjJQe4YBSqv5inGfn7Vn1PbQktEG6/lmfbOHZ5a1R4P2kjzUiVA==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
