<?php
/**
 * WordPress Configuration
 *
 * DO NOT add API Keys, secrets, etc. here directly. Define the constant used in the application here and
 * use getenv_docker('') to get the ENV variable from the server.
 */

// a helper function to lookup "env_FILE", "env", then fallback
if (!function_exists('getenv_docker')) {
    // https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
    function getenv_docker($env, $default = '')
    {
        if ($fileEnv = getenv($env.'_FILE')) {
            return rtrim(file_get_contents($fileEnv), "\r\n");
        } else {
            if (($val = getenv($env)) !== false) {
                return $val;
            } else {
                return $default;
            }
        }
    }
}

/**
 * The environment type
 */
define('WP_ENVIRONMENT_TYPE', getenv_docker('WP_ENVIRONMENT_TYPE'));

/**
 * For developers: WordPress debugging mode.
 */
define('WP_DEBUG', getenv_docker('WP_DEBUG') === 'true');
define('WP_DEBUG_HIDE_DEPRECATED', getenv_docker('WP_DEBUG_HIDE_DEPRECATED') === 'true');
define('SCRIPT_DEBUG', getenv_docker('WP_DEBUG') === 'true');
define('WP_DEBUG_LOG', getenv_docker('WP_DEBUG_LOG') === 'true');

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
    $_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

/**
 * Autosave configuration
 */
define('AUTOSAVE_INTERVAL', getenv_docker('AUTOSAVE_INTERVAL') ?? 60);

/**
 * Database
 */
define('DB_NAME', getenv_docker('DB_NAME'));
define('DB_USER', getenv_docker('DB_USER'));
define('DB_PASSWORD', getenv_docker('DB_PASSWORD'));
define('DB_HOST', getenv_docker('DB_HOST'));
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$table_prefix = 'wp_';

/**
 * Authentication Unique Keys and Salts.
 */
define('AUTH_KEY', getenv_docker('AUTH_KEY'));
define('SECURE_AUTH_KEY', getenv_docker('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', getenv_docker('LOGGED_IN_KEY'));
define('NONCE_KEY', getenv_docker('NONCE_KEY'));
define('AUTH_SALT', getenv_docker('AUTH_SALT'));
define('SECURE_AUTH_SALT', getenv_docker('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', getenv_docker('LOGGED_IN_SALT'));
define('NONCE_SALT', getenv_docker('NONCE_SALT'));

/**
 * Disable default cron behaviour
 */
define('DISABLE_WP_CRON', true);

/**
 * WP Cache
 */
define('WP_CACHE', 'true');
define('WPCACHEHOME', getenv_docker('WPCACHEHOME'));

/**
 * Disable WP Admin file editing
 */
define('DISALLOW_FILE_EDIT', true);

/**
 * Disable Auto Updates
 */
define('AUTOMATIC_UPDATER_DISABLED', true);

/**
 * Offload Media - AWS S3
 */
$as3cf_settings = [
    'provider' => getenv_docker('AS3CF_PROVIDER'),
    'bucket' => getenv_docker('AS3CF_BUCKET'),
    'region' => getenv_docker('AS3CF_REGION'),
    'copy-to-s3' => getenv_docker('AS3CF_COPY_TO_S3') === 'true',
    'serve-from-s3' => getenv_docker('AS3CF_SERVE_FROM_S3') === 'true',
    'remove-local-file' => getenv_docker('AS3CF_REMOVE_LOCAL_FILE') === 'true',
];

if (getenv_docker('AS3CF_USE_SERVER_ROLES') === 'true') {
    $as3cf_settings['use-server-roles'] = getenv_docker('AS3CF_USE_SERVER_ROLES') === 'true';
} else {
    $as3cf_settings['access-key-id'] = getenv_docker('AWS_S3_ID');
    $as3cf_settings['secret-access-key'] = getenv_docker('AWS_S3_SECRET');
}

if (getenv_docker('AS3CF_DELIVERY_PROVIDER')) {
    $as3cf_settings['delivery-provider'] = getenv_docker('AS3CF_DELIVERY_PROVIDER');  // Delivery Provider ('storage', 'aws', 'do', 'gcp', 'cloudflare', 'keycdn', 'stackpath', 'other')
    $as3cf_settings['deliver-provider-name'] = getenv_docker('AS3CF_DELIVER_PROVIDER_NAME'); // Custom name to display when using 'other' Delivery Provider
    $as3cf_settings['delivery-domain'] = getenv_docker('AS3CF_DELIVERY_DOMAIN');
    $as3cf_settings['enable-delivery-domain'] = getenv_docker('AS3CF_ENABLE_DELIVERY_DOMAIN') === 'true';
}

define('AS3CF_SETTINGS', serialize($as3cf_settings));

/**
 * EWWW Overrides
 */
define('EWWW_IMAGE_OPTIMIZER_EXCLUDE_PATHS', explode(',', getenv_docker('EWWW_IMAGE_OPTIMIZER_EXCLUDE_PATHS')));
define('EWWW_IMAGE_OPTIMIZER_DISABLE_CONVERT_LINKS',
    getenv_docker('EWWW_IMAGE_OPTIMIZER_DISABLE_CONVERT_LINKS') === 'true');
define('EWWW_IMAGE_OPTIMIZER_WEBP_FORCE', getenv_docker('EWWW_IMAGE_OPTIMIZER_WEBP_FORCE') === 'true');
define('EWWW_IMAGE_OPTIMIZER_WEBP', getenv_docker('EWWW_IMAGE_OPTIMIZER_WEBP') === 'true');
define('EWWW_DISABLE_ASYNC', getenv_docker('EWWW_DISABLE_ASYNC') === 'true');

/*
 * WP Mail SMTP
 */
define('WPMS_ON', true);
define('WPMS_LICENSE_KEY', getenv_docker('WPMS_LICENSE_KEY'));
define('WPMS_MAIL_FROM', getenv_docker('WPMS_MAIL_FROM'));
define('WPMS_MAIL_FROM_FORCE', getenv_docker('WPMS_MAIL_FROM_FORCE') === 'true');
define('WPMS_MAIL_FROM_NAME', getenv_docker('WPMS_MAIL_FROM_NAME'));
define('WPMS_MAIL_FROM_NAME_FORCE', getenv_docker('WPMS_MAIL_FROM_NAME_FORCE') === 'true');
define('WPMS_MAILER', getenv_docker('WPMS_MAILER'));
define('WPMS_SET_RETURN_PATH', getenv_docker('WPMS_SET_RETURN_PATH'));
define('WPMS_DO_NOT_SEND', getenv_docker('WPMS_DO_NOT_SEND') === 'true');
define('WPMS_SMTP_HOST', getenv_docker('WPMS_SMTP_HOST'));
define('WPMS_SMTP_PORT', getenv_docker('WPMS_SMTP_PORT'));
define('WPMS_SSL', getenv_docker('WPMS_SSL'));
define('WPMS_SMTP_AUTH', getenv_docker('WPMS_SMTP_AUTH') === 'true');
define('WPMS_SMTP_USER', getenv_docker('WPMS_SMTP_USER'));
define('WPMS_SMTP_PASS', getenv_docker('WPMS_SMTP_PASS'));
define('WPMS_SMTP_AUTOTLS', getenv_docker('WPMS_SMTP_AUTOTLS') === 'true');

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__.'/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH.'wp-settings.php';

