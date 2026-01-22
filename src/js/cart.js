/**
 * js/cart.js
 * Cart page specific logic
 */

document.addEventListener('DOMContentLoaded', () => {
    fetchCartData();
});

/**
 * Fetch cart data from backend
 */
function fetchCartData() {
    fetch('ajax/get_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error('Backend Error:', data.error);
                showToast('Error: ' + data.error, 'danger'); // Visual feedback
                renderEmptyCart();
                return;
            }
            
            renderCartPage(data.items || [], data.is_logged_in);
        })
        .catch(err => {
            console.error('Error loading cart:', err);
            renderEmptyCart();
        });
}

/**
 * Render cart items and summary
 * @param {Array} cart - Cart items
 * @param {Boolean} isLoggedIn - User login status
 */
function renderCartPage(cart, isLoggedIn) {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCart');
    const subtotalEl = document.getElementById('summarySubtotal');
    const totalEl = document.getElementById('summaryTotal');
    const countEl = document.getElementById('cartCount');
    const checkoutBtn = document.querySelector('.btn-checkout');

    // ═══════════════════════════════════════════════════
    // HANDLE EMPTY CART
    // ═══════════════════════════════════════════════════
    if (!cart || cart.length === 0) {
        renderEmptyCart();
        return;
    }

    // ═══════════════════════════════════════════════════
    // RENDER CART ITEMS
    // ═══════════════════════════════════════════════════
    if (emptyMsg) emptyMsg.classList.add('d-none');
    
    const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
    if (countEl) countEl.innerText = totalQty;

    if (container) {
        container.innerHTML = cart.map(item => {
            const totalItemPrice = item.price * item.qty;
            return `
            <div class="cart-item bg-white p-3 mb-3 shadow-sm rounded fade-in-up">
                <div class="row align-items-center g-3">
                    <div class="col-3 col-md-2">
                        <div class="ratio ratio-1x1 rounded overflow-hidden">
                            <img src="${item.image}" 
                                 class="img-fluid object-fit-cover" 
                                 alt="${item.name}">
                        </div>
                    </div>
                    <div class="col-9 col-md-5">
                        <h6 class="brand-font mb-1">${item.name}</h6>
                        <p class="small text-muted mb-2">${item.category}</p>
                        <span class="text-gold fw-bold">₱${totalItemPrice.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quantity-control d-flex align-items-center justify-content-center border rounded-pill">
                            <button class="btn btn-sm" 
                                    onclick="App.updateQty(${item.product_id}, -1)"
                                    aria-label="Decrease quantity">
                                <i class="fas fa-minus small"></i>
                            </button>
                            <input type="text" 
                                   id="qty-${item.product_id}" 
                                   class="form-control border-0 text-center p-0 shadow-none" 
                                   value="${item.qty}" 
                                   readonly 
                                   style="font-weight:600; width: 50px;">
                            <button class="btn btn-sm" 
                                    onclick="App.updateQty(${item.product_id}, 1)"
                                    aria-label="Increase quantity">
                                <i class="fas fa-plus small"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 text-end">
                        <button class="btn btn-link text-muted p-0 hover-danger" 
                                onclick="App.removeFromCart(${item.product_id})"
                                aria-label="Remove item">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    // ═══════════════════════════════════════════════════
    // UPDATE TOTALS
    // ═══════════════════════════════════════════════════
    const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const formatted = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits: 2});
    
    if (subtotalEl) subtotalEl.innerText = formatted;
    if (totalEl) totalEl.innerText = formatted;

    // ═══════════════════════════════════════════════════
    // CHECKOUT BUTTON LOGIC (Critical)
    // ═══════════════════════════════════════════════════
    if (checkoutBtn) {
        // Remove existing event listeners by cloning
        const newBtn = checkoutBtn.cloneNode(true);
        checkoutBtn.parentNode.replaceChild(newBtn, checkoutBtn);

        if (!isLoggedIn) {
            // ┌─────────────────────────────────────────┐
            // │ GUEST USER: Block Checkout              │
            // └─────────────────────────────────────────┘
            newBtn.innerHTML = '<i class="fas fa-lock me-2"></i><span class="fw-bold text-uppercase ls-2">Login to Checkout</span>';
            newBtn.classList.remove('btn-gold');
            newBtn.classList.add('btn-secondary');
            
            newBtn.addEventListener('click', (e) => {
                e.preventDefault();
                App.redirectToLogin('Please login to proceed to checkout');
            });

        } else {
            // ┌─────────────────────────────────────────┐
            // │ LOGGED-IN USER: Allow Checkout          │
            // └─────────────────────────────────────────┘
            newBtn.innerHTML = '<span class="fw-bold text-uppercase ls-2">Proceed to Checkout</span>';
            newBtn.classList.remove('btn-secondary');
            newBtn.classList.add('btn-gold');
            newBtn.disabled = false;
            
            newBtn.addEventListener('click', () => {
                window.location.href = 'checkout.php';
            });
        }
    }
}

/**
 * Render empty cart state
 */
function renderEmptyCart() {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCart');
    const subtotalEl = document.getElementById('summarySubtotal');
    const totalEl = document.getElementById('summaryTotal');
    const countEl = document.getElementById('cartCount');
    const checkoutBtn = document.querySelector('.btn-checkout');

    if (container) container.innerHTML = '';
    if (emptyMsg) emptyMsg.classList.remove('d-none');
    if (subtotalEl) subtotalEl.innerText = '₱0.00';
    if (totalEl) totalEl.innerText = '₱0.00';
    if (countEl) countEl.innerText = '0';
    if (checkoutBtn) checkoutBtn.disabled = true;
}