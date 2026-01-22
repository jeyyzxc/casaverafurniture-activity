<?php
// ajax/clear_cart.php
require_once '../config.php'; // REQUIRED
require_once '../classes/Database.php';

header('Content-Type: application/json');

// SCENARIO A: LOGGED IN
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $userId = $_SESSION['user_id'];
    $db->query("DELETE FROM cart WHERE user_id = ?", [$userId]);
} 
// SCENARIO B: GUEST
else {
    unset($_SESSION['guest_cart']);
}

$_SESSION['cart_count'] = 0;
echo json_encode(['success' => true]);
?>