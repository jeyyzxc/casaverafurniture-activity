<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user_id is missing, they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=Please login to access this page");
    exit();
}
?>