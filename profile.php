<?php
require_once 'config.php';
require_once 'classes/Database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: home.php?action=login");
    exit();
}

$db = new Database();
$user_id = $_SESSION['user_id'];
$user = $db->fetchOne("SELECT * FROM users WHERE id = ?", [$user_id]);

// Handle Avatar Upload
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    $filename = $_FILES['avatar']['name'];
    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (in_array($file_ext, $allowed)) {
        if (!is_dir('src/images/avatars')) {
            mkdir('src/images/avatars', 0777, true);
        }
        // Save as user_{id}.jpg for simplicity
        $target_file = 'src/images/avatars/user_' . $user_id . '.jpg';
        move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file);
        // Refresh to show new image
        header("Location: profile.php");
        exit();
    }
}

// Handle Profile Update
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    
    if (!empty($firstname) && !empty($lastname)) {
        // Update DB
        $db->query("UPDATE users SET firstname = ?, lastname = ? WHERE id = ?", [$firstname, $lastname, $user_id]);
        
        // Update Session
        $_SESSION['user_firstname'] = $firstname;
        $_SESSION['user_lastname'] = $lastname;
        
        // Update local variable to reflect changes immediately
        $user['firstname'] = $firstname;
        $user['lastname'] = $lastname;
        
        $success_msg = "Profile updated successfully.";
    } else {
        $error_msg = "All fields are required.";
    }
}

$page_title = 'My Profile | CASA VÉRA Furniture';
$page_class = 'profile-page';
include 'includes/header.php';
?>

<link rel="stylesheet" href="src/css/slider.css">
<link rel="stylesheet" href="src/css/profile.css">

<?php
    $hero_title = "My Profile";
    $hero_desc  = "Manage your account settings and view your order history.";
    $hero_class = "cv-hero--small"; 
    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-light-texture">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="profile-sidebar sticky-top" style="top: 100px; z-index: 1;">
                    <div class="profile-user-info">
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar shadow-sm" id="avatarPreview">
                                <?php 
                                    $avatarPath = 'src/images/avatars/user_' . $user['id'] . '.jpg';
                                    if (file_exists($avatarPath)) {
                                        echo '<img src="' . $avatarPath . '?v=' . time() . '" alt="Profile">';
                                    } else {
                                        echo strtoupper(substr($user['firstname'], 0, 1)); 
                                    }
                                ?>
                            </div>
                            <button class="profile-avatar-upload-btn" onclick="triggerAvatarUpload()" title="Change Photo">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <h4 class="brand-font mb-1"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h4>
                        <p class="text-white-50 small mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="text-gold small mt-2 mb-0"><i class="fas fa-crown me-1"></i> Gold Member</p>
                    </div>
                    <div class="profile-nav nav flex-column" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-dashboard-tab" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard" type="button" role="tab">
                            <i class="fas fa-th-large"></i> Dashboard
                        </button>
                        <button class="nav-link" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" type="button" role="tab">
                            <i class="fas fa-box-open"></i> My Orders
                        </button>
                        <button class="nav-link" id="v-pills-account-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account" type="button" role="tab">
                            <i class="fas fa-user-cog"></i> Account Details
                        </button>
                        <button class="nav-link" id="v-pills-address-tab" data-bs-toggle="pill" data-bs-target="#v-pills-address" type="button" role="tab">
                            <i class="fas fa-map-marker-alt"></i> Addresses
                        </button>
                        <a href="logout.php" class="nav-link text-danger">
                            <i class="fas fa-sign-out-alt text-danger"></i> Logout
                        </a>
                    </div>
                    <!-- Hidden Form for Avatar Upload -->
                    <form id="avatarForm" action="profile.php" method="POST" enctype="multipart/form-data" class="d-none">
                        <input type="file" id="avatarInput" name="avatar" accept="image/*">
                    </form>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-8">
                <div class="tab-content" id="v-pills-tabContent">
                    
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="v-pills-dashboard" role="tabpanel">
                        <div class="profile-content-card animate-fade-up">
                            <h3 class="brand-font mb-4">Hello, <?php echo htmlspecialchars($user['firstname']); ?>!</h3>
                            <p class="text-muted mb-5">From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.</p>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-number">3</div>
                                        <div class="text-muted small text-uppercase ls-1">Total Orders</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-number">0</div>
                                        <div class="text-muted small text-uppercase ls-1">Pending</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-card">
                                        <div class="stat-number">5</div>
                                        <div class="text-muted small text-uppercase ls-1">Wishlist</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <h5 class="brand-font mb-3">Recent Activity</h5>
                                <div class="alert alert-light border-start border-gold border-3" role="alert">
                                    <i class="fas fa-info-circle text-gold me-2"></i> You logged in from a new device on Oct 24, 2023.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="v-pills-orders" role="tabpanel">
                        <div class="profile-content-card animate-fade-up">
                            <h3 class="brand-font mb-4">Order History</h3>
                            
                            <!-- Mock Order Data -->
                            <div class="order-item">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Order #CV-8821</h6>
                                        <p class="text-muted small mb-0">Placed on Oct 15, 2023</p>
                                    </div>
                                    <div class="text-end mt-2 mt-sm-0">
                                        <span class="badge-status status-delivered mb-1 d-inline-block">Delivered</span>
                                        <p class="fw-bold text-dark mb-0">₱35,999.00</p>
                                    </div>
                                </div>
                                <hr class="my-3 text-muted opacity-25">
                                <div class="d-flex align-items-center">
                                    <img src="src/images/royalbedframe.jpg" alt="Product" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px;">
                                    <div>
                                        <p class="mb-0 fw-bold small">Royal Bedframe</p>
                                        <p class="text-muted small mb-0">Qty: 1</p>
                                    </div>
                                    <button class="btn btn-outline-dark btn-sm rounded-pill ms-auto">View Order</button>
                                </div>
                            </div>

                            <div class="order-item">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Order #CV-7742</h6>
                                        <p class="text-muted small mb-0">Placed on Sep 28, 2023</p>
                                    </div>
                                    <div class="text-end mt-2 mt-sm-0">
                                        <span class="badge-status status-shipped mb-1 d-inline-block">Shipped</span>
                                        <p class="fw-bold text-dark mb-0">₱15,500.00</p>
                                    </div>
                                </div>
                                <hr class="my-3 text-muted opacity-25">
                                <div class="d-flex align-items-center">
                                    <img src="src/images/artisanlamp.jpg" alt="Product" class="rounded" style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px;">
                                    <div>
                                        <p class="mb-0 fw-bold small">Artisan Lamp</p>
                                        <p class="text-muted small mb-0">Qty: 1</p>
                                    </div>
                                    <button class="btn btn-outline-dark btn-sm rounded-pill ms-auto">View Order</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Account Details Tab -->
                    <div class="tab-pane fade" id="v-pills-account" role="tabpanel">
                        <div class="profile-content-card animate-fade-up">
                            <h3 class="brand-font mb-4">Account Details</h3>
                            
                            <?php if($success_msg): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $success_msg; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($error_msg): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $error_msg; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <form action="profile.php" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-uppercase fw-bold text-muted">First Name</label>
                                        <input type="text" name="firstname" class="form-control py-2" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-uppercase fw-bold text-muted">Last Name</label>
                                        <input type="text" name="lastname" class="form-control py-2" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small text-uppercase fw-bold text-muted">Email Address</label>
                                        <input type="email" class="form-control py-2 bg-light" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                        <div class="form-text">Email address cannot be changed. Contact support for assistance.</div>
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <h5 class="brand-font border-bottom pb-2 mb-3">Password Change</h5>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label small text-uppercase fw-bold text-muted">Current Password</label>
                                        <input type="password" name="current_password" class="form-control py-2">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-uppercase fw-bold text-muted">New Password</label>
                                        <input type="password" name="new_password" class="form-control py-2">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-uppercase fw-bold text-muted">Confirm New Password</label>
                                        <input type="password" name="confirm_password" class="form-control py-2">
                                    </div>
                                    
                                    <div class="col-12 mt-4">
                                        <button type="submit" name="update_profile" class="btn btn-gold rounded-pill px-5 fw-bold shadow-sm">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Addresses Tab -->
                    <div class="tab-pane fade" id="v-pills-address" role="tabpanel">
                        <div class="profile-content-card animate-fade-up">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="brand-font mb-0">My Addresses</h3>
                                <button class="btn btn-outline-dark btn-sm rounded-pill"><i class="fas fa-plus me-1"></i> Add New</button>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="address-card default">
                                        <div class="card-body position-relative">
                                            <span class="badge bg-gold text-white position-absolute top-0 end-0 m-3">DEFAULT</span>
                                            <h6 class="fw-bold mb-3">Billing Address</h6>
                                            <address class="text-muted small mb-0">
                                                <strong><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></strong><br>
                                                123 Luxury Avenue, BGC<br>
                                                Taguig City, 1634<br>
                                                Philippines<br>
                                                <div class="mt-2"><i class="fas fa-phone me-2"></i> +63 912 345 6789</div>
                                            </address>
                                            <div class="address-actions">
                                                <a href="#" class="text-gold small fw-bold text-decoration-none me-3">Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="address-card">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3">Shipping Address</h6>
                                            <address class="text-muted small mb-0">
                                                <strong>Office</strong><br>
                                                Unit 45, Corporate Center<br>
                                                Makati City, 1200<br>
                                                Philippines<br>
                                                <div class="mt-2"><i class="fas fa-phone me-2"></i> +63 998 765 4321</div>
                                            </address>
                                            <div class="address-actions">
                                                <a href="#" class="text-gold small fw-bold text-decoration-none me-3">Edit</a>
                                                <a href="#" class="text-danger small fw-bold text-decoration-none btn-delete-address">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="src/js/animations.js"></script>
<script src="src/js/profile.js"></script>