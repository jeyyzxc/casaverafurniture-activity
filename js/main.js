/**
 * js/main.js
 * The Bridge: Connects Buttons -> Database -> Cart Page
 */
const App = {
    // 1. ADD TO CART LOGIC
    // Handles both "Add to Cart" (Stay) and "Buy Now" (Redirect)
    addToCart: function(product, action, onSuccess) {
        if (!product || !product.id) return;
        
        // Default to 'add' if not specified
        const actionType = action || 'add';

        $.ajax({
            url: 'ajax/add_to_cart.php', 
            method: 'POST',
            // PASS ACTION TO BACKEND (Critical for Guest Logic)
            data: { 
                product_id: product.id, 
                action: actionType 
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count);
                    
                    if (typeof onSuccess === 'function') {
                        onSuccess(); 
                    } else {
                        showToast('Item added to cart!', 'success');
                    }
                } else {
                    showToast(response.message, 'danger');
                }
            },
            error: function() { showToast('Connection failed.', 'danger'); }
        });
    },

    // 2. UPDATE QUANTITY LOGIC
    updateQty: function(productId, change) {
        $.ajax({
            url: 'ajax/update_cart_qty.php',
            method: 'POST',
            data: { product_id: productId, change: change },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count);
                    // Refresh the cart list immediately if on cart page
                    if (typeof fetchCartData === 'function') fetchCartData(); 
                }
            }
        });
    },

    // 3. REMOVE ITEM LOGIC
    removeFromCart: function(productId) {
        if(!confirm("Remove this item?")) return;
        $.ajax({
            url: 'ajax/remove_cart.php', 
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count);
                    showToast('Item removed.', 'info');
                    if (typeof fetchCartData === 'function') fetchCartData();
                }
            }
        });
    },

    // 4. CLEAR CART LOGIC
    clearCart: function() {
        if(!confirm("Clear your entire cart?")) return;
        $.ajax({
            url: 'ajax/clear_cart.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text('0');
                    showToast('Cart cleared.', 'info');
                    if (typeof fetchCartData === 'function') fetchCartData();
                }
            }
        });
    },

    init: function() { console.log("Bridge Established."); }
};

// HELPER: Toast Notifications
function showToast(message, type = 'info') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        container.style.zIndex = 1090;
        document.body.appendChild(container);
    }
    const el = document.createElement('div');
    el.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
    el.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    container.appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', App.init);