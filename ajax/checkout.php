<?php
/**
 * checkout.php
 * PROTECTED PAGE: Only accessible to logged-in users
 */
require_once 'config.php';
require_once 'classes/Database.php';

// ═══════════════════════════════════════════════════
// CRITICAL: Authentication Check
// ═══════════════════════════════════════════════════
if (!isset($_SESSION['user_id'])) {
    // Guest user trying to access checkout
    $_SESSION['redirect_after_login'] = 'checkout.php';
    $_SESSION['login_message'] = 'Please login to proceed to checkout';
    header('Location: login.php');
    exit;
}

// ═══════════════════════════════════════════════════
// Verify User Has Items in Cart
// ═══════════════════════════════════════════════════
$db = new Database();
$userId = $_SESSION['user_id'];

$cartCount = $db->fetchOne(
    "SELECT COUNT(*) as count FROM cart WHERE user_id = ?", 
    [$userId]
);

if ($cartCount['count'] == 0) {
    // Empty cart - redirect to products
    header('Location: products.php?msg=cart_empty');
    exit;
}

// ═══════════════════════════════════════════════════
// Fetch User Information
// ═══════════════════════════════════════════════════
$user = $db->fetchOne(
    "SELECT id, full_name, email, phone, address FROM users WHERE id = ?", 
    [$userId]
);

// ═══════════════════════════════════════════════════
// Fetch Cart Items
// ═══════════════════════════════════════════════════
$cartItems = $db->fetchAll(
    "SELECT c.id, c.quantity, p.id as product_id, p.name, p.price, p.images as image 
     FROM cart c 
     INNER JOIN products p ON c.product_id = p.id 
     WHERE c.user_id = ?
     ORDER BY c.created_at DESC", 
    [$userId]
);

// Calculate totals
$subtotal = 0;
foreach ($cartItems as &$item) {
    $subtotal += $item['price'] * $item['quantity'];
    
    if (!empty($item['image']) && strpos($item['image'], '/') === false) {
        $item['image'] = 'src/images/' . $item['image'];
    }
}
unset($item);

$shippingFee = 100; // Fixed shipping fee
$total = $subtotal + $shippingFee;

$page_title = 'Checkout - CASA VÉRA';
$page_class = 'checkout-page';
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/checkout.css">

<section class="section-padding bg-light-texture">
    <div class="container">
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="brand-font mb-4">Checkout</h2>

                        <form id="checkoutForm" method="POST" action="process_checkout.php">
                            <!-- Billing Information -->
                            <h5 class="mb-3">Billing Information</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" name="phone" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Delivery Address</label>
                                <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            </div>

                            <!-- Payment Method -->
                            <h5 class="mb-3 mt-4">Payment Method</h5>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="cod" value="cod" checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="gcash" value="gcash">
                                <label class="form-check-label" for="gcash">
                                    GCash
                                </label>
                            </div>

                            <button type="submit" class="btn btn-gold w-100 mt-4">
                                <span class="fw-bold">Place Order</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="mb-4">Order Summary</h5>

                        <!-- Cart Items -->
                        <div class="checkout-items mb-3">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                         class="rounded me-3" 
                                         style="width: 60px; height: 60px; object-fit: cover;" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                        <small class="text-muted">Qty: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <div class="text-end">
                                        <span class="fw-bold">₱<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Totals -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>₱<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping:</span>
                                <span>₱<?php echo number_format($shippingFee, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <strong>Total:</strong>
                                <strong class="text-gold">₱<?php echo number_format($total, 2); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
});
</script>