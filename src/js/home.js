/**
 * js/home.js
 * Home page specific interactions
 */
(function($) {
    'use strict';

    $(document).ready(function() {

        // ═══════════════════════════════════════════════════
        // 1. HERO SLIDER LOGIC
        // ═══════════════════════════════════════════════════
        const $heroSlides = $('.hero-slide');
        if ($heroSlides.length > 0) {
            let heroIndex = 0;
            setInterval(function() {
                $heroSlides.eq(heroIndex).removeClass('active');
                heroIndex = (heroIndex + 1) % $heroSlides.length;
                $heroSlides.eq(heroIndex).addClass('active');
            }, 5000);
        }

        // ═══════════════════════════════════════════════════
        // 2. FILM ROLL LOGIC (Bi-Directional)
        // ═══════════════════════════════════════════════════
        const $track = $('#filmTrack');
        const $originalCards = $track.find('.film-card');
        
        if ($originalCards.length > 0) {
            const cardWidth = 300; 
            const gap = 40;        
            const slideStep = cardWidth + gap;
            const speed = 800;
            const pause = 3000;

            const $clonesBefore = $originalCards.slice(-2).clone().addClass('cloned');
            const $clonesAfter = $originalCards.slice(0, 2).clone().addClass('cloned');
            
            // Remove onclick from clones to prevent double submission
            $clonesBefore.find('.btn-action-home').removeAttr('onclick').prop('onclick', null);
            $clonesAfter.find('.btn-action-home').removeAttr('onclick').prop('onclick', null);
            
            $track.prepend($clonesBefore);
            $track.append($clonesAfter);
            
            const $allCards = $track.find('.film-card');
            const startIndex = $clonesBefore.length;
            let currentIndex = startIndex;
            let isAnimating = false;
            const centerOffset = -(cardWidth / 2);

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
                $allCards.removeClass('active');
                $allCards.eq(index).addClass('active');
            };

            $track.css('left', '50%');
            moveTo(currentIndex, false);

            setInterval(() => {
                if (isAnimating || document.hidden) return;
                isAnimating = true;
                currentIndex++;
                moveTo(currentIndex, true);
            }, pause);

            $track.on('transitionend', function() {
                isAnimating = false;
                const totalReal = $originalCards.length;
                const limitRight = startIndex + totalReal;

                if (currentIndex >= limitRight) {
                    $track.css('transition', 'none');
                    currentIndex = startIndex + (currentIndex - limitRight);
                    const position = centerOffset - (currentIndex * slideStep);
                    $track.css('transform', `translateX(${position}px)`);
                    void $track[0].offsetWidth; 
                    $allCards.removeClass('active');
                    $allCards.eq(currentIndex).addClass('active');
                }
            });
        }

        // ═══════════════════════════════════════════════════
        // 3. CART BUTTON EVENT LISTENERS
        // ═══════════════════════════════════════════════════
        
        /**
         * Handle "Add to Cart" buttons on home page
         */
        // Remove inline onclick handlers to prevent double submission
        $('.btn-action-home').removeAttr('onclick').prop('onclick', null);

        $(document).off('click', '.btn-action-home').on('click', '.btn-action-home', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            const $btn = $(this);
            const productId = $btn.data('id');
            const action = $btn.data('action') || 'add'; // 'add' or 'buy'

            // Validation
            if ($btn.prop('disabled')) return;

            if (!productId) {
                console.error('Product ID missing');
                return;
            }

            // Visual feedback
            const originalText = $btn.html();
            const originalDisabled = $btn.prop('disabled');
            
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Adding...');

            // Call global App.addToCart
            App.addToCart(
                { id: productId }, 
                action,
                function(response) {
                    // Success callback
                    $btn.prop('disabled', originalDisabled)
                        .html(originalText);
                }
            );

            // Reset button after delay (in case of error)
            setTimeout(() => {
                $btn.prop('disabled', originalDisabled)
                    .html(originalText);
            }, 2000);
        });

        /**
         * Alternative: Direct onclick handler for dynamic content
         */
        window.addToCartFromHome = function(productId, action = 'add') {
            App.addToCart({ id: productId }, action);
        };

    });

})(window.jQuery);