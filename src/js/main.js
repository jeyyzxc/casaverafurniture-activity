/**
 * js/main.js
 * Global cart management bridge between UI and backend
 */

const App = {
    /**
     * Add item to cart
     * @param {Object} product - Product object with id
     * @param {String} action - 'add' (add to cart) or 'buy' (buy now)
     * @param {Function} onSuccess - Optional callback
     */
    addToCart: function(product, action = 'add', onSuccess) {
        if (!product || !product.id) {
            console.error('Invalid product data');
            return;
        }

        $.ajax({
            url: 'ajax/add_to_cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                product_id: product.id,
                quantity: product.quantity || 1,
                action: action
            }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Update cart badge
                    $('.badge-cart').text(response.cartCount);

                    // ═══════════════════════════════════════════════
                    // HANDLE "BUY NOW" ACTION
                    // ═══════════════════════════════════════════════
                    if (action === 'buy') {
                        if (response.is_logged_in) {
                            // Logged-in user: Go directly to checkout
                            window.location.href = 'checkout.php';
                        } else {
                            // Guest user: Redirect to login
                            App.redirectToLogin('Please login to complete your purchase');
                        }
                        return; // Stop execution
                    }

                    // ═══════════════════════════════════════════════
                    // HANDLE "ADD TO CART" ACTION
                    // ═══════════════════════════════════════════════
                    if (typeof onSuccess === 'function') {
                        onSuccess(response);
                    } else {
                        showToast('✓ Item added to cart!', 'success');
                    }

                } else {
                    showToast(response.message || 'Failed to add item', 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error('Add to cart error:', error);
                showToast('Connection failed. Please try again.', 'danger');
            }
        });
    },

    /**
     * Update cart quantity
     * @param {Number} productId
     * @param {Number} change - Positive or negative number
     */
    updateQty: function(productId, change) {
        $.ajax({
            url: 'ajax/update_cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                product_id: productId,
                action: 'update',
                quantity: null, // Will be calculated in backend
                change: change
            }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cartCount);
                    
                    // Refresh cart display if on cart page
                    if (typeof fetchCartData === 'function') {
                        fetchCartData();
                    }
                } else {
                    showToast(response.message || 'Update failed', 'danger');
                }
            },
            error: function() {
                showToast('Failed to update quantity', 'danger');
            }
        });
    },

    /**
     * Remove item from cart
     * @param {Number} productId
     */
    removeFromCart: function(productId) {
        if (!confirm('Remove this item from your cart?')) return;

        $.ajax({
            url: 'ajax/update_cart.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                product_id: productId,
                action: 'remove'
            }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cartCount);
                    showToast('Item removed', 'info');
                    
                    if (typeof fetchCartData === 'function') {
                        fetchCartData();
                    }
                }
            }
        });
    },

    /**
     * Clear entire cart
     */
    clearCart: function() {
        if (!confirm('Clear your entire cart?')) return;

        $.ajax({
            url: 'ajax/clear_cart.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text('0');
                    showToast('Cart cleared', 'info');
                    
                    if (typeof fetchCartData === 'function') {
                        fetchCartData();
                    }
                }
            }
        });
    },

    /**
     * Redirect to login with message
     * @param {String} message - Optional message to display
     */
    redirectToLogin: function(message) {
        if (message) {
            sessionStorage.setItem('login_message', message);
        }

        // Try to open login modal if function exists
        if (typeof openLoginModal === 'function') {
            openLoginModal();
        } else {
            // Fallback: redirect to login page
            window.location.href = 'login.php';
        }
    },

    /**
     * Initialize app
     */
    init: function() {
        console.log('🛒 Cart system initialized');
        
        // Display login message if exists
        const loginMsg = sessionStorage.getItem('login_message');
        if (loginMsg) {
            showToast(loginMsg, 'warning');
            sessionStorage.removeItem('login_message');
        }
    }
};

/**
 * Show toast notification
 * @param {String} message
 * @param {String} type - 'success', 'danger', 'warning', 'info'
 */
function showToast(message, type = 'info') {
    let container = document.getElementById('toast-container');
    
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = 1090;
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;

    container.appendChild(toast);

    // Auto-remove after 3 seconds
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => App.init());