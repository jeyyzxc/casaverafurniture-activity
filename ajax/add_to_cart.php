<?php
/**
 * ajax/add_to_cart.php
 * Handles adding items to cart for both guest and logged-in users
 */
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

// Parse JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'Invalid request format']);
    exit;
}

$productId = $input['product_id'] ?? null;
$quantity = $input['quantity'] ?? 1;
$action = $input['action'] ?? 'add'; // 'add' or 'buy'

// Validation
if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Product ID required']);
    exit;
}

if ($quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
    exit;
}

$db = new Database();
$userId = $_SESSION['user_id'] ?? null;
$isLoggedIn = !empty($userId);

try {
    // 1. VERIFY PRODUCT EXISTS
    $product = $db->fetchOne("SELECT id, name, price FROM products WHERE id = ?", [$productId]);
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    // 2. DETERMINE CART STORAGE STRATEGY
    if ($isLoggedIn) {
        // ═══════════════════════════════════════════════════
        // LOGGED-IN USER: Store in Database
        // ═══════════════════════════════════════════════════
        $existing = $db->fetchOne(
            "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", 
            [$userId, $productId]
        );

        if ($existing) {
            // Update existing cart item
            $newQty = $existing['quantity'] + $quantity;
            $db->query(
                "UPDATE cart SET quantity = ? WHERE id = ?", 
                [$newQty, $existing['id']]
            );
        } else {
            // Insert new cart item
            $db->query(
                "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)", 
                [$userId, $productId, $quantity]
            );
        }

        // Get total cart count
        $count = $db->fetchOne(
            "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", 
            [$userId]
        );
        $totalCount = $count['total'] ?? 0;

    } else {
        // ═══════════════════════════════════════════════════
        // GUEST USER: Store in Session
        // ═══════════════════════════════════════════════════
        
        // Initialize guest cart if not exists
        if (!isset($_SESSION['guest_cart'])) {
            $_SESSION['guest_cart'] = [];
        }

        // Store in persistent cart for both 'add' and 'buy' actions
        // This ensures items persist after the "Buy Now" -> Login redirect
        if (isset($_SESSION['guest_cart'][$productId])) {
            $_SESSION['guest_cart'][$productId] += $quantity;
        } else {
            $_SESSION['guest_cart'][$productId] = $quantity;
        }

        // Calculate total count (persistent + temporary)
        $totalCount = array_sum($_SESSION['guest_cart']);
    }

    // 3. UPDATE SESSION CART COUNT
    $_SESSION['cart_count'] = $totalCount;

    // 4. RETURN SUCCESS RESPONSE
    echo json_encode([
        'success' => true,
        'cartCount' => $totalCount,
        'is_logged_in' => $isLoggedIn,
        'action' => $action,
        'message' => 'Item added to cart'
    ]);

} catch (Exception $e) {
    // Log error for debugging
    error_log("Add to Cart Error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>