<?php
require_once 'config.php';
require_once 'classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    header("Location: index.php?error=All fields are required&action=login");
    exit();
}

$db = new Database();
$user = $db->fetchOne("SELECT * FROM users WHERE email = ?", [$email]);

if ($user && password_verify($password, $user['password'])) {
    
    // 1. Security: Regenerate Session ID
    session_regenerate_id(true); 
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_firstname'] = $user['firstname'];
    $_SESSION['user_lastname'] = $user['lastname'];

    // 2. CART MIGRATION (Guest -> DB)
    // If the user had items as a guest, move them to the DB cart now.
    if (isset($_SESSION['guest_cart']) && !empty($_SESSION['guest_cart'])) {
        foreach ($_SESSION['guest_cart'] as $pId => $qty) {
            // Check if user already has this item in DB
            $exists = $db->fetchOne("SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?", [$user['id'], $pId]);
            
            if ($exists) {
                // Update quantity
                $newQty = $exists['quantity'] + $qty;
                $db->query("UPDATE cart SET quantity = ? WHERE id = ?", [$newQty, $exists['id']]);
            } else {
                // Insert new item
                $db->query("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)", [$user['id'], $pId, $qty]);
            }
        }
        // Clear guest cart
        unset($_SESSION['guest_cart']);
        unset($_SESSION['guest_temp_cart']);
    }

    // 3. Update Badge Count
    $count = $db->fetchOne("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?", [$user['id']]);
    $_SESSION['cart_count'] = $count['total'] ?? 0;
    
    header("Location: index.php?success=Welcome back, " . urlencode($user['firstname']));
    exit();

} else {
    header("Location: index.php?error=Invalid email or password&action=login");
    exit();
}
?>