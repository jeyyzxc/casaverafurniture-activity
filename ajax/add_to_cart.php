<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

// 1. Input Validation (We removed the Security Block here)
if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID missing']);
    exit();
}

$productId = (int)$_POST['product_id'];
$cartCount = 0;

// =========================================================
// SCENARIO A: USER IS LOGGED IN (Use Database)
// =========================================================
if (isset($_SESSION['user_id'])) {
    $db = new Database();
    $userId = $_SESSION['user_id'];

    try {
        // Check if item is already in the cart
        $existingItem = $db->fetchOne(
            "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", 
            [$userId, $productId]
        );

        if ($existingItem) {
            // Increment
            $newQty = $existingItem['quantity'] + 1;
            $db->query("UPDATE cart SET quantity = ? WHERE id = ?", [$newQty, $existingItem['id']]);
        } else {
            // Insert
            $db->query("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)", [$userId, $productId]);
        }

        // Get Total Count from DB
        $result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
        $cartCount = $result['total'] ?? 0;

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        exit();
    }
} 

// =========================================================
// SCENARIO B: GUEST USER (Use Session Array)
// =========================================================
else {
    // Initialize guest cart if not exists
    if (!isset($_SESSION['guest_cart'])) {
        $_SESSION['guest_cart'] = [];
    }

    // Check if item exists in session array
    if (isset($_SESSION['guest_cart'][$productId])) {
        $_SESSION['guest_cart'][$productId]++;
    } else {
        $_SESSION['guest_cart'][$productId] = 1;
    }

    // Get Total Count from Array
    $cartCount = array_sum($_SESSION['guest_cart']);
}

// 3. Update Global Session Counter & Return Response
$_SESSION['cart_count'] = $cartCount;

echo json_encode([
    'success' => true, 
    'cart_count' => $cartCount,
    'message' => 'Item added successfully'
]);
?>