<?php
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

// Check Session
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]); // Return empty if not logged in
    exit();
}

try {
    $db = new Database();
    $userId = $_SESSION['user_id'];

    // Join cart and products to get full details
    // We select c.id as 'cart_id' to manage the specific cart row
    $sql = "SELECT c.id as cart_id, c.quantity as qty, p.id as product_id, 
                   p.name, p.price, p.image, p.category 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?
            ORDER BY c.id DESC";

    $cartItems = $db->fetchAll($sql, [$userId]);

    // Format Data (Fix Types & Image Paths)
    foreach ($cartItems as &$item) {
        $item['qty'] = (int)$item['qty'];
        $item['price'] = (float)$item['price'];
        
        // Ensure Image Path is correct
        if (!str_contains($item['image'], '/')) {
            $item['image'] = 'src/images/' . $item['image'];
        }
    }

    echo json_encode($cartItems);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>