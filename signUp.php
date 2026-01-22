<div id="signupModal" class="cv-modal-overlay">
    <div class="cv-modal-box">
        
        <button class="cv-modal-close" onclick="closeSignupModal()">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-4">
            <h2 class="brand-font h3">Create Account</h2>
            <p class="text-muted small">Join the CASA VÉRA community.</p>
        </div>

        <form id="signupForm" action="process_signup.php" method="POST" class="needs-validation" novalidate>
            
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="signupName" placeholder="Full Name" required>
                <label for="signupName">Full Name</label>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="signupEmail" placeholder="name@example.com" required>
                <label for="signupEmail">Email Address</label>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="signupPassword" placeholder="Password" minlength="8" required>
                <label for="signupPassword">Password</label>
                <span class="password-toggle" onclick="peekPassword('signupPassword', this)">
                    <i class="fas fa-eye"></i>
                </span>
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="signupConfirmPassword" placeholder="Confirm Password" minlength="8" required>
                <label for="signupConfirmPassword">Confirm Password</label>
                <span class="password-toggle" onclick="peekPassword('signupConfirmPassword', this)">
                    <i class="fas fa-eye"></i>
                </span>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label small text-muted" for="termsCheck">
                    I agree to the <a href="termsofservice.php" class="text-gold text-decoration-none">Terms of Service</a> and <a href="privacypolicy.php" class="text-gold text-decoration-none">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="btn btn-gold w-100 rounded-pill py-2 fw-bold mb-3 shadow-sm" disabled>Sign Up</button>
        </form>

        <div class="divider-with-text">
            <hr>
            <span>OR</span>
        </div>

        <a href="google-auth.php" class="btn btn-google w-100 rounded-pill py-2 mb-4 shadow-sm d-flex align-items-center justify-content-center">
            <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
            </svg>
            Sign up with Google
        </a>
            
        <div class="text-center">
            <span class="small text-muted">Already have an account? </span>
            <a href="#" onclick="switchToLogin(event)" class="small text-gold fw-bold text-decoration-none">Sign In</a>
        </div>
    </div>
</div>