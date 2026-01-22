/**
 * login-signupModal.js
 * Handles Modal, Password Peek, Input Sanitization & REAL-TIME VALIDATION.
 */

/* --- (Keep Modal Open/Close & Password Peek Logic Same as Before) --- */

/* =========================================
   1. MODAL OPEN/CLOSE LOGIC (Unchanged)
   ========================================= */
function openLoginModal(e) {
    if(e) e.preventDefault(); 
    const modal = document.getElementById('loginModal');
    if(modal) {
        modal.classList.add('active');
        document.body.classList.add('modal-open');
    }
}

function resetModalForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        form.classList.remove('was-validated');
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
            input.setCustomValidity('');
            const feedback = input.parentElement.querySelector('.invalid-feedback');
            if (feedback) feedback.textContent = '';
        });
    }
}

function closeLoginModal() {
    const modal = document.getElementById('loginModal');
    if(modal) {
        modal.classList.remove('active');
        resetModalForm('loginForm');
        if (!document.getElementById('signupModal') || !document.getElementById('signupModal').classList.contains('active')) {
            document.body.classList.remove('modal-open'); 
        }
    }
}

function openSignupModal(e) {
    if(e) e.preventDefault();
    closeLoginModal(); 
    const modal = document.getElementById('signupModal');
    if(modal) {
        modal.classList.add('active');
        document.body.classList.add('modal-open');
    }
}

function closeSignupModal() {
    const modal = document.getElementById('signupModal');
    if(modal) {
        modal.classList.remove('active');
        resetModalForm('signupForm');
        if (!document.getElementById('loginModal') || !document.getElementById('loginModal').classList.contains('active')) {
            document.body.classList.remove('modal-open'); 
        }
    }
}

function switchToLogin(e) {
    if(e) e.preventDefault();
    closeSignupModal();
    setTimeout(() => openLoginModal(), 200); 
}

/* =========================================
   2. PASSWORD PEEK FEATURE (Unchanged)
   ========================================= */
function peekPassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    const icon = iconElement.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

        setTimeout(() => {
            if (input.type === "text") {
                input.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }, 1000); 
    } else {
        input.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

/* =========================================
   3. INPUT RESTRICTIONS (No Spaces Logic)
   ========================================= */
document.addEventListener('DOMContentLoaded', () => {
    
    // Close Modals on Outside Click
    ['loginModal', 'signupModal'].forEach(id => {
        const modal = document.getElementById(id);
        if(modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    id === 'loginModal' ? closeLoginModal() : closeSignupModal();
                }
            });
        }
    });

    // UPDATE: Input Sanitization List
    const fieldsToValidate = [
        { id: 'modalEmail', type: 'email' },
        { id: 'signupEmail', type: 'email' },
        { id: 'signupFirstName', type: 'text' }, // Updated
        { id: 'signupLastName',  type: 'text' }  // Updated
    ];

    fieldsToValidate.forEach(field => {
        const input = document.getElementById(field.id);
        if (input) {
            input.addEventListener('keydown', function(e) {
                if (e.key === ' ') {
                    if (field.type === 'email') { e.preventDefault(); return; }
                    if (input.value.length === 0) { e.preventDefault(); return; }
                    if (input.selectionStart === 0) { e.preventDefault(); return; }
                    if (field.type === 'text') {
                        const cursorPosition = input.selectionStart;
                        if (cursorPosition > 0 && input.value[cursorPosition - 1] === ' ') {
                            e.preventDefault();
                        }
                    }
                }
            });

            input.addEventListener('input', function() {
                if (field.type === 'email') {
                    if (/\s/.test(input.value)) input.value = input.value.replace(/\s/g, '');
                } else if (field.type === 'text') {
                    let newValue = input.value;
                    if (newValue.startsWith(' ')) newValue = newValue.trimStart();
                    if (/\s\s+/.test(newValue)) newValue = newValue.replace(/\s\s+/g, ' ');
                    if (input.value !== newValue) input.value = newValue;
                }
            });
        }
    });

    /* =========================================
       4. TERMS CHECKBOX LOGIC (Disable Button)
       ========================================= */
    const termsCheck = document.getElementById('termsCheck');
    const signupForm = document.getElementById('signupForm');
    
    if (termsCheck && signupForm) {
        const signupBtn = signupForm.querySelector('button[type="submit"]');
        signupBtn.disabled = !termsCheck.checked;
        termsCheck.addEventListener('change', function() {
            signupBtn.disabled = !this.checked;
        });
    }

    /* =========================================
       5. REAL-TIME FORM VALIDATION
       ========================================= */
    const forms = ['loginForm', 'signupForm'];

    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (!form) return;

        // Validation Function
        const validateInput = (input) => {
            const feedback = input.parentElement.querySelector('.invalid-feedback');
            if (!feedback) return true; 

            input.setCustomValidity('');
            let isValid = true;
            let message = '';
            
            // A. Check Empty
            if (input.value.trim() === '') {
                isValid = false;
                message = 'This field is required.';
            } 
            
            // B. Check Email (STRICT @GMAIL.COM)
            else if (input.type === 'email') {
                const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
                if (!gmailRegex.test(input.value)) {
                    isValid = false;
                    message = 'Please use a valid @gmail.com address.';
                }
            }
            
            // C. Check Password Length (SIGNUP ONLY)
            else if (input.type === 'password' && formId === 'signupForm' && input.value.length < 8) {
                isValid = false;
                message = 'Password must be at least 8 characters.';
            }
            
            // D. Check Password Match (SIGNUP ONLY)
            else if (input.id === 'signupConfirmPassword') {
                const mainPass = document.getElementById('signupPassword');
                if (mainPass && input.value !== mainPass.value) {
                    isValid = false;
                    message = 'Passwords do not match.';
                }
            }

            // Apply Visuals
            if (!isValid) {
                input.setCustomValidity(message); 
                feedback.textContent = message;
                input.classList.remove('is-valid'); // Remove Green
                input.classList.add('is-invalid');  // Add Red
            } else {
                input.classList.remove('is-invalid'); // Remove Red
                input.classList.add('is-valid');      // Add Green
                feedback.textContent = ''; 
            }
            return isValid;
        };

        const inputs = form.querySelectorAll('input');
        
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                validateInput(input);
            });
            input.addEventListener('blur', () => {
                 validateInput(input);
            });
        });

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();

            let isFormValid = true;
            inputs.forEach(input => {
                if (!validateInput(input)) {
                    isFormValid = false;
                }
            });

            form.classList.add('was-validated');

            if (!isFormValid || !form.checkValidity()) {
                return;
            }

            // Standard submission to ensure page reload/redirect
            form.submit();
        });
    });
});