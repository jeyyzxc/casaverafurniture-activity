<?php 
require_once 'config.php'; // 1. Start Session & DB Connection
require_once 'classes/Database.php';
$page_title = 'CASA VÉRA - Timeless Furniture'; 
$page_class = 'home-page'; 
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="src/css/slider.css">
<link rel="stylesheet" href="src/css/home.css">

<?php
    $hero_btn_text = "Explore Collection";
    $hero_btn_link = "products.php";
    include 'includes/hero-slider.php'; 
?>

<section class="section-padding bg-light-texture overflow-hidden scroll-rise-up">
    <div class="container-fluid mb-5">
        <div class="text-center mb-5">
            <span class="text-gold text-uppercase ls-2 small fw-bold">Exclusive Designs</span>
            <h2 class="display-4 brand-font mt-2">The Spotlight</h2>
        </div>
    </div>

    <div class="film-roll-container">
        <div class="film-track" id="filmTrack">
            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Oak Sideboard">
                    <div class="film-img-box"><img src="src/images/sideboard1.jpg" alt="Oak Sideboard"></div>
                </a>
                <div class="film-details"><h4>Oak Sideboard</h4><p>₱5,999.00</p></div>
            </div>
            
            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Velvet Armchair">
                    <div class="film-img-box"><img src="src/images/velvetarmchair.jpg" alt="Velvet Armchair"></div>
                </a>
                <div class="film-details"><h4>Velvet Armchair</h4><p>₱6,599.00</p></div>
            </div>

            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Marble Dining Table">
                    <div class="film-img-box"><img src="src/images/marbledining.jpg" alt="Marble Dining Table"></div>
                </a>
                <div class="film-details"><h4>Marble Dining Table</h4><p>₱24,500.00</p></div>
            </div>

            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Royal Bedframe">
                    <div class="film-img-box"><img src="src/images/royalbedframe.jpg" alt="Royal Bedframe"></div>
                </a>
                <div class="film-details"><h4>Royal Bedframe</h4><p>₱35,999.00</p></div>
            </div>

            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Lounge Sofa">
                    <div class="film-img-box"><img src="src/images/loungesofa.jpg" alt="Lounge Sofa"></div>
                </a>
                <div class="film-details"><h4>Lounge Sofa</h4><p>₱27,599.00</p></div>
            </div>

            <div class="film-card">
                <a href="products.php" class="film-link" aria-label="View Artisan Lamp">
                    <div class="film-img-box"><img src="src/images/artisanlamp.jpg" alt="Artisan Lamp"></div>
                </a>
                <div class="film-details"><h4>Artisan Lamp</h4><p>₱15,500.00</p></div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding bg-white scroll-rise-up">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 brand-font">Signature Collection</h2>
            <p class="text-muted">Handpicked favorites for your home.</p>
        </div>

        <div class="row g-4">
            <?php
            $db = new Database();
            // Fetch 4 products for the signature collection
            $products = $db->fetchAll("SELECT * FROM products LIMIT 4");
            
            foreach ($products as $index => $product): 
                // Fix image path logic: Map 'images' column and handle path
                $imgVal = !empty($product['images']) ? $product['images'] : 'placeholder.jpg';
                
                // If path doesn't contain '/', prepend 'src/images/'
                $imagePath = (strpos($imgVal, '/') === false) 
                    ? 'src/images/' . $imgVal 
                    : $imgVal;
            ?>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card position-relative">
                        <?php if ($index < 2): ?>
                            <span class="position-absolute top-0 start-0 m-3 badge text-white text-uppercase ls-1" style="background-color: #FFD61F; z-index: 10; font-size: 0.7rem; padding: 0.6em 1.2em; border-radius: 3;">Best Seller</span>
                        <?php endif; ?>
                        <div class="product-img-wrap">
                            <a href="products.php" class="product-link">
                                <img src="<?php echo htmlspecialchars($imagePath); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </a>
                        </div>
                        <div class="product-info mt-3 text-center">
                            <h5 class="product-title brand-font"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="product-price">₱<?php echo number_format($product['price'], 2); ?></p>
                            <button class="btn btn-outline-dark btn-sm rounded-pill px-4 btn-action-home" 
                                    data-id="<?php echo $product['id']; ?>" data-action="add">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-light-texture scroll-rise-up">
    <div class="container">
        <div class="row mb-5 align-items-end">
            <div class="col-md-8">
                <h2 class="display-5 brand-font mb-0">Curated Spaces</h2>
                <p class="text-muted mt-2">Design your perfect sanctuary, room by room.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="products.php" class="link-gold text-uppercase fw-bold ls-2 text-decoration-none">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <a href="products.php?cat=living" class="category-card large">
                    <div class="category-img" style="background-image: url('src/images/livingroom.jpg');"></div>
                    <div class="category-overlay">
                        <div class="category-content">
                            <span class="category-subtitle">Gather & Relax</span>
                            <h3 class="category-title">Living Room</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="products.php?cat=dining" class="category-card">
                    <div class="category-img" style="background-image: url('src/images/housedining.jpg');"></div>
                    <div class="category-overlay">
                        <div class="category-content">
                            <span class="category-subtitle">Feast in Style</span>
                            <h3 class="category-title">Dining</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4">
                <a href="products.php?cat=bedroom" class="category-card">
                    <div class="category-img" style="background-image: url('src/images/bedroom.jpg');"></div>
                    <div class="category-overlay">
                        <div class="category-content">
                            <span class="category-subtitle">Dream & Rest</span>
                            <h3 class="category-title">Bedroom</h3>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-8">
                <a href="products.php?cat=office" class="category-card large">
                    <div class="category-img" style="background-image: url('src/images/officedecor.jpg');"></div>
                    <div class="category-overlay">
                        <div class="category-content">
                            <span class="category-subtitle">Work & Inspire</span>
                            <h3 class="category-title">Office & Decor</h3>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
<script src="src/js/animations.js"></script>
<script src="src/js/home.js"></script>
<script>
    // Fix: Ensure Add to Cart works on Home Page
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.btn-action-home').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                if(window.App) window.App.addToCart({ id: id }, 'add', null);
            });
        });
    });
</script>