/**
 * cart.js
 * Handles rendering logic for the main Cart Page via Database.
 */

document.addEventListener('DOMContentLoaded', () => {
    fetchCartData();
});

// Exposed function to reload data (called after updates)
function fetchCartData() {
    fetch('ajax/get_cart.php')
        .then(response => response.json())
        .then(data => {
            renderCartPage(data);
        })
        .catch(err => console.error("Error loading cart:", err));
}

function renderCartPage(cart) {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCart');
    
    // Summary Elements
    const subtotalEl = document.getElementById('summarySubtotal');
    const totalEl = document.getElementById('summaryTotal');
    const countEl = document.getElementById('cartCount');
    const clearBtn = document.getElementById('clearCartBtn');

    // 1. Handle Empty State
    if (!cart || cart.length === 0) {
        if(container) container.innerHTML = '';
        if(emptyMsg) emptyMsg.classList.remove('d-none');
        if(clearBtn) clearBtn.classList.add('d-none');
        if(subtotalEl) subtotalEl.innerText = '₱0.00';
        if(totalEl) totalEl.innerText = '₱0.00';
        if(countEl) countEl.innerText = '0';
        return;
    }

    // 2. Render Items
    if(emptyMsg) emptyMsg.classList.add('d-none');
    if(clearBtn) clearBtn.classList.remove('d-none');
    if(countEl) countEl.innerText = cart.length;

    if(container) {
        container.innerHTML = cart.map((item, index) => {
            const delayClass = index < 5 ? `delay-${index * 100}` : '';
            const totalItemPrice = item.price * item.qty;
            
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
                        <span class="text-gold fw-bold">₱${totalItemPrice.toLocaleString()}</span>
                    </div>

                    <div class="col-6 col-md-3">
                        <div class="quantity-control d-flex align-items-center justify-content-center border rounded-pill">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.product_id}, -1)">
                                <i class="fas fa-minus small"></i>
                            </button>
                            <input type="text" class="form-control border-0 text-center p-0 shadow-none" 
                                   value="${item.qty}" readonly style="font-weight:600;">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.product_id}, 1)">
                                <i class="fas fa-plus small"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-6 col-md-2 text-end">
                        <button class="btn btn-link text-muted p-0 hover-danger" 
                                onclick="App.removeFromCart(${item.product_id})" title="Remove Item">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>

                </div>
            </div>
            `;
        }).join('');
    }

    // 3. Update Totals
    const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const formatted = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
    
    if(subtotalEl) subtotalEl.innerText = formatted;
    if(totalEl) totalEl.innerText = formatted;
}