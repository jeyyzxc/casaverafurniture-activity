/**
 * Profile Page Functionality
 */

document.addEventListener('DOMContentLoaded', () => {
    initAvatarUpload();
    initAddressManagement();
});

function initAvatarUpload() {
    const uploadBtn = document.getElementById('btnAvatarUpload');
    const fileInput = document.getElementById('avatarInput');
    const form = document.getElementById('avatarForm');

    if (uploadBtn && fileInput && form) {
        // Trigger file input when camera button is clicked
        uploadBtn.addEventListener('click', (e) => {
            e.preventDefault();
            fileInput.click();
        });

        // Auto-submit form when file is selected
        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files[0]) {
                // Optional: Show loading state
                const icon = uploadBtn.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-spinner fa-spin';
                }
                form.submit();
            }
        });
    }
}

function initAddressManagement() {
    const deleteBtns = document.querySelectorAll('.btn-delete-address');
    
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm('Are you sure you want to remove this address?')) {
                // In a real app, you would send an AJAX request here.
                // For now, we'll just remove the element from the DOM.
                const cardCol = btn.closest('.col-md-6');
                if (cardCol) {
                    cardCol.remove();
                }
            }
        });
    });
}