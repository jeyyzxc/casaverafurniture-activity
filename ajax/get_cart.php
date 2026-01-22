<?php
// ajax/get_cart.php
session_start();
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

$db = new Database();
$cartItems = [];
$isLoggedIn = isset($_SESSION['user_id']);

try {
    // =========================================================
    // LOGIC A: LOGGED IN (Fetch from DB)
    // =========================================================
    if ($isLoggedIn) {
        $userId = $_SESSION['user_id'];
        $sql = "SELECT c.id as cart_id, c.quantity as qty, p.id as product_id, 
                       p.name, p.price, p.image, p.category 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ? ORDER BY c.id DESC";
        $cartItems = $db->fetchAll($sql, [$userId]);
    } 
    // =========================================================
    // LOGIC B: GUEST (Fetch Session + Auto-Remove Temp)
    // =========================================================
    else {
        // 1. Combine Persistent and Temporary Carts
        $persistent = $_SESSION['guest_cart'] ?? [];
        $temporary  = $_SESSION['guest_temp_cart'] ?? [];
        
        // Merge logic: If item exists in both, sum quantities
        $combined = $persistent;
        foreach ($temporary as $pid => $qty) {
            if (isset($combined[$pid])) {
                $combined[$pid] += $qty;
            } else {
                $combined[$pid] = $qty;
            }
        }

        $ids = array_map('intval', array_keys($combined));

        if (!empty($ids)) {
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $sql = "SELECT id as product_id, name, price, image, category 
                    FROM products WHERE id IN ($placeholders)";
            $products = $db->fetchAll($sql, $ids);

            foreach ($products as $p) {
                $pId = $p['product_id'];
                $p['qty'] = $combined[$pId] ?? 1;
                $p['cart_id'] = 'guest_' . $pId;
                
                // Mark which ones are temporary for frontend knowledge (optional)
                $p['is_temp'] = isset($temporary[$pId]);
                
                $cartItems[] = $p;
            }
        }

        // CRITICAL: SELF-DESTRUCT TEMPORARY ITEMS
        // Once fetched, we clear the temp array. 
        // Next reload, these items will be gone.
        unset($_SESSION['guest_temp_cart']);
        
        // Update global count to reflect the removal of temp items
        $_SESSION['cart_count'] = array_sum($_SESSION['guest_cart']);
    }

    // Image Path Formatting
    foreach ($cartItems as &$item) {
        $item['qty'] = (int)$item['qty'];
        $item['price'] = (float)$item['price'];
        if (empty($item['image'])) {
            $item['image'] = 'src/images/placeholder.jpg';
        } elseif (!str_contains($item['image'], '/')) {
            $item['image'] = 'src/images/' . $item['image'];
        }
    }

    // Return Data AND Login Status
    echo json_encode([
        'items' => $cartItems,
        'is_logged_in' => $isLoggedIn
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>