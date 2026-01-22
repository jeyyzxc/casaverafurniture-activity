/**
 * cart-page.js
 * Handles rendering logic for the main Cart Page.
 * Relies on global 'App' object for data.
 */

document.addEventListener('DOMContentLoaded', () => {
    renderCartPage();
    
    // Listen for updates from anywhere in the app (e.g. header removal)
    document.addEventListener('cartUpdated', renderCartPage);
});

function renderCartPage() {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCart');
    const summaryContainer = document.querySelector('.luxury-summary');
    
    // Elements to update
    const subtotalEl = document.getElementById('summarySubtotal');
    const totalEl = document.getElementById('summaryTotal');
    const countEl = document.getElementById('cartCount');
    const clearBtn = document.getElementById('clearCartBtn');

    // 1. Get Data safely
    const cart = (typeof App !== 'undefined' && App.getCart) ? App.getCart() : [];

    // 2. Handle Empty State
    if (!cart || cart.length === 0) {
        if(container) container.innerHTML = '';
        if(emptyMsg) emptyMsg.classList.remove('d-none');
        if(clearBtn) clearBtn.classList.add('d-none');
        
        // Zero out summary
        if(subtotalEl) subtotalEl.innerText = '₱0.00';
        if(totalEl) totalEl.innerText = '₱0.00';
        if(countEl) countEl.innerText = '0';
        return;
    }

    // 3. Render Items
    if(emptyMsg) emptyMsg.classList.add('d-none');
    if(clearBtn) clearBtn.classList.remove('d-none');
    if(countEl) countEl.innerText = cart.length;

    if(container) {
        container.innerHTML = cart.map((item, index) => {
            const delayClass = index < 5 ? `delay-${index * 100}` : '';
            return `
            <div class="cart-item bg-white p-3 mb-3 shadow-sm rounded fade-in-up ${delayClass}">
                <div class="row align-items-center g-3">
                    
                    <div class="col-3 col-md-2">
                        <div class="ratio ratio-1x1 rounded overflow-hidden">
                            <img src="${item.image || 'src/images/placeholder.jpg'}" 
                                 class="img-fluid object-fit-cover" 
                                 alt="${item.name}">
                        </div>
                    </div>

                    <div class="col-9 col-md-5">
                        <h6 class="brand-font mb-1">
                            <a href="#" class="text-dark text-decoration-none">${item.name}</a>
                        </h6>
                        <p class="small text-muted mb-2">
                            ${item.category ? `Category: ${item.category}` : 'Premium Collection'}
                        </p>
                        <span class="text-gold fw-bold">₱${(item.price * item.qty).toLocaleString()}</span>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="quantity-control d-flex align-items-center justify-content-center border rounded-pill">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.id}, -1)">
                                <i class="fas fa-minus small"></i>
                            </button>
                            <input type="text" class="form-control border-0 text-center p-0 shadow-none" 
                                   value="${item.qty}" readonly style="font-weight:600;">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.id}, 1)">
                                <i class="fas fa-plus small"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-6 col-md-2 text-end">
                        <button class="btn btn-link text-muted p-0 hover-danger" 
                                onclick="App.removeFromCart(${item.id})" title="Remove Item">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>

                </div>
            </div>
            `;
        }).join('');
    }

    // 4. Update Totals
    const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const formatted = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
    
    if(subtotalEl) subtotalEl.innerText = formatted;
    if(totalEl) totalEl.innerText = formatted;
}