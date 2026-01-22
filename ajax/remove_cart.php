<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['product_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$db = new Database();
$userId = $_SESSION['user_id'];
$productId = (int)$_POST['product_id'];

$db->query("DELETE FROM cart WHERE user_id = ? AND product_id = ?", [$userId, $productId]);

// Recalculate Badge
$result = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$userId]);
$_SESSION['cart_count'] = $result['total'] ?? 0;

echo json_encode(['success' => true, 'cart_count' => $_SESSION['cart_count']]);
?>