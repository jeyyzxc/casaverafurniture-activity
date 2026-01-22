<?php
require_once 'config.php';
$page_title = 'Contact Us | CASA VÉRA Furniture'; 
$page_class = 'contact-page';

// Fix: Use forward slashes for compatibility
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="src/css/slider.css">
<link rel="stylesheet" href="src/css/contact.css">

<style>
    .contact-info-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    .contact-info-card:hover {
        border-color: #FFD700;
    }
</style>

<?php
    // Configure the hero for this page
    $hero_title = "Get in Touch";
    $hero_desc  = "We’d love to hear from you—message us or visit our store for the perfect piece.";
    $hero_class = "cv-hero--small"; // Uses the shorter height variant
    
    // Optional: You can override images if you want specific ones for Contact
    /* $hero_images = ['src/images/contact-bg.jpg']; */
    
    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-light-texture">
    <div class="container">
        
        <div class="row g-5 justify-content-center">
            
            <div class="col-lg-6 scroll-rise-up">
                <div class="contact-form-card">
                    <div class="mb-4">
                        <span class="text-gold text-uppercase ls-2 small fw-bold">Message Us</span>
                        <h2 class="brand-font h2 mt-2">How can we help?</h2>
                    </div>
                    
                    <form id="contactForm" class="needs-validation" novalidate>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" placeholder="Full Name" required>
                                    <label for="name">Full Name</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" placeholder="Email Address" pattern="[^@\s]+@gmail\.com" required>
                                    <label for="email">Email Address</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Message" id="message" style="height: 150px" minlength="10" required></textarea>
                                    <label for="message">Message</label>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-gold w-100 rounded-pill py-3 fw-bold shadow-sm">
                                    Send Message <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row g-4">
                    
                    <div class="col-12 scroll-rise-up delay-100">
                        <div class="contact-info-card">
                            <div class="icon-wrapper"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="info-content">
                                <h5 class="brand-font h6 fw-bold">Our Showrooms</h5>
                                <div class="small text-muted mt-3">
                                    <address class="mb-3">
                                        <strong class="text-dark">BGC Flagship</strong><br>
                                        Unit 1205, The Forum BGC, Taguig
                                    </address>
                                    <address class="mb-3">
                                        <strong class="text-dark">Makati Gallery</strong><br>
                                        2nd Floor, Greenbelt 5, Makati City
                                    </address>
                                    <address class="mb-0">
                                        <strong class="text-dark">Laguna Outlet</strong><br>
                                        G/F Solstice Lifestyle Center, San Pedro
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 scroll-rise-up delay-100">
                        <div class="contact-info-card">
                            <div class="icon-wrapper"><i class="fa-solid fa-clock"></i></div>
                            <div class="info-content w-100">
                                <h5 class="brand-font h6 fw-bold mb-3">Business Hours</h5>
                                <ul class="list-unstyled small text-muted mb-0">
                                    <li class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                        <span class="text-dark fw-semibold">Mon – Fri</span>
                                        <span>10:00 AM – 7:00 PM</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom pb-2 mb-2">
                                        <span class="text-dark fw-semibold">Saturday</span>
                                        <span>10:00 AM – 6:00 PM</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <span class="text-dark fw-semibold">Sun & Holidays</span>
                                        <span>By Appointment</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 scroll-rise-up delay-200">
                        <a href="mailto:hello@casavera.com" class="contact-action-card">
                            <i class="fas fa-envelope mb-3 text-gold fa-2x"></i>
                            <h6 class="fw-bold text-dark">Email Us</h6>
                            <span class="small text-muted">hello@casavera.com</span>
                        </a>
                    </div>

                    <div class="col-md-6 scroll-rise-up delay-200">
                        <a href="tel:+639123456789" class="contact-action-card">
                            <i class="fas fa-phone mb-3 text-gold fa-2x"></i>
                            <h6 class="fw-bold text-dark">Call Us</h6>
                            <span class="small text-muted">+63 912 345 6789</span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<section class="map-section">
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.889369324636!2d121.04879531535497!3d14.54840298983577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8f258a62e01%3A0x628047913079250!2sBonifacio%20Global%20City!5e0!3m2!1sen!2sph!4v1674291234567!5m2!1sen!2sph" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <div class="map-overlay-guard"></div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script src="src/js/animations.js"></script>
<script src="src/js/contact.js"></script>