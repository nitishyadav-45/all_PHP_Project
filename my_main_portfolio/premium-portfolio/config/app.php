<?php
declare(strict_types=1);

define('APP_NAME', 'Nova Portfolio');
define('APP_ENV', getenv('APP_ENV') ?: 'production');
define('APP_TIMEZONE', getenv('APP_TIMEZONE') ?: 'UTC');
define('CONTACT_NOTIFICATION_EMAIL', getenv('CONTACT_NOTIFICATION_EMAIL') ?: 'admin@example.com');
define('MAX_UPLOAD_SIZE', 4 * 1024 * 1024);
define('ROOT_PATH', dirname(__DIR__));

date_default_timezone_set(APP_TIMEZONE);

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$basePath = preg_replace('#/(admin|actions)$#', '', $scriptDir);
$basePath = rtrim((string) $basePath, '/');
if ($basePath === '.' || $basePath === '/') {
    $basePath = '';
}
define('BASE_URL', $basePath);

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.cookie_httponly', '1');
    ini_set('session.cookie_samesite', 'Lax');

    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_name('nova_portfolio_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => BASE_URL === '' ? '/' : BASE_URL . '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

