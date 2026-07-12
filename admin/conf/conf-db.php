<?php

// Production can provide these values as environment variables.
// The fallback values preserve the existing local XAMPP configuration.
define('SERVER_NAME', getenv('DB_HOST') ?: 'localhost');
define('USER_NAME', getenv('DB_USER') ?: 'root');
define('USER_PWD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'librairie_lejeune');

