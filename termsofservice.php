<?php 
require_once 'config.php';
$page_title = 'Terms of Service | CASA VÉRA Furniture'; 
$page_class = 'legal-page'; 
include('includes/header.php'); 
?>

<link rel="stylesheet" href="css/slider.css">

<?php
    $hero_title = "Terms of Service";
    $hero_desc  = "Please read these terms carefully before utilizing our services.";
    $hero_class = "cv-hero--small"; 

    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="mb-5 animate-fade-up delay-100">
                    <h3 class="brand-font mb-3">1. Agreement to Terms</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        By accessing our website and purchasing from CASA VÉRA, you agree to be bound by these Terms and Conditions. If you disagree with any part of these terms, you may not access the service.
                    </p>
                </div>

                <div class="mb-5 animate-fade-up delay-200">
                    <h3 class="brand-font mb-3">2. Products & Pricing</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        All products are subject to availability. We reserve the right to discontinue any product at any time. Prices for our products are subject to change without notice. We make every effort to display the colors and images of our products accurately, but cannot guarantee your monitor's display will be exact.
                    </p>
                </div>

                <div class="mb-5 animate-fade-up delay-300">
                    <h3 class="brand-font mb-3">3. Shipping & Delivery</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        Delivery times are estimates and start from the date of shipping, rather than the date of order. We are not responsible for delays caused by customs clearance or other unforeseen circumstances.
                    </p>
                </div>

                <div class="mb-5 animate-fade-up delay-300">
                    <h3 class="brand-font mb-3">4. Intellectual Property</h3>
                    <p class="text-secondary" style="line-height: 1.8;">
                        The content, organization, graphics, design, and other matters related to the Site are protected under applicable copyrights and other proprietary laws. The copying, redistribution, use, or publication by you of any such matters is strictly prohibited.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="src/js/animations.js"></script>