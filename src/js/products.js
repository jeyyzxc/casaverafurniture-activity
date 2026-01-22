/**
 * src/js/products.js
 * Handles product listing, filtering, and interactions on products.php
 */

document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    setupFilters();
    setupQuickView();
});

let allProducts = [];

/**
 * Fetch products from backend
 */
function loadProducts() {
    fetch('ajax/get_products.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Error:', data.error);
                return;
            }
            allProducts = data;
            renderProducts(allProducts);
            updateProductCount(allProducts.length);
        })
        .catch(err => console.error('Fetch error:', err));
}

/**
 * Render products to the grid
 */
function renderProducts(products) {
    const grid = document.getElementById('productGrid');
    const noResults = document.getElementById('noResults');
    
    if (!grid) return;

    if (products.length === 0) {
        grid.innerHTML = '';
        if (noResults) noResults.classList.remove('d-none');
        return;
    }

    if (noResults) noResults.classList.add('d-none');

    grid.innerHTML = products.map(p => {
        // Ensure price is a number
        const price = parseFloat(p.price);
        const formattedPrice = price.toLocaleString('en-PH', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        return `
        <div class="col-md-6 col-lg-4 fade-in-up">
            <div class="product-card position-relative h-100 bg-white rounded shadow-sm overflow-hidden">
                ${p.is_new ? '<span class="position-absolute top-0 start-0 m-3 badge bg-gold text-white text-uppercase ls-1" style="z-index:10; font-size:0.7rem;">New</span>' : ''}
                
                <div class="product-img-wrap position-relative overflow-hidden quick-view-trigger cursor-pointer" data-id="${p.id}" style="padding-top: 100%;">
                    <img src="${p.image}" alt="${p.name}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover transition-transform">
                </div>

                <div class="product-info p-3 text-center d-flex flex-column">
                    <h5 class="product-title brand-font mb-1 text-truncate">${p.name}</h5>
                    <p class="small text-muted mb-2">${p.category}</p>
                    <p class="product-price text-gold fw-bold mb-3">₱${formattedPrice}</p>
                    
                    <div class="mt-auto d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3 btn-add-cart" 
                                data-id="${p.id}">
                            Add to Cart
                        </button>
                        <button class="btn btn-gold btn-sm rounded-pill px-3 btn-buy-now text-dark" 
                                data-id="${p.id}">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;
    }).join('');

    attachButtonListeners();
}

/**
 * Attach click listeners to dynamic buttons
 */
function attachButtonListeners() {
    // Add to Cart Logic
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.dataset.id;
            const product = allProducts.find(p => p.id == id);
            if (product && window.App) {
                window.App.addToCart(product, 'add');
            }
        });
    });

    // Buy Now Logic
    document.querySelectorAll('.btn-buy-now').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const id = btn.dataset.id;
            const product = allProducts.find(p => p.id == id);
            if (product && window.App) {
                window.App.addToCart(product, 'buy');
            }
        });
    });

    // Quick View Triggers (Image Click)
    document.querySelectorAll('.quick-view-trigger').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const product = allProducts.find(p => p.id == trigger.dataset.id);
            if (product) openQuickView(product);
        });
    });
}

function updateProductCount(count) {
    const el = document.getElementById('productCount');
    if (el) el.innerText = count;
}

/**
 * Setup Filter & Sort Logic
 */
function setupFilters() {
    const searchInput = document.getElementById('searchInput');
    const categoryItems = document.querySelectorAll('.category-item');
    const priceRange = document.getElementById('priceRange');
    const priceValueMax = document.getElementById('priceValueMax');
    const sortSelect = document.getElementById('sortSelect');
    const applyBtn = document.getElementById('applyFiltersBtn');
    const resetBtn = document.getElementById('resetFiltersIcon');
    const categorySelect = document.getElementById('categorySelect');

    // Category Selection
    categoryItems.forEach(item => {
        item.addEventListener('click', function() {
            categoryItems.forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            if(categorySelect) categorySelect.value = this.dataset.value;
            applyFilters();
        });
    });

    // Price Range Display
    if(priceRange && priceValueMax) {
        priceRange.addEventListener('input', function() {
            priceValueMax.innerText = '₱' + parseInt(this.value).toLocaleString();
            applyFilters();
        });
    }

    // Apply Filters Button
    if(applyBtn) {
        applyBtn.addEventListener('click', applyFilters);
    }

    // Search Input (Debounced)
    if(searchInput) {
        searchInput.addEventListener('keyup', () => applyFilters());
    }

    // Sort Select
    if(sortSelect) {
        sortSelect.addEventListener('change', applyFilters);
    }

    // Reset
    if(resetBtn) {
        resetBtn.addEventListener('click', () => {
            if(searchInput) searchInput.value = '';
            if(categorySelect) categorySelect.value = 'All';
            categoryItems.forEach(i => i.classList.remove('active'));
            
            const allCat = document.querySelector('.category-item[data-value="All"]');
            if (allCat) allCat.classList.add('active');

            if(priceRange) priceRange.value = 300000;
            if(priceValueMax) priceValueMax.innerText = '₱300,000+';
            
            const priceAll = document.getElementById('priceAll');
            if (priceAll) priceAll.checked = true;

            if(sortSelect) sortSelect.value = 'newest';
            applyFilters();
        });
    }

    // Toggle Category Section
    const catToggle = document.getElementById('categoryToggle');
    const catList = document.getElementById('categoryList');
    const catArrow = document.getElementById('categoryArrow');
    if (catToggle && catList) {
        catToggle.addEventListener('click', () => {
            catList.classList.toggle('d-none');
            if (catArrow) catArrow.style.transform = catList.classList.contains('d-none') ? 'rotate(-90deg)' : 'rotate(0deg)';
        });
    }

    // Toggle Price Section
    const priceToggle = document.getElementById('priceToggle');
    const priceList = document.getElementById('priceList');
    const priceArrow = document.getElementById('priceArrow');
    if (priceToggle && priceList) {
        priceToggle.addEventListener('click', () => {
            priceList.classList.toggle('d-none');
            if (priceArrow) priceArrow.style.transform = priceList.classList.contains('d-none') ? 'rotate(-90deg)' : 'rotate(0deg)';
        });
    }
}

function applyFilters() {
    const search = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const category = document.getElementById('categorySelect')?.value || 'All';
    const maxPrice = parseInt(document.getElementById('priceRange')?.value || 300000);
    const sort = document.getElementById('sortSelect')?.value || 'newest';

    let filtered = allProducts.filter(p => {
        const matchesSearch = p.name.toLowerCase().includes(search);
        const matchesCategory = category === 'All' || p.category === category;
        const matchesPrice = parseFloat(p.price) <= maxPrice;
        return matchesSearch && matchesCategory && matchesPrice;
    });

    // Sorting
    filtered.sort((a, b) => {
        if (sort === 'price_low') return parseFloat(a.price) - parseFloat(b.price);
        if (sort === 'price_high') return parseFloat(b.price) - parseFloat(a.price);
        if (sort === 'name_asc') return a.name.localeCompare(b.name);
        // newest (default) - assuming higher ID is newer or using date_added if available
        return b.id - a.id; 
    });

    renderProducts(filtered);
    updateProductCount(filtered.length);
}

/**
 * Quick View Modal Logic
 */
function setupQuickView() {
    const overlay = document.getElementById('quickViewOverlay');
    const closeBtn = document.getElementById('closeQuickView');
    const addBtn = document.querySelector('.btn-add-cart-qv');
    const buyBtn = document.querySelector('.btn-buy-now-qv');

    // Close Modal
    if (closeBtn) {
        closeBtn.addEventListener('click', closeQuickView);
    }
    if (overlay) {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeQuickView();
        });
    }

    // Modal Add to Cart
    if (addBtn) {
        addBtn.addEventListener('click', () => {
            const id = addBtn.dataset.id;
            const product = allProducts.find(p => p.id == id);
            if (product && window.App) {
                window.App.addToCart(product, 'add');
                closeQuickView();
            }
        });
    }

    // Modal Buy Now
    if (buyBtn) {
        buyBtn.addEventListener('click', () => {
            const id = buyBtn.dataset.id;
            const product = allProducts.find(p => p.id == id);
            if (product && window.App) {
                window.App.addToCart(product, 'buy');
                closeQuickView();
            }
        });
    }
}

function openQuickView(product) {
    document.getElementById('qvImage').src = product.image;
    document.getElementById('qvCategory').innerText = product.category;
    document.getElementById('qvName').innerText = product.name;
    document.getElementById('qvDesc').innerText = product.description || 'Experience luxury with this handcrafted piece, designed to bring elegance and comfort to your home.';
    document.getElementById('qvPrice').innerText = '₱' + parseFloat(product.price).toLocaleString('en-PH', {minimumFractionDigits: 2});
    
    document.querySelector('.btn-add-cart-qv').dataset.id = product.id;
    document.querySelector('.btn-buy-now-qv').dataset.id = product.id;

    document.getElementById('quickViewOverlay').classList.add('active');
}

function closeQuickView() {
    document.getElementById('quickViewOverlay').classList.remove('active');
}