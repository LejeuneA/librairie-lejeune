<?php

require_once __DIR__ . '/settings.php';

requireLogin();

header('Location: manager.php');
exit();
