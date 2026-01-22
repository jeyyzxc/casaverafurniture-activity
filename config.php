<?php
// 1. Start Session (Must be the very first line)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'casaverafurniture'); // Use your specific DB name
define('DB_USER', 'root');
define('DB_PASS', '');

// 3. Application Constants
define('APP_NAME', 'CASA VÉRA');
?>