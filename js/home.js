/* src/js/home.js */
(function($) {
  'use strict';

  $(document).ready(function() {

    // =========================================================
    // 1. HERO SLIDER LOGIC (Top)
    // =========================================================
    const $heroSlides = $('.hero-slide');
    if ($heroSlides.length > 0) {
        let heroIndex = 0;
        setInterval(function() {
            $heroSlides.eq(heroIndex).removeClass('active');
            heroIndex = (heroIndex + 1) % $heroSlides.length;
            $heroSlides.eq(heroIndex).addClass('active');
        }, 5000);
    }

    // =========================================================
    // 2. TRUE CIRCULAR FILM ROLL (Bi-Directional)
    // =========================================================
    const $track = $('#filmTrack');
    const $originalCards = $track.find('.film-card');
    
    if ($originalCards.length > 0) {
        // --- CONFIG ---
        const cardWidth = 300; // Match CSS
        const gap = 40;        // Match CSS margin-right
        const slideStep = cardWidth + gap;
        const speed = 800;
        const pause = 3000;

        // 1. CLONE SETUP
        // Clone Last 2 items -> Prepend to start
        const $clonesBefore = $originalCards.slice(-2).clone().addClass('cloned');
        // Clone First 2 items -> Append to end
        const $clonesAfter = $originalCards.slice(0, 2).clone().addClass('cloned');
        
        $track.prepend($clonesBefore);
        $track.append($clonesAfter);
        
        const $allCards = $track.find('.film-card');
        
        // 2. STARTING POSITION
        const startIndex = $clonesBefore.length;
        let currentIndex = startIndex;
        let isAnimating = false;

        // Center Offset: Screen Center (50%) - Half Card (150px)
        const centerOffset = -(cardWidth / 2);

        // Helper to Move
        const moveTo = (index, animate) => {
            const position = centerOffset - (index * slideStep);
            
            if (animate) {
                $track.css({
                    'transition': `transform ${speed}ms cubic-bezier(0.25, 1, 0.5, 1)`,
                    'transform': `translateX(${position}px)`
                });
            } else {
                $track.css({
                    'transition': 'none',
                    'transform': `translateX(${position}px)`
                });
            }

            // Update Active Highlight
            $allCards.removeClass('active');
            $allCards.eq(index).addClass('active');
        };

        // Initialize: Jump instantly to Real Item 1
        $track.css('left', '50%');
        moveTo(currentIndex, false);

        // 3. THE LOOP
        setInterval(() => {
            if (isAnimating || document.hidden) return;
            isAnimating = true;

            currentIndex++;
            moveTo(currentIndex, true);

        }, pause);

        // 4. THE INVISIBLE SNAP (Infinite Loop Effect)
        $track.on('transitionend', function() {
            isAnimating = false;

            const totalReal = $originalCards.length;
            const limitRight = startIndex + totalReal;

            if (currentIndex >= limitRight) {
                // Snap back to Real 1
                $track.css('transition', 'none');
                currentIndex = startIndex + (currentIndex - limitRight);
                
                const position = centerOffset - (currentIndex * slideStep);
                $track.css('transform', `translateX(${position}px)`);
                
                // Force Reflow
                void $track[0].offsetWidth; 
                
                // Re-highlight
                $allCards.removeClass('active');
                $allCards.eq(currentIndex).addClass('active');
            }
        });
    }

  });

})(window.jQuery);