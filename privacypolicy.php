<?php 
$page_title = 'Privacy Policy | CASA VÉRA Furniture'; 
$page_class = 'legal-page'; 
include('includes/header.php'); 
?>

<link rel="stylesheet" href="css/slider.css">

<?php
    $hero_title = "Privacy Policy";
    $hero_desc  = "Your trust is our ultimate luxury. We are committed to protecting your personal information.";
    $hero_class = "cv-hero--small"; // Standard short hero height

    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="mb-5 animate-fade-up delay-100">
                    <h3 class="brand-font mb-3">1. Information We Collect</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        At CASA VÉRA, we collect information to provide you with a seamless luxury shopping experience. This includes:
                    </p>
                    <ul class="text-secondary" style="line-height: 1.8;">
                        <li><strong>Personal Identification:</strong> Name, email address, shipping address, and phone number when you place an order.</li>
                        <li><strong>Payment Data:</strong> Secure payment credentials processed by our banking partners (we do not store full credit card numbers).</li>
                        <li><strong>Browsing Data:</strong> Cookies and usage data to personalize your gallery experience.</li>
                    </ul>
                </div>

                <div class="mb-5 animate-fade-up delay-200">
                    <h3 class="brand-font mb-3">2. How We Use Your Data</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        We use your information strictly to fulfill your orders, provide concierge support, and update you on exclusive collections. We honor your privacy by never selling your data to third-party marketing agencies.
                    </p>
                </div>

                <div class="mb-5 animate-fade-up delay-300">
                    <h3 class="brand-font mb-3">3. Security</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        We implement industry-standard encryption and security protocols to protect your personal data. Our digital infrastructure is monitored 24/7 to prevent unauthorized access.
                    </p>
                </div>

                <div class="mb-5 animate-fade-up delay-300">
                    <h3 class="brand-font mb-3">4. Cookies</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        Our website uses cookies to remember your preferences and cart items. You may choose to disable cookies in your browser settings, though this may affect your shopping experience.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="src/js/animations.js"></script>