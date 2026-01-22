/**
 * products.js
 * Handles product rendering, filtering, sorting, and QUICK VIEW logic.
 */

/**
 * products.js
 * Handles product rendering, filtering, sorting, and Quick View.
 */

const ProductManager = (() => {
    
    // 1. STATE & DATA
    const defaultState = {
        filters: { search: '', category: 'All', minPrice: 0, maxPrice: 300000 },
        sort: 'newest'
    };

    let state = JSON.parse(JSON.stringify(defaultState));
    let allProducts = [];

    // 2. DOM ELEMENTS
    const dom = {
        grid: document.getElementById('productGrid'),
        count: document.getElementById('productCount'),
        collectionTitle: document.getElementById('collectionTitle'),
        noResults: document.getElementById('noResults'),
        inputs: {
            search: document.getElementById('searchInput'),
            categoryItems: document.querySelectorAll('.category-item'),
            priceRange: document.getElementById('priceRange'),
            priceMaxDisplay: document.getElementById('priceValueMax'),
            pricePresets: document.getElementsByName('pricePreset'),
            sort: document.getElementById('sortSelect'),
            resetBtn: document.getElementById('resetFiltersIcon'),
            applyBtn: document.getElementById('applyFiltersBtn')
        },
        qv: {
            overlay: document.getElementById('quickViewOverlay'),
            card: document.getElementById('quickViewCard'),
            close: document.getElementById('closeQuickView'),
            imgContainer: document.querySelector('.qv-image-col'),
            img: document.getElementById('qvImage'),
            name: document.getElementById('qvName'),
            cat: document.getElementById('qvCategory'),
            price: document.getElementById('qvPrice'),
            desc: document.getElementById('qvDesc'),
            btnCart: document.querySelector('.btn-add-cart-qv'),
            btnBuy: document.querySelector('.btn-buy-now-qv')
        }
    };

    // 3. RENDER LOGIC
    const render = () => {
        let filtered = allProducts.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(state.filters.search);
            const matchesCat = state.filters.category === 'All' || p.category === state.filters.category;
            const pPrice = Number(p.price);
            const matchesPrice = pPrice >= state.filters.minPrice && pPrice <= state.filters.maxPrice;
            return matchesSearch && matchesCat && matchesPrice;
        });

        switch (state.sort) {
            case 'price_low':  filtered.sort((a, b) => Number(a.price) - Number(b.price)); break;
            case 'price_high': filtered.sort((a, b) => Number(b.price) - Number(a.price)); break;
            case 'name_asc':   filtered.sort((a, b) => a.name.localeCompare(b.name)); break;
            case 'newest':     
            default:           filtered.sort((a, b) => new Date(b.date_added) - new Date(a.date_added)); break;
        }

        dom.grid.innerHTML = '';
        dom.count.textContent = filtered.length;
        dom.collectionTitle.textContent = state.filters.category === 'All' ? 'All Collections' : `${state.filters.category} Collection`;

        if (filtered.length === 0) {
            dom.noResults.classList.remove('d-none');
        } else {
            dom.noResults.classList.add('d-none');
            
            filtered.forEach((product, index) => {
                const priceFormatted = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(product.price);
                const isNew = product.is_new == 1;
                const badge = isNew ? '<span class="badge-luxury">New Arrival</span>' : '';
                const imagePath = product.image.includes('/') ? product.image : `src/images/${product.image}`;

                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';
                col.style.animation = `fadeInUp 0.5s ease-out forwards ${index * 0.05}s`; 

                col.innerHTML = `
                    <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                        <div class="product-img-wrapper">
                            ${badge} 
                            <img src="${imagePath}" class="product-img trigger-qv" data-id="${product.id}" alt="${product.name}" loading="lazy" style="cursor: pointer;">
                            <div class="product-actions-overlay">
                                <button class="btn-action-icon btn-buy-now" data-id="${product.id}" title="Buy Now">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </button>
                                <button class="btn-action-icon btn-add-cart" data-id="${product.id}" title="Add to Cart">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body text-center p-4">
                            <small class="text-muted text-uppercase ls-1" style="font-size: 0.7rem;">${product.category}</small>
                            <h5 class="card-title brand-font mt-2 mb-2">
                                <a href="#" class="text-dark text-decoration-none hover-gold transition trigger-qv" data-id="${product.id}">${product.name}</a>
                            </h5>
                            <div class="text-gold fw-bold h6 mb-0">${priceFormatted}</div>
                        </div>
                    </div>
                `;
                dom.grid.appendChild(col);
            });
            attachEvents();
        }
    };

    // 4. ATTACH EVENTS
    const attachEvents = () => {
        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); e.stopPropagation();
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                const product = allProducts.find(p => p.id === id);
                if(product && window.App) window.App.addToCart(product); 
            });
        });

        document.querySelectorAll('.btn-buy-now').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); e.stopPropagation();
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                const product = allProducts.find(p => p.id === id);
                if(product && window.App) {
                    window.App.addToCart(product, () => {
                        window.location.href = 'cart.php';
                    });
                }
            });
        });

        document.querySelectorAll('.trigger-qv').forEach(el => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                openQuickView(id);
            });
        });
    };

    // 5. QUICK VIEW LOGIC
    const openQuickView = (id) => {
        const product = allProducts.find(p => p.id === id);
        if(!product) return;

        dom.qv.img.src = product.image.includes('/') ? product.image : `src/images/${product.image}`;
        dom.qv.name.textContent = product.name;
        dom.qv.cat.textContent = product.category;
        dom.qv.price.textContent = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(product.price);
        dom.qv.desc.textContent = product.description || "Experience the epitome of luxury with this handcrafted piece.";

        const existingBadge = dom.qv.imgContainer.querySelector('.badge-luxury');
        if(existingBadge) existingBadge.remove();

        const newCartBtn = dom.qv.btnCart.cloneNode(true);
        const newBuyBtn = dom.qv.btnBuy.cloneNode(true);
        dom.qv.btnCart.parentNode.replaceChild(newCartBtn, dom.qv.btnCart);
        dom.qv.btnBuy.parentNode.replaceChild(newBuyBtn, dom.qv.btnBuy);
        dom.qv.btnCart = newCartBtn;
        dom.qv.btnBuy = newBuyBtn;

        dom.qv.btnCart.addEventListener('click', () => { if(window.App) window.App.addToCart(product); });
        dom.qv.btnBuy.addEventListener('click', () => { if(window.App) window.App.addToCart(product, () => { window.location.href = 'cart.php'; }); });

        dom.qv.overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    };

    const closeQuickView = () => {
        dom.qv.overlay.classList.remove('active');
        document.body.style.overflow = '';
    };

    // 6. INITIALIZE EVENTS
    const initEvents = () => {
        dom.inputs.search.addEventListener('input', (e) => { state.filters.search = e.target.value.toLowerCase().trim(); render(); });
        
        dom.inputs.categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                dom.inputs.categoryItems.forEach(i => { i.classList.remove('active'); if(i.querySelector('.fa-check')) i.querySelector('.fa-check').remove(); });
                this.classList.add('active'); this.innerHTML += ` <i class="fas fa-check small"></i>`;
                state.filters.category = this.getAttribute('data-value'); render();
            });
        });

        dom.inputs.priceRange.addEventListener('input', function() {
            state.filters.minPrice = 0; state.filters.maxPrice = parseInt(this.value);
            dom.inputs.priceMaxDisplay.textContent = `₱${parseInt(this.value).toLocaleString()}`;
            document.getElementById('priceAll').checked = true; render();
        });

        dom.inputs.pricePresets.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    if (this.value === 'all') { state.filters.minPrice = 0; state.filters.maxPrice = 300000; } 
                    else { const [min, max] = this.value.split('-').map(Number); state.filters.minPrice = min; state.filters.maxPrice = max; }
                    dom.inputs.priceRange.value = state.filters.maxPrice;
                    dom.inputs.priceMaxDisplay.textContent = `₱${state.filters.maxPrice.toLocaleString()}`;
                    render();
                }
            });
        });

        dom.inputs.sort.addEventListener('change', (e) => { state.sort = e.target.value; render(); });
        
        dom.inputs.applyBtn.addEventListener('click', () => { render(); dom.grid.scrollIntoView({ behavior: 'smooth', block: 'start' }); });

        dom.inputs.resetBtn.addEventListener('click', () => {
            state = JSON.parse(JSON.stringify(defaultState));
            dom.inputs.search.value = '';
            dom.inputs.categoryItems.forEach(i => { i.classList.remove('active'); if(i.querySelector('.fa-check')) i.querySelector('.fa-check').remove(); });
            const allCat = document.querySelector('.category-item[data-value="All"]');
            if(allCat) { allCat.classList.add('active'); allCat.innerHTML += ` <i class="fas fa-check small"></i>`; }
            dom.inputs.priceRange.value = 300000; dom.inputs.priceMaxDisplay.textContent = '₱300,000+';
            document.getElementById('priceAll').checked = true; dom.inputs.sort.value = 'newest';
            render();
        });

        dom.qv.close.addEventListener('click', closeQuickView);
        dom.qv.overlay.addEventListener('click', (e) => { if(e.target === dom.qv.overlay) closeQuickView(); });
        document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeQuickView(); });

        // I. FILTER TOGGLE LOGIC (New Addition)
        const toggleFilter = (toggleId, listId, arrowId) => {
            const toggle = document.getElementById(toggleId);
            const list = document.getElementById(listId);
            const arrow = document.getElementById(arrowId);
            
            if(toggle && list && arrow) {
                toggle.addEventListener('click', () => {
                    list.classList.toggle('d-none');
                    // Rotate arrow: 0deg is down (open), -90deg is side (closed)
                    arrow.style.transform = list.classList.contains('d-none') 
                        ? 'rotate(-90deg)' 
                        : 'rotate(0deg)';
                });
            }
        };

        toggleFilter('categoryToggle', 'categoryList', 'categoryArrow');
        toggleFilter('priceToggle', 'priceList', 'priceArrow');
    };

    return {
        init: () => {
            fetch('ajax/get_products.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) { dom.grid.innerHTML = `<div class="col-12 text-center text-danger py-5">Error loading products.</div>`; return; }
                    allProducts = data; initEvents(); render();
                })
                .catch(err => { dom.grid.innerHTML = `<div class="col-12 text-center text-danger py-5">Failed to connect to server.</div>`; });
        }
    };
})();

document.addEventListener('DOMContentLoaded', ProductManager.init);