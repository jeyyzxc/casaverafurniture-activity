<?php
// ajax/add_to_cart.php
session_start();
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID missing']);
    exit();
}

$productId = (int)$_POST['product_id'];
$action = $_POST['action'] ?? 'add'; // 'add' or 'buy'
$cartCount = 0;

// =========================================================
// SCENARIO A: LOGGED-IN USER (Database - Always Persistent)
// =========================================================
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $userId = $_SESSION['user_id'];

    // Standard Database Logic (Same as before)
    $existing = $db->fetchOne("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);
    if ($existing) {
        $db->query("UPDATE cart SET quantity = quantity + 1 WHERE id = ?", [$existing['id']]);
    } else {
        $db->query("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)", [$userId, $productId]);
    }
    $result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
    $cartCount = $result['total'] ?? 0;
} 
// =========================================================
// SCENARIO B: GUEST USER (Session - Conditional Persistence)
// =========================================================
else {
    // 1. Initialize Standard Cart (Persistent)
    if (!isset($_SESSION['guest_cart'])) $_SESSION['guest_cart'] = [];
    
    // 2. Initialize Buy Now Cart (Temporary / Flash)
    if (!isset($_SESSION['guest_temp_cart'])) $_SESSION['guest_temp_cart'] = [];

    if ($action === 'buy') {
        // "Buy Now": Add to TEMPORARY storage
        // We overwrite or add to temp cart. 
        // Logic: Buy Now usually focuses on this specific item.
        if (isset($_SESSION['guest_temp_cart'][$productId])) {
            $_SESSION['guest_temp_cart'][$productId]++;
        } else {
            $_SESSION['guest_temp_cart'][$productId] = 1;
        }
    } else {
        // "Add to Cart": Add to PERSISTENT storage
        if (isset($_SESSION['guest_cart'][$productId])) {
            $_SESSION['guest_cart'][$productId]++;
        } else {
            $_SESSION['guest_cart'][$productId] = 1;
        }
    }

    // Count is sum of both for now
    $cartCount = array_sum($_SESSION['guest_cart']) + array_sum($_SESSION['guest_temp_cart']);
}

$_SESSION['cart_count'] = $cartCount;
echo json_encode(['success' => true, 'cart_count' => $cartCount]);
?>