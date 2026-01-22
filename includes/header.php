<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Handle Logout Logic
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title ?? 'CASA VÉRA'); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/css/header-footer.css">
    <link rel="stylesheet" href="src/css/login-signupModal.css">
</head>
<body class="<?php echo htmlspecialchars($page_class ?? ''); ?>">

<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container-fluid px-4 px-lg-5">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="toggler-line"></span><span class="toggler-line"></span><span class="toggler-line"></span>
        </button>

        <div class="navbar-brand-centered">
            <a href="home.php" class="brand-logo">CASA VÉRA</a>
            <span class="brand-tagline">Est. 2022</span>
        </div>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Collection</a></li>
                <li class="nav-item"><a class="nav-link" href="contactUs.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            </ul>

            <div class="nav-actions d-flex align-items-center">
                <a href="cart.php" class="nav-icon-link ms-4 position-relative" title="View Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge-cart"><?php echo $_SESSION['cart_count'] ?? 0; ?></span>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle fw-bold text-gold" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> 
                            <?php echo htmlspecialchars($_SESSION['user_firstname']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow" style="background: rgba(10,10,10,0.95);">
                            <li><a class="dropdown-item text-white hover-gold" href="profile.php">My Profile</a></li>
                            <li><hr class="dropdown-divider bg-light opacity-25"></li>
                            <li><a class="dropdown-item text-danger" href="?logout=1">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="#" onclick="openLoginModal(event)" class="nav-link special-login-link ms-3">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>