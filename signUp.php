<div id="signupModal" class="cv-modal-overlay">
    <div class="cv-modal-box">
        <button class="cv-modal-close" onclick="closeSignupModal()"><i class="fas fa-times"></i></button>

        <div class="text-center mb-4">
            <h2 class="brand-font h3">Create Account</h2>
            <p class="text-muted small">Join the CASA VÉRA community.</p>
        </div>

        <form id="signupForm" action="process_signup.php" method="POST" class="needs-validation" novalidate>
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" name="firstname" class="form-control" id="signupFirstName" placeholder="First Name" required>
                        <label for="signupFirstName">First Name</label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <input type="text" name="lastname" class="form-control" id="signupLastName" placeholder="Last Name" required>
                        <label for="signupLastName">Last Name</label>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="signupEmail" placeholder="name@example.com" required>
                <label for="signupEmail">Email Address</label>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mb-3 position-relative">
                <input type="password" name="password" class="form-control" id="signupPassword" placeholder="Password" minlength="8" required>
                <label for="signupPassword">Password</label>
                <span class="password-toggle" onclick="peekPassword('signupPassword', this)"><i class="fas fa-eye"></i></span>
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-floating mb-3 position-relative">
                <input type="password" name="confirm_password" class="form-control" id="signupConfirmPassword" placeholder="Confirm Password" minlength="8" required>
                <label for="signupConfirmPassword">Confirm Password</label>
                <span class="password-toggle" onclick="peekPassword('signupConfirmPassword', this)"><i class="fas fa-eye"></i></span>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label small text-muted" for="termsCheck">
                    I agree to the <a href="termsofservice.php" class="text-gold text-decoration-none">Terms</a> & <a href="privacypolicy.php" class="text-gold text-decoration-none">Privacy Policy</a>.
                </label>
            </div>

            <button type="submit" class="btn btn-gold w-100 rounded-pill py-2 fw-bold mb-3 shadow-sm" disabled>Sign Up</button>
        </form>

        <div class="divider-with-text"><hr><span>OR</span></div>
        <div class="text-center">
            <span class="small text-muted">Already have an account? </span>
            <a href="#" onclick="switchToLogin(event)" class="small text-gold fw-bold text-decoration-none">Sign In</a>
        </div>
    </div>
</div>