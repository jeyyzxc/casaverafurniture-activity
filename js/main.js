/**
 * Main Application Logic
 * Handles global UI (Toasts) and Cart API interactions (AJAX).
 */

// 1. Toast Notification Function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = 1080;
    toast.innerHTML = `
      <div class="toast align-items-center text-bg-${type} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>`;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// 2. Global App Object (The Bridge to PHP)
const App = {
    /**
     * Add Item to Cart
     * @param {Object} product - {id: 1, ...}
     * @param {Function} onSuccess - Optional callback (for Buy Now redirect)
     */
    addToCart: function(product, onSuccess) {
        $.ajax({
            url: 'ajax/add_to_cart.php', 
            method: 'POST',
            data: { product_id: product.id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count);
                    
                    // If "Buy Now" (redirect), run callback
                    if (onSuccess && typeof onSuccess === 'function') {
                        onSuccess();
                    } else {
                        // If "Add to Cart", show toast
                        showToast('Item added to cart!', 'success');
                    }
                } else {
                    showToast('Error: ' + response.message, 'danger');
                }
            },
            error: function(xhr, status, error) {
                console.error("Cart Error:", error);
                showToast('Something went wrong. Please try again.', 'danger');
            }
        });
    },

    /**
     * Update Quantity (+ or -)
     */
    updateQty: function(productId, change) {
        $.ajax({
            url: 'ajax/update_cart_qty.php',
            method: 'POST',
            data: { product_id: productId, change: change },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count); // Update Header Badge
                    
                    // If we are on the Cart Page, reload the list
                    if (typeof fetchCartData === 'function') {
                        fetchCartData(); 
                    }
                }
            }
        });
    },

    /**
     * Remove Item
     */
    removeFromCart: function(productId) {
        if(!confirm("Are you sure you want to remove this item?")) return;

        $.ajax({
            url: 'ajax/remove_from_cart.php',
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text(response.cart_count);
                    showToast('Item removed', 'info');
                    
                    // Reload Cart Page List
                    if (typeof fetchCartData === 'function') {
                        fetchCartData();
                    }
                }
            }
        });
    },

    /**
     * Clear Entire Cart
     */
    clearCart: function() {
        if(!confirm("Are you sure you want to clear your entire cart?")) return;
        
        $.ajax({
            url: 'ajax/clear_cart.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.badge-cart').text('0');
                    showToast('Cart cleared', 'info');
                    
                    // Reload Cart Page List
                    if (typeof fetchCartData === 'function') {
                        fetchCartData();
                    }
                }
            }
        });
    },

    /**
     * Initialize App
     */
    init: function() {
        console.log("CASA VÉRA App Initialized");
    }
};

// Initialize on Document Ready
document.addEventListener('DOMContentLoaded', App.init);