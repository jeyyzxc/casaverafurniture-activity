<?php
// config.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'casaverafurniture'); // CONFIRMED from your screenshot
define('DB_USER', 'root');
define('DB_PASS', '');

// Strict Session Security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Change to 1 if using HTTPS

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>