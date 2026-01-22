/**
 * js/cart.js
 */
document.addEventListener('DOMContentLoaded', () => {
    fetchCartData();
});

function fetchCartData() {
    fetch('ajax/get_cart.php')
        .then(response => response.json())
        .then(data => {
            // Note: Data is now { items: [...], is_logged_in: true/false }
            if (data.error) { console.error(data.error); return; }
            renderCartPage(data.items || [], data.is_logged_in);
        })
        .catch(err => console.error("Error loading cart:", err));
}

function renderCartPage(cart, isLoggedIn) {
    const container = document.getElementById('cartItemsContainer');
    const emptyMsg = document.getElementById('emptyCart');
    const subtotalEl = document.getElementById('summarySubtotal');
    const totalEl = document.getElementById('summaryTotal');
    const countEl = document.getElementById('cartCount');
    const checkoutBtn = document.querySelector('.btn-checkout'); // Get Checkout Button

    // 1. Handle Empty State
    if (!cart || cart.length === 0) {
        if(container) container.innerHTML = '';
        if(emptyMsg) emptyMsg.classList.remove('d-none');
        if(subtotalEl) subtotalEl.innerText = '₱0.00';
        if(totalEl) totalEl.innerText = '₱0.00';
        if(countEl) countEl.innerText = '0';
        
        // Hide/Disable Checkout on empty
        if(checkoutBtn) checkoutBtn.disabled = true;
        return;
    }

    // 2. Render Items
    if(emptyMsg) emptyMsg.classList.add('d-none');
    if(countEl) countEl.innerText = cart.length;

    if(container) {
        container.innerHTML = cart.map(item => {
            const totalItemPrice = item.price * item.qty;
            return `
            <div class="cart-item bg-white p-3 mb-3 shadow-sm rounded fade-in-up">
                <div class="row align-items-center g-3">
                    <div class="col-3 col-md-2">
                        <div class="ratio ratio-1x1 rounded overflow-hidden">
                            <img src="${item.image}" class="img-fluid object-fit-cover">
                        </div>
                    </div>
                    <div class="col-9 col-md-5">
                        <h6 class="brand-font mb-1">${item.name}</h6>
                        <p class="small text-muted mb-2">${item.category}</p>
                        <span class="text-gold fw-bold">₱${totalItemPrice.toLocaleString()}</span>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="quantity-control d-flex align-items-center justify-content-center border rounded-pill">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.product_id}, -1)"><i class="fas fa-minus small"></i></button>
                            <input type="text" class="form-control border-0 text-center p-0 shadow-none" value="${item.qty}" readonly style="font-weight:600;">
                            <button class="btn btn-sm" onclick="App.updateQty(${item.product_id}, 1)"><i class="fas fa-plus small"></i></button>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 text-end">
                        <button class="btn btn-link text-muted p-0 hover-danger" onclick="App.removeFromCart(${item.product_id})">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    // 3. Update Totals
    const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
    const formatted = '₱' + total.toLocaleString(undefined, {minimumFractionDigits: 2});
    if(subtotalEl) subtotalEl.innerText = formatted;
    if(totalEl) totalEl.innerText = formatted;

    // 4. CHECKOUT RESTRICTION LOGIC
    if (checkoutBtn) {
        // Clone button to remove old listeners
        const newBtn = checkoutBtn.cloneNode(true);
        checkoutBtn.parentNode.replaceChild(newBtn, checkoutBtn);

        if (!isLoggedIn) {
            // GUEST: Change text and block action
            newBtn.innerHTML = '<span class="fw-bold text-uppercase ls-2">Login to Checkout</span>';
            newBtn.classList.add('btn-secondary'); // Grey it out slightly
            newBtn.classList.remove('btn-gold');   // Remove gold style if exists
            
            newBtn.addEventListener('click', (e) => {
                e.preventDefault();
                alert("Please log in to proceed with your payment.");
                window.location.href = 'login.php'; // Optional redirect
            });
        } else {
            // LOGGED IN: Normal Function
            newBtn.innerHTML = '<span class="fw-bold text-uppercase ls-2">Proceed to Checkout</span>';
            newBtn.disabled = false;
            newBtn.addEventListener('click', () => {
                window.location.href = 'checkout.php';
            });
        }
    }
}