<?php

$localConfigPath = __DIR__ . '/conf-db.local.php';

$productionConfigPath =
    '/home/acelyalejeune/private/librairie-lejeune-db.php';

if (is_file($localConfigPath)) {
    $configPath = $localConfigPath;
} elseif (is_file($productionConfigPath)) {
    $configPath = $productionConfigPath;
} else {
    error_log('Librairie Lejeune database configuration was not found.');

    http_response_code(500);
    exit('Database configuration is unavailable.');
}

$config = require $configPath;

$requiredKeys = [
    'host',
    'user',
    'password',
    'database',
];

foreach ($requiredKeys as $requiredKey) {
    if (
        !array_key_exists($requiredKey, $config)
        || !is_string($config[$requiredKey])
    ) {
        error_log(
            'Invalid Librairie Lejeune database configuration.'
        );

        http_response_code(500);
        exit('Database configuration is invalid.');
    }
}

define('SERVER_NAME', $config['host']);
define('USER_NAME', $config['user']);
define('USER_PWD', $config['password']);
define('DB_NAME', $config['database']);
