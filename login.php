<?php
require_once 'config.php';
require_once 'classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']); // Matches your modal input name
    $password = $_POST['password'];

    $db = new Database();
    // Fetch user based on email
    $user = $db->fetchOne("SELECT * FROM users WHERE email = ?", [$email]);

    // Verify Password
    if ($user && password_verify($password, $user['password'])) {
        // SUCCESS: Set Session "Keys"
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['firstname']; // Assuming 'firstname' column exists

        // Redirect back to home with success message
        header("Location: index.php?success=Welcome back");
        exit();
    } else {
        // FAILURE: Redirect with error
        header("Location: index.php?error=Invalid credentials");
        exit();
    }
}
?>

<div id="loginModal" class="cv-modal-overlay">
    <div class="cv-modal-box">
        
        <button class="cv-modal-close" onclick="closeLoginModal()">
            <i class="fas fa-times"></i>
        </button>

        <div class="text-center mb-4">
            <h2 class="brand-font h3">Welcome Back</h2>
            <p class="text-muted small">Sign in to access your curated collection.</p>
        </div>

        <form id="loginForm" action="process_login.php" method="POST" novalidate>
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="modalEmail" placeholder="name@example.com" required>
                <label for="modalEmail">Email Address</label>
                <div class="invalid-feedback"></div>
            </div>
            
            <div class="form-floating mb-3 position-relative">
                <input type="password" class="form-control" id="modalPassword" placeholder="Password" required>
                <label for="modalPassword">Password</label>
                <span class="password-toggle" onclick="peekPassword('modalPassword', this)">
                    <i class="fas fa-eye"></i>
                </span>
                <div class="invalid-feedback"></div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label small text-muted" for="rememberMe">Remember me</label>
                </div>
                <a href="forgot-password.php" class="small text-gold text-decoration-none">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-gold w-100 rounded-pill py-2 fw-bold mb-3 shadow-sm">Sign In</button>
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
            Continue with Google
        </a>
            
        <div class="text-center">
            <span class="small text-muted">Don't have an account? </span>
            <a href="#" onclick="openSignupModal(event)" class="small text-gold fw-bold text-decoration-none">Create Account</a>
        </div>
    </div>
</div>