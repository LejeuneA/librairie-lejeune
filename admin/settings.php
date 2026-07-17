<?php

const APP_NAME = 'Librairie Lejeune';
const APP_VERSION = 'v1.0.0';
const DEBUG = false;

/*
|--------------------------------------------------------------------------
| Domain detection
|--------------------------------------------------------------------------
*/

$forwardedProtoHeader = strtolower(
    trim(
        (string) (
            $_SERVER['HTTP_X_FORWARDED_PROTO']
            ?? ''
        )
    )
);

$forwardedProtoParts = explode(
    ',',
    $forwardedProtoHeader
);

$forwardedProto = trim(
    $forwardedProtoParts[0] ?? ''
);

$isForwardedHttps =
    $forwardedProto === 'https';

$isDirectHttps =
    !empty($_SERVER['HTTPS'])
    && strtolower(
        (string) $_SERVER['HTTPS']
    ) !== 'off';

$isHttps =
    $isDirectHttps
    || $isForwardedHttps;

$scheme = $isHttps
    ? 'https'
    : 'http';

/*
|--------------------------------------------------------------------------
| Host validation
|--------------------------------------------------------------------------
*/

$rawHost = trim(
    (string) (
        $_SERVER['HTTP_HOST']
        ?? 'localhost'
    )
);

$host = preg_replace(
    '/[^a-zA-Z0-9.\-:\[\]]/',
    '',
    $rawHost
);

if (
    !is_string($host)
    || $host === ''
) {
    $host = 'localhost';
}

/*
|--------------------------------------------------------------------------
| Project base path
|--------------------------------------------------------------------------
*/

$scriptName = str_replace(
    '\\',
    '/',
    (string) (
        $_SERVER['SCRIPT_NAME']
        ?? ''
    )
);

$directoryName = dirname(
    $scriptName
);

$detectedBasePath = preg_replace(
    '#/(admin|public|datas)(/.*)?$#',
    '',
    $directoryName
);

if (!is_string($detectedBasePath)) {
    $detectedBasePath = '';
}

$basePath = rtrim(
    str_replace(
        '\\',
        '/',
        $detectedBasePath
    ),
    '/.'
);

define(
    'DOMAIN',
    $scheme
        . '://'
        . $host
        . $basePath
);

/*
|--------------------------------------------------------------------------
| Required files
|--------------------------------------------------------------------------
*/

require_once __DIR__
    . '/conf/conf-db.php';

require_once __DIR__
    . '/app/functions/fct-tools.php';

require_once __DIR__
    . '/app/functions/fct-db.php';

require_once __DIR__
    . '/app/functions/fct-ui.php';

/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
*/

if (
    session_status()
    !== PHP_SESSION_ACTIVE
) {
    ini_set(
        'session.use_strict_mode',
        '1'
    );

    ini_set(
        'session.use_only_cookies',
        '1'
    );

    session_name(
        str_replace(
            ' ',
            '',
            APP_NAME
        )
            . '_session'
    );

    session_set_cookie_params([
        'lifetime' => 3600,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    session_start();
}

/*
|--------------------------------------------------------------------------
| Global session values
|--------------------------------------------------------------------------
|
| Bu kontroller session_start() bloğunun dışında olmalı.
| Settings dosyası çağrıldığında session daha önce açılmış olabilir.
|
*/

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
}

if (!isset($_SESSION['IDENTIFY'])) {
    $_SESSION['IDENTIFY'] = false;
}

/*
|--------------------------------------------------------------------------
| Security helpers
|--------------------------------------------------------------------------
*/

function escapeHtml($value): string
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}

function isAuthenticated(): bool
{
    return (
        isset($_SESSION['IDENTIFY'])
        && $_SESSION['IDENTIFY'] === true
        && !empty($_SESSION['user_email'])
        && isset(
            $_SESSION['user_permission']
        )
    );
}

function currentUserPermission(): int
{
    return (int) (
        $_SESSION['user_permission']
        ?? 0
    );
}

function isAdmin(): bool
{
    return (
        isAuthenticated()
        && currentUserPermission() === 1
    );
}

function isGuest(): bool
{
    return (
        isAuthenticated()
        && currentUserPermission() === 2
    );
}

function destroyUserSession(): void
{
    $_SESSION = [];

    if (
        ini_get('session.use_cookies')
    ) {
        $cookieParameters =
            session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            [
                'expires' =>
                time() - 42000,

                'path' =>
                $cookieParameters['path'] ?? '/',

                'domain' =>
                $cookieParameters['domain'] ?? '',

                'secure' =>
                (bool) (
                    $cookieParameters['secure'] ?? false
                ),

                'httponly' =>
                (bool) (
                    $cookieParameters['httponly'] ?? true
                ),

                'samesite' =>
                $cookieParameters['samesite'] ?? 'Strict',
            ]
        );
    }

    if (
        session_status()
        === PHP_SESSION_ACTIVE
    ) {
        session_destroy();
    }
}

function requireLogin(): void
{
    if (!isAuthenticated()) {
        header(
            'Location: '
                . rtrim(DOMAIN, '/')
                . '/admin/login.php'
        );

        exit();
    }

    if (
        !in_array(
            currentUserPermission(),
            [1, 2],
            true
        )
    ) {
        destroyUserSession();

        header(
            'Location: '
                . rtrim(DOMAIN, '/')
                . '/admin/login.php'
        );

        exit();
    }
}

function requireAdminAction(): void
{
    requireLogin();

    if (!isAdmin()) {
        header(
            'Location: '
                . rtrim(DOMAIN, '/')
                . '/admin/manager.php?readonly=1'
        );

        exit();
    }
}

/*
|--------------------------------------------------------------------------
| Database connection
|--------------------------------------------------------------------------
*/

$conn = connectDB(
    SERVER_NAME,
    USER_NAME,
    USER_PWD,
    DB_NAME
);
