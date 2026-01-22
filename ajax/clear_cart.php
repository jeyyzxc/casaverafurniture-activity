<?php
session_start();
require_once '../classes/Database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$db = new Database();
$userId = $_SESSION['user_id'];

// Delete all items for this user
$db->query("DELETE FROM cart WHERE user_id = ?", [$userId]);

// Reset session count
$_SESSION['cart_count'] = 0;

echo json_encode(['success' => true]);
?>