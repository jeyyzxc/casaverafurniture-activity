<?php
// ajax/update_cart_qty.php
require_once '../config.php'; // REQUIRED
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id']) || !isset($_POST['change'])) {
    echo json_encode(['success' => false]);
    exit();
}

$productId = (int)$_POST['product_id'];
$change = (int)$_POST['change'];

// SCENARIO A: LOGGED IN
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $userId = $_SESSION['user_id'];
    
    $item = $db->fetchOne("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);

    if ($item) {
        $newQty = $item['quantity'] + $change;
        if ($newQty <= 0) {
            $db->query("DELETE FROM cart WHERE id = ?", [$item['id']]);
        } else {
            $db->query("UPDATE cart SET quantity = ? WHERE id = ?", [$newQty, $item['id']]);
        }
        
        $result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
        $_SESSION['cart_count'] = $result['total'] ?? 0;
        
        echo json_encode(['success' => true, 'cart_count' => $_SESSION['cart_count']]);
    } else {
        echo json_encode(['success' => false]);
    }
} 
// SCENARIO B: GUEST
else {
    if (isset($_SESSION['guest_cart'][$productId])) {
        $_SESSION['guest_cart'][$productId] += $change;
        if ($_SESSION['guest_cart'][$productId] <= 0) {
            unset($_SESSION['guest_cart'][$productId]);
        }
        $_SESSION['cart_count'] = array_sum($_SESSION['guest_cart']);
        echo json_encode(['success' => true, 'cart_count' => $_SESSION['cart_count']]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>