<?php
require_once 'config.php';

// 1. Clear Session Data
$_SESSION = [];

// 2. Destroy Session Cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destroy Session File
session_destroy();

header("Location: index.php?success=You have logged out successfully");
exit();
?>