/**
 * products.js
 * Handles product rendering, filtering, and sorting.
 * Depends on: App.js (for Cart)
 */

const ProductManager = (() => {
    
    // 1. STATE & DATA
    const state = {
        products: [
            { id: 1, name: "The Italian Sofa", category: "Living", price: 185000.00, image: "p1.jpg", isNew: true, dateAdded: "2023-10-01" },
            { id: 2, name: "Marble Dining Table", category: "Dining", price: 125000.00, image: "p2.jpg", isNew: false, dateAdded: "2023-09-15" },
            { id: 3, name: "Crystal Chandelier", category: "Lighting", price: 65000.00, image: "p3.jpg", isNew: false, dateAdded: "2023-08-20" },
            { id: 4, name: "Velvet Armchair", category: "Living", price: 45000.00, image: "p1.jpg", isNew: false, dateAdded: "2023-09-10" },
            { id: 5, name: "Royal King Bed", category: "Bedroom", price: 280000.00, image: "p2.jpg", isNew: true, dateAdded: "2023-10-05" },
            { id: 6, name: "Abstract Gold Vase", category: "Decor", price: 18500.00, image: "p3.jpg", isNew: true, dateAdded: "2023-10-10" },
            { id: 7, name: "Minimalist Lamp", category: "Lighting", price: 4500.00, image: "p1.jpg", isNew: false, dateAdded: "2023-07-10" },
            { id: 8, name: "Silk Throw Pillow", category: "Decor", price: 2500.00, image: "p2.jpg", isNew: false, dateAdded: "2023-06-10" }
        ],
        filters: {
            search: '',
            category: 'All',
            minPrice: 0,
            maxPrice: 300000
        },
        sort: 'newest'
    };

    // 2. DOM ELEMENTS
    const dom = {
        grid: document.getElementById('productGrid'),
        count: document.getElementById('productCount'),
        noResults: document.getElementById('noResults'),
        inputs: {
            search: document.getElementById('searchInput'),
            categoryItems: document.querySelectorAll('.category-item'),
            categoryHidden: document.getElementById('categorySelect'),
            priceRange: document.getElementById('priceRange'),
            priceMaxDisplay: document.getElementById('priceValueMax'),
            pricePresets: document.getElementsByName('pricePreset'),
            sort: document.getElementById('sortSelect'),
            resetBtn: document.getElementById('resetFiltersIcon'), // Updated ID
            applyBtn: document.getElementById('applyFiltersBtn')   // New ID
        },
        toggles: {
            cat: document.getElementById('categoryToggle'),
            catList: document.getElementById('categoryList'),
            catArrow: document.getElementById('categoryArrow'),
            price: document.getElementById('priceToggle'),
            priceList: document.getElementById('priceList'),
            priceArrow: document.getElementById('priceArrow')
        }
    };

    // 3. RENDER LOGIC
    const render = () => {
        // A. Filter
        let filtered = state.products.filter(p => {
            const matchesSearch = p.name.toLowerCase().includes(state.filters.search);
            const matchesCat = state.filters.category === 'All' || p.category === state.filters.category;
            const matchesPrice = p.price >= state.filters.minPrice && p.price <= state.filters.maxPrice;
            return matchesSearch && matchesCat && matchesPrice;
        });

        // B. Sort
        if (state.sort === 'price_low') filtered.sort((a, b) => a.price - b.price);
        else if (state.sort === 'price_high') filtered.sort((a, b) => b.price - a.price);
        else if (state.sort === 'newest') filtered.sort((a, b) => new Date(b.dateAdded) - new Date(a.dateAdded));
        else if (state.sort === 'name_asc') filtered.sort((a, b) => a.name.localeCompare(b.name));

        // C. Update UI
        dom.grid.innerHTML = '';
        dom.count.textContent = filtered.length;

        if (filtered.length === 0) {
            dom.noResults.classList.remove('d-none');
            return;
        } else {
            dom.noResults.classList.add('d-none');
        }

        // D. Create Cards
        filtered.forEach((product, index) => {
            const price = new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(product.price);
            const badge = product.isNew ? '<span class="badge-luxury">New Arrival</span>' : '';
            
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4';
            col.style.animation = `fadeInUp 0.5s ease-out forwards ${index * 0.05}s`; // Staggered Animation
            
            col.innerHTML = `
                <div class="card h-100 border-0 shadow-sm product-card overflow-hidden">
                    <div class="product-img-wrapper">
                        ${badge}
                        <img src="src/images/${product.image}" class="product-img" alt="${product.name}">
                        
                        <div class="product-actions-overlay">
                            <a href="product-details.php?id=${product.id}" class="btn-action-icon" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button class="btn-action-icon btn-add-cart" data-id="${product.id}" title="Add to Cart">
                                <i class="fas fa-shopping-bag"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body text-center p-4">
                        <small class="text-muted text-uppercase ls-1" style="font-size: 0.7rem;">${product.category}</small>
                        <h5 class="card-title brand-font mt-2 mb-2">
                            <a href="product-details.php?id=${product.id}" class="text-dark text-decoration-none hover-gold transition">${product.name}</a>
                        </h5>
                        <div class="text-gold fw-bold h6 mb-0">${price}</div>
                    </div>
                </div>
            `;
            dom.grid.appendChild(col);
        });

        // E. Attach Events to New Buttons
        document.querySelectorAll('.btn-add-cart').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const id = parseInt(e.currentTarget.getAttribute('data-id'));
                const product = state.products.find(p => p.id === id);
                if(product && window.App) {
                    window.App.addToCart(product);
                }
            });
        });
    };

    // 4. EVENT HANDLERS
    const initEvents = () => {
        // Search
        dom.inputs.search.addEventListener('input', (e) => {
            state.filters.search = e.target.value.toLowerCase();
            render();
        });

        // Category Click
        dom.inputs.categoryItems.forEach(item => {
            item.addEventListener('click', function() {
                // UI Update
                dom.inputs.categoryItems.forEach(i => {
                    i.classList.remove('active');
                    const icon = i.querySelector('.fa-check');
                    if(icon) icon.remove();
                });
                this.classList.add('active');
                this.innerHTML = `<span>${this.innerText}</span> <i class="fas fa-check small"></i>`;
                
                // Logic Update
                state.filters.category = this.getAttribute('data-value');
                document.getElementById('collectionTitle').textContent = this.innerText + 's';
                render();
            });
        });

        // Price Slider
        dom.inputs.priceRange.addEventListener('input', function() {
            // Uncheck presets if using slider
            document.getElementById('priceAll').checked = true;
            state.filters.minPrice = 0;
            state.filters.maxPrice = parseInt(this.value);
            
            dom.inputs.priceMaxDisplay.textContent = `₱${parseInt(this.value).toLocaleString()}`;
            render();
        });

        // Price Presets
        dom.inputs.pricePresets.forEach(radio => {
            radio.addEventListener('change', function() {
                if(this.value === 'all') {
                    state.filters.minPrice = 0;
                    state.filters.maxPrice = 10000000;
                    // Reset Slider Visual
                    dom.inputs.priceRange.value = 300000;
                    dom.inputs.priceMaxDisplay.textContent = '₱300,000+';
                } else {
                    const [min, max] = this.value.split('-').map(Number);
                    state.filters.minPrice = min;
                    state.filters.maxPrice = max;
                }
                render();
            });
        });

        // Sort
        dom.inputs.sort.addEventListener('change', (e) => {
            state.sort = e.target.value;
            render();
        });

        // APPLY BUTTON (New Logic)
        dom.inputs.applyBtn.addEventListener('click', () => {
            // Optional: Scroll to top of grid for better UX
            dom.grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            render(); // Trigger the filter logic
        });

        // Reset
        dom.inputs.resetBtn.addEventListener('click', () => {
            // Visual Rotation Effect
            const icon = dom.inputs.resetBtn.querySelector('i');
            icon.style.transition = 'transform 0.5s ease';
            icon.style.transform = 'rotate(-360deg)';
            setTimeout(() => icon.style.transform = 'none', 500);

            // Reset Data State
            state.filters = { search: '', category: 'All', minPrice: 0, maxPrice: 300000 };
            state.sort = 'newest';
            
            // Reset UI Elements
            dom.inputs.search.value = '';
            dom.inputs.categoryItems.forEach(i => i.classList.remove('active'));
            dom.inputs.categoryItems[0].classList.add('active'); // Select 'All'
            dom.inputs.priceRange.value = 300000;
            dom.inputs.priceMaxDisplay.textContent = '₱300,000+';
            dom.inputs.sort.value = 'newest';
            document.getElementById('priceAll').checked = true;
            document.getElementById('collectionTitle').textContent = 'All Collections';

            render();
        });

        // Sidebar Toggles
        const toggleSection = (trigger, target, arrow) => {
            trigger.addEventListener('click', () => {
                const isHidden = target.classList.contains('d-none');
                if (isHidden) {
                    target.classList.remove('d-none');
                    target.style.opacity = 0;
                    setTimeout(() => target.style.opacity = 1, 10); // Fade in
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    target.classList.add('d-none');
                    arrow.style.transform = 'rotate(0deg)';
                }
            });
        };
        
        toggleSection(dom.toggles.cat, dom.toggles.catList, dom.toggles.catArrow);
        toggleSection(dom.toggles.price, dom.toggles.priceList, dom.toggles.priceArrow);
    };

    // INIT
    return {
        init: () => {
            initEvents();
            render();
        }
    };
})();

// Start Application
document.addEventListener('DOMContentLoaded', ProductManager.init);