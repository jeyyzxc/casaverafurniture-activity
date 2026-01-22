<?php
require_once 'config.php';
// require_once 'includes/session_check.php'; // Commented out to prevent crash if file is missing
$page_title = 'Your Cart | CASA VÉRA Furniture'; 
$page_class = 'cart-page';
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="src/css/slider.css">
<link rel="stylesheet" href="src/css/cart.css">

<?php
    $hero_title = "Shopping Cart";
    $hero_desc  = "Review your curated masterpieces before securing your order.";
    $hero_class = "cv-hero--small"; 
    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-light-texture">
    <div class="container py-4">
        <div class="row g-5" id="cartMainContent">

            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-light pb-2">
                    <h5 class="brand-font mb-0 text-dark">Selected Items (<span id="cartCount">0</span>)</h5>
                    <button class="btn btn-link text-muted small text-decoration-none hover-danger d-none" id="clearCartBtn" onclick="App.clearCart()">
                        Clear All
                    </button>
                </div>

                <div id="cartItemsContainer"></div>

                <div id="emptyCart" class="text-center py-5 d-none">
                    <div class="mb-3 text-muted opacity-25"><i class="fas fa-shopping-bag fa-4x"></i></div>
                    <h4 class="brand-font">Your cart is empty</h4>
                    <p class="text-muted mb-4">Looks like you haven't found your perfect piece yet.</p>
                    <a href="products.php" class="btn btn-dark rounded-pill px-5 shadow-sm">Continue Shopping</a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="luxury-summary sticky-top" style="top: 100px;">
                    
                    <div class="summary-header">
                        <h4 class="brand-font mb-0 text-center text-white">Order Summary</h4>
                    </div>

                    <div class="summary-body p-4">
                        <div class="summary-row d-flex justify-content-between mb-3">
                            <span class="text-muted small text-uppercase ls-1">Subtotal</span>
                            <span class="fw-bold text-dark" id="summarySubtotal">₱0.00</span>
                        </div>
                        <div class="summary-row d-flex justify-content-between mb-4">
                            <span class="text-muted small text-uppercase ls-1">Shipping</span>
                            <span class="text-gold small fw-bold"><i class="fas fa-check-circle me-1"></i> Free</span>
                        </div>

                        <div class="divider-dashed mb-4"></div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h6 mb-0 text-dark text-uppercase ls-1">Total</span>
                            <span class="h4 mb-0 brand-font text-gradient-gold" id="summaryTotal">₱0.00</span>
                        </div>

                        <button id="btnCheckout" class="btn-checkout w-100 rounded-pill py-3 mb-3 position-relative overflow-hidden">
                            <span class="position-relative z-2 fw-bold text-uppercase ls-2">Proceed to Checkout</span>
                            <div class="btn-shimmer"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Success Message (Hidden by default) -->
        <div id="orderSuccess" class="text-center py-5 d-none fade-in-up">
            <div class="mb-4 text-gold">
                <i class="fas fa-check-circle fa-5x mb-3"></i>
            </div>
            <h2 class="brand-font display-5 mb-3">Payment Successful!</h2>
            <p class="lead text-muted mb-4">Thank you for your purchase. Your order has been confirmed.</p>
            
            <div class="card border-0 shadow-sm d-inline-block mx-auto text-start p-4" style="max-width: 500px; width: 100%;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Order Reference:</span>
                    <span class="fw-bold text-dark" id="successOrderId">#CV-000000</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Date:</span>
                    <span class="fw-bold text-dark" id="successDate">Oct 24, 2023</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Payment Method:</span>
                    <span class="fw-bold text-dark" id="successPaymentMethod">PayPal</span>
                </div>
                <hr class="my-3">
                <p class="mb-0 text-center small text-muted">
                    <i class="fas fa-shipping-fast me-2 text-gold"></i>
                    Estimated Delivery: 3-5 Business Days
                </p>
            </div>
            <div class="mt-5">
                <a href="products.php" class="btn btn-dark rounded-pill px-5 py-2">Continue Shopping</a>
            </div>
        </div>
    </div>
</section>

<!-- Mock Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title brand-font">Secure Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4 small">Select a payment method to complete your order.</p>
                <div class="d-grid gap-3">
                    <button class="btn btn-outline-dark py-3 d-flex align-items-center justify-content-center gap-2 payment-option" data-method="paypal">
                        <i class="fab fa-paypal fa-lg text-primary"></i> Pay with PayPal
                    </button>
                    <button class="btn btn-outline-dark py-3 d-flex align-items-center justify-content-center gap-2 payment-option" data-method="card">
                        <i class="far fa-credit-card fa-lg"></i> Credit / Debit Card
                    </button>
                </div>
                <div id="paymentProcessing" class="text-center mt-4 d-none">
                    <div class="spinner-border text-gold mb-2" role="status"></div>
                    <p class="text-muted small mb-0">Processing transaction...</p>
                </div>
                <div id="paymentError" class="alert alert-danger mt-3 d-none small">
                    <i class="fas fa-exclamation-circle me-1"></i> Transaction failed. Please try again.
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="src/js/animations.js"></script>
<script src="src/js/cart.js"></script>