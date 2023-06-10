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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'elementor-task' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         '7`0XuQcXtv!j7Bgjidqs#_Pup7V#Wegy[T HQS&O%7]o)t`gA8E|9qK9$jLwv&Oi' );
define( 'SECURE_AUTH_KEY',  'ty8<?tPq;Zh6G#XQ$n!6QOd8lf<kIgm|%JG#)wjZpx ,o$E1zA}t;O`P5cJe*1U4' );
define( 'LOGGED_IN_KEY',    '(9=v~I^=}6s^,X}Tt.s@1XL$,qVWd`>)[D?XkQ:@UgC+Q2,F9mJh)=h^S,Fil H+' );
define( 'NONCE_KEY',        '/YOiu)ffsE56G(9{o]*wn3VO{b@$jUq9K=R?HVCN}9Mri5;r#9i%wVf50xRG*ip(' );
define( 'AUTH_SALT',        'pjVN&Y=vq[mL}KU]g!ligzl(Bm>}F$~Dm_-Jpm.wW`hFL,;JJ`<ec/ICmq)H!ch0' );
define( 'SECURE_AUTH_SALT', 'cd!?$TpFROe}e^M[:n/G.n2Hb3shJAcH^#m3oA]z?<8MK^%kg}HhMHyj]mD_gB)O' );
define( 'LOGGED_IN_SALT',   '[a.n|hWNZyRSQVj0/rC:4]Qo?oV=vd!Y,uyj%YDsmor$zWg`-u3-IkqhP%UjixmJ' );
define( 'NONCE_SALT',       'w,yQ^5a:64FSCA0Ur|N@Y#9h#I3%_w!DR_A&!fs0*!Z-K:NYGB*1.nBQik?Ggxso' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
