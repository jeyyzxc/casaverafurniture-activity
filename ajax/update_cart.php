<?php
/**
 * ajax/update_cart.php
 * Handles quantity updates and item removal
 */
session_start();
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$productId = $input['product_id'] ?? null;
$action = $input['action'] ?? null; // 'update' or 'remove'
$change = $input['change'] ?? 0; // For increment/decrement
$quantity = $input['quantity'] ?? null; // For direct set

if (!$productId || !$action) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$db = new Database();
$userId = $_SESSION['user_id'] ?? null;
$isLoggedIn = !empty($userId);

try {
    if ($isLoggedIn) {
        // ═══════════════════════════════════════════════════
        // LOGGED-IN USER: Update Database
        // ═══════════════════════════════════════════════════
        
        if ($action === 'remove') {
            $db->query(
                "DELETE FROM cart WHERE user_id = ? AND product_id = ?", 
                [$userId, $productId]
            );
        } 
        elseif ($action === 'update') {
            // Get current quantity
            $current = $db->fetchOne(
                "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?", 
                [$userId, $productId]
            );

            if ($current) {
                if ($quantity !== null) {
                    // Direct set
                    $newQty = max(1, (int)$quantity);
                } else {
                    // Increment/decrement
                    $newQty = max(1, $current['quantity'] + $change);
                }

                $db->query(
                    "UPDATE cart SET quantity = ?, updated_at = NOW() WHERE user_id = ? AND product_id = ?", 
                    [$newQty, $userId, $productId]
                );
            }
        }
        
        // Get updated count
        $count = $db->fetchOne(
            "SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", 
            [$userId]
        );
        $totalCount = $count['total'] ?? 0;

    } else {
        // ═══════════════════════════════════════════════════
        // GUEST USER: Update Session
        // ═══════════════════════════════════════════════════
        
        if (!isset($_SESSION['guest_cart'])) {
            $_SESSION['guest_cart'] = [];
        }

        if ($action === 'remove') {
            unset($_SESSION['guest_cart'][$productId]);
        } 
        elseif ($action === 'update') {
            if (isset($_SESSION['guest_cart'][$productId])) {
                if ($quantity !== null) {
                    // Direct set
                    $_SESSION['guest_cart'][$productId] = max(1, (int)$quantity);
                } else {
                    // Increment/decrement
                    $_SESSION['guest_cart'][$productId] += $change;
                    
                    // Remove if quantity becomes 0 or negative
                    if ($_SESSION['guest_cart'][$productId] <= 0) {
                        unset($_SESSION['guest_cart'][$productId]);
                    }
                }
            }
        }
        
        $totalCount = array_sum($_SESSION['guest_cart']);
    }

    // Update session count
    $_SESSION['cart_count'] = $totalCount;

    echo json_encode([
        'success' => true, 
        'cartCount' => $totalCount,
        'is_logged_in' => $isLoggedIn
    ]);

} catch (Exception $e) {
    error_log("Update Cart Error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to update cart'
    ]);
}
?>