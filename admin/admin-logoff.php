<?php

require_once __DIR__ . '/settings.php';

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

if (isAuthenticated()) {
    destroyUserSession();
}

header('Location: login.php');
exit();
