<?php
require_once 'config.php';
require_once 'includes/session_check.php'; // This protects the page
$page_title = 'Your Cart | CASA VÉRA Furniture'; 
$page_class = 'cart-page';
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="css/slider.css">
<link rel="stylesheet" href="css/cart.css">

<?php
    $hero_title = "Shopping Cart";
    $hero_desc  = "Review your curated masterpieces before securing your order.";
    $hero_class = "cv-hero--small"; 
    
    // Optional: Cart specific background
    /* $hero_images = ['src/images/cart-bg.jpg']; */

    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-light-texture">
    <div class="container py-4">
        <div class="row g-5">

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

                        <div class="promo-wrapper mb-4 position-relative">
                            <input type="text" class="form-control bg-light border-0 small rounded-pill ps-3" 
                                  placeholder="Voucher Code" 
                                  style="height: 50px; padding-right: 90px;">
                            <button class="btn btn-dark rounded-pill position-absolute top-50 end-0 translate-middle-y me-1 text-uppercase fw-bold small ls-1 shadow-sm hover-gold-bg" 
                                    style="height: 42px; padding: 0 25px;">
                                Apply
                            </button>
                        </div>

                        <div class="divider-dashed mb-4"></div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h6 mb-0 text-dark text-uppercase ls-1">Total</span>
                            <span class="h4 mb-0 brand-font text-gradient-gold" id="summaryTotal">₱0.00</span>
                        </div>

                        <button class="btn-checkout w-100 rounded-pill py-3 mb-3 position-relative overflow-hidden">
                            <span class="position-relative z-2 fw-bold text-uppercase ls-2">Proceed to Checkout</span>
                            <div class="btn-shimmer"></div>
                        </button>

                        <div class="text-center">
                            <p class="small text-muted mb-2" style="font-size: 0.7rem;">Guaranteed Safe & Secure Checkout</p>
                            <div class="d-flex justify-content-center gap-3 text-muted opacity-50">
                                <i class="fab fa-cc-visa fa-lg"></i>
                                <i class="fab fa-cc-mastercard fa-lg"></i>
                                <i class="fab fa-cc-paypal fa-lg"></i>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="js/animations.js"></script>
<script src="js/cart.js"></script>