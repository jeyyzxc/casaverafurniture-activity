<?php
/**
 * ajax/update_cart.php
 * Handles quantity updates and item removal
 */
require_once '../config.php';
require_once '../classes/Database.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$productId = $input['product_id'] ?? null;
$action = $input['action'] ?? 'update'; // 'update' or 'remove'
$change = $input['change'] ?? 0; // +1 or -1

if (!$productId) {
    echo json_encode(['success' => false, 'message' => 'Product ID required']);
    exit;
}

$db = new Database();
$userId = $_SESSION['user_id'] ?? null;

try {
    if ($userId) {
        // ═══════════════════════════════════════════════════
        // LOGGED-IN USER: Update Database
        // ═══════════════════════════════════════════════════
        $cartItem = $db->fetchOne("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);

        if ($action === 'remove') {
            if ($cartItem) {
                $db->query("DELETE FROM cart WHERE id = ?", [$cartItem['id']]);
            }
        } elseif ($action === 'update' && $cartItem) {
            $newQty = $cartItem['quantity'] + $change;
            if ($newQty <= 0) {
                $db->query("DELETE FROM cart WHERE id = ?", [$cartItem['id']]);
            } else {
                $db->query("UPDATE cart SET quantity = ? WHERE id = ?", [$newQty, $cartItem['id']]);
            }
        }

        $count = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
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
        } elseif ($action === 'update') {
            $currentQty = $_SESSION['guest_cart'][$productId] ?? 0;
            $newQty = $currentQty + $change;
            
            if ($newQty <= 0) {
                unset($_SESSION['guest_cart'][$productId]);
            } else {
                $_SESSION['guest_cart'][$productId] = $newQty;
            }
        }
        $totalCount = array_sum($_SESSION['guest_cart']);
    }

    $_SESSION['cart_count'] = $totalCount;

    echo json_encode([
        'success' => true,
        'cartCount' => $totalCount,
        'message' => 'Cart updated'
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>