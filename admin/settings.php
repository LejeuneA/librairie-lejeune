<?php

// Application settings and bootstrap.
const APP_NAME = 'Librairie Lejeune';
const APP_VERSION = 'v1.0.0';
const DEBUG = false;

// Build the site URL from the current request so it works locally and online.
$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$scheme = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$basePath = preg_replace('#/(admin|public|datas)(/.*)?$#', '', dirname($scriptName));
$basePath = rtrim(str_replace('\\', '/', $basePath), '/.');
define('DOMAIN', $scheme . '://' . $host . $basePath);

require_once __DIR__ . '/conf/conf-db.php';
require_once __DIR__ . '/app/functions/fct-db.php';
require_once __DIR__ . '/app/functions/fct-ui.php';
require_once __DIR__ . '/app/functions/fct-tools.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_name(str_replace(' ', '', APP_NAME) . '_session');
    session_set_cookie_params([
        'lifetime' => 3600,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);
    session_start();
}

if (!isset($_SESSION['IDENTIFY'])) {
    $_SESSION['IDENTIFY'] = false;
}

$conn = connectDB(SERVER_NAME, USER_NAME, USER_PWD, DB_NAME);
