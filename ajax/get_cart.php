<?php
/**
 * ajax/get_cart.php
 * Retrieves cart items for both guest and logged-in users
 */
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

$db = new Database();
$cartItems = [];
$isLoggedIn = isset($_SESSION['user_id']);

try {
    if ($isLoggedIn) {
        // ═══════════════════════════════════════════════════
        // LOGGED-IN USER: Fetch from Database
        // ═══════════════════════════════════════════════════
        $userId = $_SESSION['user_id'];
        
        $sql = "SELECT 
                    c.id as cart_id, 
                    c.quantity as qty, 
                    p.id as product_id, 
                    p.name, 
                    p.price, 
                    p.images as image, 
                    p.category 
                FROM cart c 
                INNER JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ? 
                ORDER BY c.created_at DESC";
        
        $cartItems = $db->fetchAll($sql, [$userId]);

    } else {
        // ═══════════════════════════════════════════════════
        // GUEST USER: Fetch from Session
        // ═══════════════════════════════════════════════════
        
        // 1. Use only persistent cart (guest_temp_cart is deprecated)
        $combined = $_SESSION['guest_cart'] ?? [];

        // 2. Fetch product details from database
        if (!empty($combined)) {
            $ids = array_map('intval', array_keys($combined));
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            
            $sql = "SELECT id as product_id, name, price, images as image, category 
                    FROM products 
                    WHERE id IN ($placeholders)";
            
            $products = $db->fetchAll($sql, $ids);

            // 3. Build cart items array
            foreach ($products as $p) {
                $pId = $p['product_id'];
                $p['qty'] = $combined[$pId] ?? 1;
                $p['cart_id'] = 'guest_' . $pId;
                $cartItems[] = $p;
            }
        }

        // 3. Update cart count
        $_SESSION['cart_count'] = array_sum($_SESSION['guest_cart']);
    }

    // ═══════════════════════════════════════════════════
    // FORMAT RESPONSE DATA
    // ═══════════════════════════════════════════════════
    foreach ($cartItems as &$item) {
        // Ensure proper data types
        $item['qty'] = (int)$item['qty'];
        $item['price'] = (float)$item['price'];
        
        // Handle image paths
        if (empty($item['image'])) {
            $item['image'] = 'src/images/placeholder.jpg';
        } elseif (strpos($item['image'], '/') === false) {
            $item['image'] = 'src/images/' . $item['image'];
        }
    }

    // Return structured response
    echo json_encode([
        'items' => $cartItems,
        'is_logged_in' => $isLoggedIn,
        'cart_count' => count($cartItems)
    ]);

} catch (Exception $e) {
    error_log("Get Cart Error: " . $e->getMessage());
    
    echo json_encode([
        'error' => 'Failed to load cart: ' . $e->getMessage(),
        'items' => [],
        'is_logged_in' => false
    ]);
}
?>