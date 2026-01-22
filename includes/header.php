<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title ?? 'CASA VÉRA'); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header-footer.css">
    <link rel="stylesheet" href="css/login-signupModal.css">
</head>
<body class="<?php echo htmlspecialchars($page_class ?? ''); ?>">

<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container-fluid px-4 px-lg-5">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-line"></span>
            <span class="toggler-line"></span>
            <span class="toggler-line"></span>
        </button>

        <div class="navbar-brand-centered">
            <a href="home.php" class="brand-logo">CASA VÉRA</a>
            <span class="brand-tagline">Est. 2022</span>
        </div>

        <div class="collapse navbar-collapse" id="navbarContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-center">
                <?php 
                    $navItems = [
                        'Home' => 'home.php',
                        'Collection' => 'products.php', 
                        'Contact' => 'contactUs.php',
                        'About' => 'about.php'
                    ];
                    
                    foreach($navItems as $name => $link): 
                        // Logic to check active page
                        $isActive = ($page_title == $name || ($name == 'Collection' && strpos($page_title, 'Products') !== false)) ? 'active' : '';
                ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $isActive; ?>" href="<?php echo $link; ?>"><?php echo $name; ?></a>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="nav-actions d-flex align-items-center">
                <a href="cart.php" class="nav-icon-link ms-4 position-relative" title="View Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge-cart">0</span>
                </a>

                <a href="#" onclick="openLoginModal(event)" class="nav-link special-login-link ms-3">
                    Login
                </a>
            </div>

        </div>
    </div>
</nav>