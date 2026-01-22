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
     * Called by home.php and products.php
     */
    addToCart: function(product) {
        // Send request to the PHP backend
        $.ajax({
            url: 'ajax/add_to_cart.php', 
            method: 'POST',
            data: { product_id: product.id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Success: Update badge and show toast
                    // This now works for BOTH Logged In users AND Guests
                    $('.badge-cart').text(response.cart_count);
                    showToast('Item added to cart!', 'success');
                } else {
                    // Generic Error
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
     * Initialize App
     */
    init: function() {
        console.log("CASA VÉRA App Initialized");
    }
};

// Initialize on Document Ready
document.addEventListener('DOMContentLoaded', App.init);