<?php
require_once 'config.php';
require_once 'classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

// 1. Sanitize Inputs
$firstname = htmlspecialchars(trim($_POST['firstname']));
$lastname  = htmlspecialchars(trim($_POST['lastname']));
$email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$pass      = $_POST['password'];
$confirm   = $_POST['confirm_password'];

$errors = [];

// 2. Strict Validation Rules
if (empty($firstname) || empty($lastname)) {
    $errors[] = "First and Last Name are required.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
}
if ($pass !== $confirm) {
    $errors[] = "Passwords do not match.";
}
if (strlen($pass) < 8) {
    $errors[] = "Password must be at least 8 characters.";
}

// 3. Database Check & Insertion
if (empty($errors)) {
    $db = new Database();
    
    // Check for Duplicate Email
    $existing = $db->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
    if ($existing) {
        $errors[] = "Email is already registered.";
    } else {
        // Hash Password (Argon2ID or Bcrypt)
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $db->query(
                "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)", 
                [$firstname, $lastname, $email, $hashedPass]
            );
            
            // Auto-Login after Signup
            $_SESSION['user_id'] = $db->lastInsertId();
            $_SESSION['user_firstname'] = $firstname;
            $_SESSION['user_lastname'] = $lastname;

            header("Location: index.php?success=Account created successfully");
            exit();

        } catch (Exception $e) {
            $errors[] = "System error: " . $e->getMessage();
        }
    }
}

// Return with Errors
$errorString = urlencode(implode(' ', $errors));
header("Location: index.php?error=$errorString&action=signup");
exit();
?>