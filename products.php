<?php 
require_once 'config.php';
$page_title = 'Our Collection | CASA VÉRA Furniture'; 
include 'includes/header.php'; 
?>

<link rel="stylesheet" href="css/slider.css">
<link rel="stylesheet" href="css/products.css">

<?php
    $hero_title = "The Collection";
    $hero_desc = "Curated pieces to elevate your modern living.";
    $hero_class = "cv-hero--small"; 
    include 'includes/hero-slider.php'; 
?>

<section class="py-5 bg-light-texture">
    <div class="container">
        <div class="row g-5">
            
            <div class="col-lg-3">
                <div class="filter-sidebar p-4 sticky-top">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                        <h5 class="brand-font mb-0">Filters</h5>
                        <button id="resetFiltersIcon" class="btn p-0 border-0" title="Reset All">
                            <i class="fa-solid fa-arrow-rotate-left"></i>
                        </button>
                    </div>

                    <div class="mb-4">
                        <label class="form-label brand-font small text-uppercase fw-bold">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Find your piece...">
                        </div>
                    </div>

                    <div class="divider-gold mb-4"></div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 cursor-pointer" id="categoryToggle">
                            <label class="brand-font small text-uppercase fw-bold m-0 cursor-pointer">Category</label>
                            <i class="fas fa-chevron-down small transition-transform" id="categoryArrow"></i>
                        </div>
                        <input type="hidden" id="categorySelect" value="All">
                        <div id="categoryList" class="category-list">
                            <div class="category-item active" data-value="All"><span>All Collections</span> <i class="fas fa-check small"></i></div>
                            <div class="category-item" data-value="Living"><span>Living Room</span></div>
                            <div class="category-item" data-value="Dining"><span>Dining Room</span></div>
                            <div class="category-item" data-value="Bedroom"><span>Bedroom</span></div>
                            <div class="category-item" data-value="Storage"><span>Storage</span></div>
                            <div class="category-item" data-value="Lighting"><span>Lighting</span></div>
                            <div class="category-item" data-value="Decor"><span>Decor & Art</span></div>
                        </div>
                    </div>

                    <div class="divider-gold mb-4"></div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 cursor-pointer" id="priceToggle">
                            <label class="brand-font small text-uppercase fw-bold m-0 cursor-pointer">Price Range</label>
                            <i class="fas fa-chevron-down small transition-transform" id="priceArrow"></i>
                        </div>
                        <div id="priceList">
                            <label class="form-label small text-muted d-flex justify-content-between">
                                <span>₱0</span><span id="priceValueMax" class="fw-bold text-dark">₱300,000+</span>
                            </label>
                            <input type="range" class="form-range custom-range" id="priceRange" min="0" max="300000" step="5000" value="300000">
                            <div class="mt-3">
                                <div class="form-check mb-1"><input class="form-check-input" type="radio" name="pricePreset" id="priceAll" value="all" checked><label class="form-check-label small" for="priceAll">Any Price</label></div>
                                <div class="form-check mb-1"><input class="form-check-input" type="radio" name="pricePreset" id="price1" value="0-15000"><label class="form-check-label small" for="price1">Under ₱15k</label></div>
                                <div class="form-check mb-1"><input class="form-check-input" type="radio" name="pricePreset" id="price2" value="15000-50000"><label class="form-check-label small" for="price2">₱15k - ₱50k</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="pricePreset" id="price3" value="50000-1000000"><label class="form-check-label small" for="price3">Premium (₱50k+)</label></div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-gold w-100 btn-sm rounded-0 fw-bold" id="applyFiltersBtn">APPLY FILTERS</button>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 pb-3 border-bottom">
                    <div class="mb-2 mb-md-0">
                        <h2 class="h4 brand-font mb-0" id="collectionTitle">All Collections</h2>
                        <small class="text-muted">Showing <span id="productCount" class="fw-bold text-dark">0</span> results</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <label class="small text-uppercase me-2 fw-bold text-muted">Sort By:</label>
                        <select class="form-select form-select-sm border-0 bg-light rounded-pill px-3" id="sortSelect" style="width: auto;">
                            <option value="newest">Newest Arrivals</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="name_asc">Name: A-Z</option>
                        </select>
                    </div>
                </div>
                <div class="row g-4" id="productGrid"></div>
                <div id="noResults" class="text-center py-5 d-none">
                    <i class="far fa-frown fa-3x text-muted mb-3"></i>
                    <h3 class="brand-font">No matches found</h3>
                    <p class="text-muted">Try adjusting your filters or search term.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<<div id="quickViewOverlay" class="quick-view-overlay">
    <div class="quick-view-card" id="quickViewCard">
        
        <button class="close-quick-view" id="closeQuickView">
            <i class="fas fa-times"></i>
        </button>

        <div class="qv-image-col">
            <img src="" id="qvImage" class="qv-img" alt="Product">
        </div>

        <div class="qv-content-col">
            <div>
                <span id="qvCategory">Category</span>
                <h2 class="brand-font" id="qvName">Product Name</h2>
                <p id="qvDesc">Description text...</p>
            </div>

            <div class="qv-price-area">
                <h3 class="text-gold mb-0" id="qvPrice">₱0.00</h3>
                <span class="badge-luxury static" id="qvBadge">In Stock</span>
            </div>
            
            <div class="qv-buttons">
                <button class="qv-btn qv-btn-cart btn-add-cart-qv">
                     Add to Cart
                </button>
                <button class="qv-btn qv-btn-buy btn-buy-now-qv">
                     Buy Now
                </button>
            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="js/products.js"></script>
<script src="js/animations.js"></script>