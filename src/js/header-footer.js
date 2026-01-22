/**
 * header.js
 * Handles the "Scroll Condition" for the luxury glass header.
 */
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.querySelector('.navbar');
    
    // Config: How far down (in px) before the header changes?
    const scrollThreshold = 50;

    function handleScroll() {
        if (window.scrollY > scrollThreshold) {
            // Condition Met: User has scrolled down.
            // Result: Make header solid/darker for readability.
            navbar.classList.add('scrolled');
        } else {
            // Condition Reset: User is at the top.
            // Result: Make header transparent to show the page background.
            navbar.classList.remove('scrolled');
        }
    }

    // Attach listener with passive option for performance
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Run once on load in case user refreshes mid-page
    handleScroll();
});

/**
 * footer.js
 * Handles dynamic footer elements
 */
document.addEventListener('DOMContentLoaded', () => {
    // Ensure Copyright Year is always current
    const yearSpan = document.getElementById('current-year');
    if (yearSpan) {
        yearSpan.textContent = new Date().getFullYear();
    }
});