/**
 * src/js/cart.js
 * Handles cart page specific logic
 */

document.addEventListener('DOMContentLoaded', () => {
    fetchCartData();
    setupCheckout();
});

/**
 * Fetch and render cart items
 */
function fetchCartData() {
    fetch('ajax/get_cart.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }
            renderCartItems(data.items);
            updateCartSummary(data.items);
            
            // Update global badge
            if (window.App) {
                $('.badge-cart').text(data.cart_count);
            }
        })
        .catch(err => console.error('Error fetching cart:', err));
}

/**
 * Render HTML for cart items
 */
function renderCartItems(items) {
    const container = document.getElementById('cartItemsContainer');
    const emptyState = document.getElementById('emptyCart');
    const countEl = document.getElementById('cartCount');
    const clearBtn = document.getElementById('clearCartBtn');

    if (!container) return;

    if (items.length === 0) {
        container.innerHTML = '';
        if (emptyState) emptyState.classList.remove('d-none');
        if (clearBtn) clearBtn.classList.add('d-none');
        if (countEl) countEl.innerText = '0';
        // Disable checkout if empty
        const btnCheckout = document.getElementById('btnCheckout');
        if(btnCheckout) btnCheckout.disabled = true;
        return;
    }

    if (emptyState) emptyState.classList.add('d-none');
    if (clearBtn) clearBtn.classList.remove('d-none');
    if (countEl) countEl.innerText = items.length;
    
    const btnCheckout = document.getElementById('btnCheckout');
    if(btnCheckout) btnCheckout.disabled = false;

    container.innerHTML = items.map(item => {
        const price = parseFloat(item.price);
        const total = price * item.qty;

        return `
        <div class="card border-0 shadow-sm mb-3 position-relative overflow-hidden">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" alt="${item.name}" 
                         class="rounded me-3 object-fit-cover" 
                         style="width: 80px; height: 80px;">
                    
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-1">
                            <h6 class="mb-0 brand-font text-truncate" style="max-width: 200px;">${item.name}</h6>
                            <button class="btn btn-link text-danger p-0 border-0" 
                                    onclick="App.removeFromCart(${item.product_id})"
                                    title="Remove Item">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <p class="small text-muted mb-2">${item.category || 'Furniture'}</p>
                        
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="quantity-control d-flex align-items-center border rounded-pill px-2 py-1">
                                <button class="btn btn-sm p-0 text-muted" onclick="App.updateQty(${item.product_id}, -1)">
                                    <i class="fas fa-minus" style="font-size: 0.7rem;"></i>
                                </button>
                                <span class="mx-2 small fw-bold" style="min-width: 20px; text-align: center;">${item.qty}</span>
                                <button class="btn btn-sm p-0 text-muted" onclick="App.updateQty(${item.product_id}, 1)">
                                    <i class="fas fa-plus" style="font-size: 0.7rem;"></i>
                                </button>
                            </div>
                            <span class="fw-bold text-dark">₱${total.toLocaleString('en-PH', {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }).join('');
}

/**
 * Update Summary Totals
 */
function updateCartSummary(items) {
    let subtotal = 0;
    items.forEach(item => {
        subtotal += parseFloat(item.price) * parseInt(item.qty);
    });

    document.getElementById('summarySubtotal').innerText = '₱' + subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2});
    document.getElementById('summaryTotal').innerText = '₱' + subtotal.toLocaleString('en-PH', {minimumFractionDigits: 2});
}

/**
 * Handle Proceed to Checkout Logic
 */
function setupCheckout() {
    const btn = document.getElementById('btnCheckout');
    const paymentModalEl = document.getElementById('paymentModal');
    
    if (!btn || !paymentModalEl) return;

    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap JS is not loaded');
        return;
    }

    const paymentModal = new bootstrap.Modal(paymentModalEl);

    // 1. Open Mock Payment Modal instead of direct AJAX
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        paymentModal.show();
    });

    // 2. Handle Payment Method Selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            processMockPayment(this.dataset.method, paymentModal);
        });
    });
}

function processMockPayment(method, modalInstance) {
    const processingEl = document.getElementById('paymentProcessing');
    const errorEl = document.getElementById('paymentError');
    const options = document.querySelectorAll('.payment-option');

    // UI: Show Processing State
    processingEl.classList.remove('d-none');
    errorEl.classList.add('d-none');
    options.forEach(btn => btn.classList.add('disabled'));

    // Simulate Network Delay (2 seconds)
    setTimeout(() => {
        // Logic: Check if transaction is successful (80% success rate)
        const isSuccess = Math.random() > 0.2;

        if (isSuccess) {
            // Transaction Successful: Clear Cart & Show Success
            $.ajax({
                url: 'ajax/clear_cart.php',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        modalInstance.hide();
                        
                        // Reset Modal UI for next use
                        processingEl.classList.add('d-none');
                        options.forEach(btn => btn.classList.remove('disabled'));

                        // Populate Success Details
                        const orderId = 'CV-' + Math.floor(100000 + Math.random() * 900000);
                        const date = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
                        const methodText = method === 'paypal' ? 'PayPal' : 'Credit/Debit Card';

                        const orderIdEl = document.getElementById('successOrderId');
                        if(orderIdEl) orderIdEl.innerText = orderId;
                        
                        const dateEl = document.getElementById('successDate');
                        if(dateEl) dateEl.innerText = date;

                        const methodEl = document.getElementById('successPaymentMethod');
                        if(methodEl) methodEl.innerText = methodText;

                        // Directed back to cart page view with success message
                        document.getElementById('cartMainContent').classList.add('d-none');
                        document.getElementById('orderSuccess').classList.remove('d-none');
                        
                        $('.badge-cart').text('0');
                        window.scrollTo({ top: 0, behavior: 'smooth' });

                        // Show Success Toast
                        if (typeof showToast === 'function') {
                            showToast('Transaction Successful! Order placed.', 'success');
                        }
                    }
                }
            });
        } else {
            // Transaction Failed
            processingEl.classList.add('d-none');
            errorEl.classList.remove('d-none');
            options.forEach(btn => btn.classList.remove('disabled'));

            // Show Error Toast
            if (typeof showToast === 'function') {
                showToast('Transaction Failed. Please try again.', 'danger');
            }
        }
    }, 2000);
}