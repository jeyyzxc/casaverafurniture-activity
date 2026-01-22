/**
 * slider.js
 * Handles the logic for the Reusable Hero Slider images.
 * Text effects are handled purely by CSS.
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        // Find all sliders on the page
        const sliders = document.querySelectorAll('.cv-hero__slider');

        sliders.forEach(slider => {
            const slides = slider.querySelectorAll('.cv-hero__slide');
            
            // Only run logic if we have more than 1 slide
            if (slides.length > 1) {
                let currentIndex = 0;
                const intervalTime = 5000; // 5 Seconds

                // Ensure first slide is active immediately
                slides[0].classList.add('active');

                setInterval(() => {
                    // Remove active from current
                    slides[currentIndex].classList.remove('active');
                    
                    // Calculate next
                    currentIndex = (currentIndex + 1) % slides.length;
                    
                    // Add active to next
                    slides[currentIndex].classList.add('active');
                }, intervalTime);
            } else if (slides.length === 1) {
                // Static image fallback
                slides[0].classList.add('active');
            }
        });
    });

})();

/* src/js/scrollEffects.js */
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Configure the Observer
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1 // Trigger when 10% visible
    };

    // 2. Create the Observer Instance
    const scrollObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // A. Element enters screen: Add class to animate UP
                entry.target.classList.add('view-active');
            } else {
                // B. Element leaves screen: Remove class to reset position
                // This ensures it will "rise up" again next time you scroll to it.
                entry.target.classList.remove('view-active');
            }
        });
    }, observerOptions);

    // 3. Target all elements with .scroll-rise-up
    const animatedElements = document.querySelectorAll('.scroll-rise-up');
    animatedElements.forEach(el => {
        scrollObserver.observe(el);
    });

});

/**
 * about.js
 * Handles interactions specific to the About Us page.
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        
        // --- NUMBER COUNTER ANIMATION ---
        const statsSection = document.querySelector('.story-stats');
        const counters = document.querySelectorAll('.stat-number');
        let hasAnimated = false;

        if (statsSection && counters.length > 0) {
            
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-count');
                    const duration = 2000; // 2 seconds
                    const increment = target / (duration / 16); // 60fps

                    let current = 0;
                    const updateCount = () => {
                        current += increment;
                        if (current < target) {
                            counter.innerText = Math.ceil(current);
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCount();
                });
            };

            // Observer to trigger animation when visible
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasAnimated) {
                        animateCounters();
                        hasAnimated = true;
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(statsSection);
        }

    });

})();