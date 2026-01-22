/**
 * profile.js
 * Handles interactions on the user profile page
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // 1. Avatar Upload Preview
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');
    const avatarForm = document.getElementById('avatarForm');

    if (avatarInput && avatarForm) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file.');
                    return;
                }

                // Preview logic could go here, but we will auto-submit
                avatarForm.submit();
            }
        });
    }

    // 2. Smooth Tab Transition Fix
    const triggerTabList = [].slice.call(document.querySelectorAll('#v-pills-tab button'));
    triggerTabList.forEach(function(triggerEl) {
        triggerEl.addEventListener('shown.bs.tab', function(event) {
            // Optional: Scroll to top of content on mobile
            if (window.innerWidth < 992) {
                document.querySelector('.tab-content').scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});

/**
 * Trigger file input click
 */
function triggerAvatarUpload() {
    document.getElementById('avatarInput').click();
}