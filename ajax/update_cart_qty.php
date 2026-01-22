<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id']) || !isset($_POST['change'])) {
    echo json_encode(['success' => false]);
    exit();
}

$db = new Database();
$userId = $_SESSION['user_id'];
$productId = (int)$_POST['product_id'];
$change = (int)$_POST['change'];

// Get current quantity
$item = $db->fetchOne("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);

if ($item) {
    $newQty = $item['quantity'] + $change;

    if ($newQty <= 0) {
        // Remove if 0
        $db->query("DELETE FROM cart WHERE id = ?", [$item['id']]);
    } else {
        // Update
        $db->query("UPDATE cart SET quantity = ? WHERE id = ?", [$newQty, $item['id']]);
    }
    
    // Recalculate Total Items for Badge
    $result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
    $_SESSION['cart_count'] = $result['total'] ?? 0;

    echo json_encode(['success' => true, 'new_qty' => $newQty, 'cart_count' => $_SESSION['cart_count']]);
} else {
    echo json_encode(['success' => false]);
}
?>