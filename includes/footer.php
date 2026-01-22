<footer class="footer-luxury mt-auto">
        <div class="container">
            <div class="row g-3 justify-content-between"> 
                
                <div class="col-lg-4 col-md-6">
                    <a href="home.php" class="text-decoration-none">
                        <h3 class="brand-font text-gold mb-2" style="font-size: 1.5rem;">CASA VÉRA</h3>
                    </a>
                    <p class="footer-desc mb-0">
                        Timeless elegance for the modern home.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading mb-2">Explore</h5>
                    <ul class="list-unstyled footer-links mb-0">
                        <li><a href="home.php">Home</a></li>
                        <li><a href="products.php">Collection</a></li>
                        <li><a href="about.php">Our Story</a></li>
                        <li><a href="contactUs.php">Contact</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12">
                    <h5 class="footer-heading mb-2">Follow Us</h5>
                    <p class="small text-muted mb-2">Join our community.</p>
                    <div class="d-flex gap-2">
                        <a href="https://facebook.com" target="_blank" class="social-icon-box" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://instagram.com" target="_blank" class="social-icon-box" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

            </div>

            <hr class="footer-divider my-3">

            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="small text-muted mb-0" style="font-size: 0.8rem;">
                        &copy; <span id="current-year"><?php echo date("Y"); ?></span> CASA VÉRA. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="privacypolicy.php" class="small text-muted text-decoration-none me-3 hover-gold" style="font-size: 0.8rem;">Privacy Policy</a>
                    <a href="termsofservice.php" class="small text-muted text-decoration-none hover-gold" style="font-size: 0.8rem;">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
    <?php 
        if(file_exists('login.php')) include 'login.php'; 
        if(file_exists('signUp.php')) include 'signUp.php'; 
    ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/header-footer.js"></script>
    <script src="js/login-signupModal.js"></script> </body>
    </html>