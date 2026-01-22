<?php
// ajax/remove_cart.php
require_once '../config.php'; // REQUIRED
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$productId = (int)$_POST['product_id'];

// SCENARIO A: LOGGED IN
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $userId = $_SESSION['user_id'];
    
    $db->query("DELETE FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);
    
    $result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
    $_SESSION['cart_count'] = $result['total'] ?? 0;
} 
// SCENARIO B: GUEST
else {
    if (isset($_SESSION['guest_cart'][$productId])) {
        unset($_SESSION['guest_cart'][$productId]);
    }
    $_SESSION['cart_count'] = array_sum($_SESSION['guest_cart']);
}

echo json_encode(['success' => true, 'cart_count' => $_SESSION['cart_count']]);
?>