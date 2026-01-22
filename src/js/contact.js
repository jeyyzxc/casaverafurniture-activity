/**
 * contact.js
 * Handles Contact Page specific interactions
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        const contactForm = document.getElementById('contactForm');

        // Dynamic Validation Logic for all fields
        ['name', 'email', 'message'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                const feedback = input.parentElement.querySelector('.invalid-feedback');
                if (!feedback) return;
                
                const updateFeedback = () => {
                    if (input.validity.valueMissing) {
                        feedback.textContent = 'This field is required.';
                    } else if (id === 'email' && (input.validity.typeMismatch || input.validity.patternMismatch)) {
                        feedback.textContent = 'Please enter a valid email (@gmail.com).';
                    } else if (id === 'message' && input.validity.tooShort) {
                        feedback.textContent = 'Message must be at least 10 characters long.';
                    } else {
                        feedback.textContent = '';
                    }
                };

                input.addEventListener('input', updateFeedback);
                input.addEventListener('invalid', updateFeedback);

                // Input Restrictions: Block leading space & multiple spaces
                input.addEventListener('keydown', function(e) {
                    if (e.key === ' ') {
                        // 1. Email: Block ALL spaces
                        if (id === 'email') {
                            e.preventDefault();
                            return;
                        }

                        // 2. Block leading space (Name & Message)
                        if (input.value.length === 0) {
                            e.preventDefault();
                            return;
                        }
                        try {
                            if (input.selectionStart === 0) {
                                e.preventDefault();
                                return;
                            }
                        } catch (err) { /* Ignore for types that don't support selection */ }
                        
                        // 3. Block multiple spaces (Name only)
                        if (id === 'name') {
                            try {
                                const cursorPosition = input.selectionStart;
                                if (cursorPosition && cursorPosition > 0 && input.value[cursorPosition - 1] === ' ') {
                                    e.preventDefault();
                                }
                            } catch (err) { /* Ignore */ }
                        }
                    }
                });

                // Sanitize on input (handle paste/cleanup)
                input.addEventListener('input', function() {
                    let valueChanged = false;
                    
                    if (id === 'email') {
                        // Email: Remove ALL spaces
                        if (/\s/.test(input.value)) {
                            input.value = input.value.replace(/\s/g, '');
                            valueChanged = true;
                        }
                    } else {
                        if (input.value.startsWith(' ')) {
                            input.value = input.value.trimStart();
                            valueChanged = true;
                        }
                        if (id === 'name' && /\s\s+/.test(input.value)) {
                            input.value = input.value.replace(/\s\s+/g, ' ');
                            valueChanged = true;
                        }
                    }
                    if (valueChanged) updateFeedback();
                });
            }
        });

        if (contactForm) {
            contactForm.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();

                // 1. Check Validity
                if (!contactForm.checkValidity()) {
                    contactForm.classList.add('was-validated');
                    return;
                }

                // 2. Simulate Loading State
                const btn = contactForm.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sending...';

                // 3. Simulate API Call (Replace with actual AJAX later)
                setTimeout(() => {
                    // Success State
                    btn.innerHTML = '<i class="fas fa-check me-2"></i> Message Sent!';
                    btn.classList.remove('btn-gold');
                    btn.classList.add('btn-success');
                    
                    // Show Global Toast (Using existing App.js)
                    if (window.App && typeof App.showToast === 'function') {
                        App.showToast('We received your message. Thank you!');
                    }

                    // Reset Form
                    setTimeout(() => {
                        contactForm.reset();
                        contactForm.classList.remove('was-validated');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        btn.classList.add('btn-gold');
                        btn.classList.remove('btn-success');
                    }, 3000);

                }, 1500);
            });
        }

    });

})();