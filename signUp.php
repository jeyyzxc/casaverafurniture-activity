<?php
require_once 'config.php';
require_once 'classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname  = htmlspecialchars(trim($_POST['lastname']));
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    $errors = [];

    // 1. Strict Validation Rules
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // 2. Database Verification (1 is to 1 check)
    if (empty($errors)) {
        $db = new Database();
        
        // Check if account already exists (Strict)
        $existing = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
        
        if ($existing) {
            $errors[] = "An account with this email already exists.";
        } else {
            // Create Account
            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            
            try {
                $db->query(
                    "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)", 
                    [$firstname, $lastname, $email, $hashedPass]
                );
                
                // Auto-Login
                session_regenerate_id(true);
                $_SESSION['user_id'] = $db->lastInsertId();
                $_SESSION['user_firstname'] = $firstname;
                $_SESSION['user_lastname'] = $lastname;

                header("Location: home.php?success=Account created successfully");
                exit();

            } catch (Exception $e) {
                $errors[] = "System error: " . $e->getMessage();
            }
        }
    }

    // Return with Errors
    if (!empty($errors)) {
        $errorString = urlencode(implode(' ', $errors));
        header("Location: home.php?error=$errorString&action=signup");
        exit();
    }
}
?>
<div id="signupModal" class="cv-modal-overlay">
    <div class="cv-modal-box">
        <button class="cv-modal-close" onclick="closeSignupModal()"><i class="fas fa-times"></i></button>

        <div class="text-center mb-4">
            <h2 class="brand-font h3">Create Account</h2>
            <p class="text-muted small">Join the CASA VÉRA community.</p>
        </div>

        <form id="signupForm" action="signup.php" method="POST" class="needs-validation" novalidate>
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