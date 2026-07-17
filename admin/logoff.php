<?php

require_once __DIR__ . '/settings.php';

/*
|--------------------------------------------------------------------------
| Preserve cart before logout
|--------------------------------------------------------------------------
*/

$cart = [];

if (
    isset($_SESSION['cart'])
    && is_array($_SESSION['cart'])
) {
    $cart = $_SESSION['cart'];
}

/*
|--------------------------------------------------------------------------
| Clear authenticated session data
|--------------------------------------------------------------------------
|
| Oturumu tamamen yok etmiyoruz çünkü sepeti aynı tarayıcı
| oturumunda korumak istiyoruz.
|
*/

session_unset();

/*
|--------------------------------------------------------------------------
| Generate a fresh session ID
|--------------------------------------------------------------------------
|
| Eski oturum kimliğini geçersiz kılar ve session fixation
| riskini önler.
|
*/

session_regenerate_id(true);

/*
|--------------------------------------------------------------------------
| Restore public session data
|--------------------------------------------------------------------------
*/

$_SESSION['IDENTIFY'] = false;
$_SESSION['cart'] = $cart;
$_SESSION['csrf_token'] = bin2hex(
    random_bytes(32)
);

/*
|--------------------------------------------------------------------------
| Redirect to login
|--------------------------------------------------------------------------
*/

header(
    'Location: '
        . rtrim(DOMAIN, '/')
        . '/admin/login.php'
);

exit();
