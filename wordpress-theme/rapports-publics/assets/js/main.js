/*!
 * Rapports Publics Theme JavaScript
 * Handles mobile menu, FAQ accordion, filters, and other interactive elements
 */

(function($) {
    'use strict';

    // Initialize when DOM is ready
    $(document).ready(function() {
        initMobileMenu();
        initFAQAccordion();
        initFilterDropdowns();
        initSmoothScrolling();
        initSearchFunctionality();
        initCardHovers();
    });

    /**
     * Mobile menu toggle functionality
     */
    function initMobileMenu() {
        $('#menuToggle').on('click', function(e) {
            e.preventDefault();
            
            const $menu = $('#primary-menu');
            const $toggle = $(this);
            
            $menu.toggleClass('show');
            
            // Update aria-expanded attribute for accessibility
            const isExpanded = $toggle.attr('aria-expanded') === 'true';
            $toggle.attr('aria-expanded', !isExpanded);
            
            // Update screen reader text
            const $srText = $toggle.find('.screen-reader-text');
            if ($srText.length) {
                $srText.text(isExpanded ? 'Ouvrir le menu' : 'Fermer le menu');
            }
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            const $menu = $('#primary-menu');
            const $toggle = $('#menuToggle');
            
            if (!$toggle.is(e.target) && !$toggle.has(e.target).length && 
                !$menu.is(e.target) && !$menu.has(e.target).length) {
                $menu.removeClass('show');
                $toggle.attr('aria-expanded', 'false');
            }
        });

        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                const $menu = $('#primary-menu');
                const $toggle = $('#menuToggle');
                
                $menu.removeClass('show');
                $toggle.attr('aria-expanded', 'false').focus();
            }
        });
    }

    /**
     * FAQ accordion functionality
     */
    function initFAQAccordion() {
        $('.faq-question').on('click', function(e) {
            e.preventDefault();
            
            const $faqItem = $(this).parent('.faq-item');
            const $answer = $faqItem.find('.faq-answer');
            const isActive = $faqItem.hasClass('active');
            
            // Close all other FAQ items
            $('.faq-item').not($faqItem).removeClass('active');
            $('.faq-answer').not($answer).slideUp(300);
            
            // Toggle current item
            if (isActive) {
                $faqItem.removeClass('active');
                $answer.slideUp(300);
            } else {
                $faqItem.addClass('active');
                $answer.slideDown(300);
            }
            
            // Update aria-expanded for accessibility
            $(this).attr('aria-expanded', !isActive);
        });

        // Keyboard navigation for FAQ
        $('.faq-question').on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).click();
            }
        });
    }

    /**
     * Filter dropdowns functionality
     */
    function initFilterDropdowns() {
        $('#ministry-filter, #category-filter, #year-filter, #ministry-filter-category, #category-filter-ministry').on('change', function() {
            const value = $(this).val();
            if (value && value !== '') {
                // Add loading state
                $(this).addClass('loading');
                
                // Redirect to filtered URL
                window.location.href = value;
            }
        });

        // Search form functionality
        $('#report-search-form').on('submit', function(e) {
            const searchTerm = $('#search-input').val().trim();
            if (searchTerm === '') {
                e.preventDefault();
                $('#search-input').focus();
            }
        });
    }

    /**
     * Smooth scrolling for anchor links
     */
    function initSmoothScrolling() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
                location.hostname === this.hostname) {
                
                const target = $(this.hash);
                const $target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                
                if ($target.length) {
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 80 // Account for fixed header
                    }, 800);
                    return false;
                }
            }
        });
    }

    /**
     * Search functionality
     */
    function initSearchFunctionality() {
        const $searchInput = $('#search-input');
        const $searchResults = $('#search-results');
        let searchTimeout;

        if ($searchInput.length && $searchResults.length) {
            $searchInput.on('input', function() {
                const query = $(this).val().trim();
                
                clearTimeout(searchTimeout);
                
                if (query.length >= 3) {
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                } else {
                    $searchResults.hide();
                }
            });

            // Hide results when clicking outside
            $(document).on('click', function(e) {
                if (!$searchInput.is(e.target) && !$searchResults.is(e.target) && 
                    !$searchResults.has(e.target).length) {
                    $searchResults.hide();
                }
            });
        }
    }

    /**
     * Perform AJAX search
     */
    function performSearch(query) {
        const $results = $('#search-results');
        
        $.ajax({
            url: rapportsPublics.ajaxUrl,
            type: 'POST',
            data: {
                action: 'search_reports',
                query: query,
                nonce: rapportsPublics.nonce
            },
            beforeSend: function() {
                $results.html('<div class="search-loading">Recherche en cours...</div>').show();
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.length > 0) {
                        let html = '<ul class="search-results-list">';
                        $.each(response.data, function(index, report) {
                            html += `<li><a href="${report.url}">${report.title}</a></li>`;
                        });
                        html += '</ul>';
                        $results.html(html);
                    } else {
                        $results.html('<div class="no-results">Aucun résultat trouvé</div>');
                    }
                } else {
                    $results.html('<div class="search-error">Erreur lors de la recherche</div>');
                }
            },
            error: function() {
                $results.html('<div class="search-error">Erreur lors de la recherche</div>');
            }
        });
    }

    /**
     * Card hover effects
     */
    function initCardHovers() {
        $('.report-card').hover(
            function() {
                $(this).addClass('hovered');
            },
            function() {
                $(this).removeClass('hovered');
            }
        );
    }

    /**
     * File download tracking
     */
    window.trackDownload = function(reportId, fileName) {
        if (typeof gtag !== 'undefined') {
            gtag('event', 'file_download', {
                'event_category': 'engagement',
                'event_label': fileName,
                'custom_report_id': reportId
            });
        }
        
        // Track in WordPress
        $.ajax({
            url: rapportsPublics.ajaxUrl,
            type: 'POST',
            data: {
                action: 'track_download',
                report_id: reportId,
                nonce: rapportsPublics.nonce
            }
        });
    };

    /**
     * Form validation
     */
    function initFormValidation() {
        $('form').on('submit', function(e) {
            const $form = $(this);
            let isValid = true;
            
            // Clear previous errors
            $form.find('.error-message').remove();
            $form.find('.error').removeClass('error');
            
            // Check required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (value === '') {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<span class="error-message">Ce champ est requis</span>');
                }
            });
            
            // Check email fields
            $form.find('[type="email"]').each(function() {
                const $field = $(this);
                const email = $field.val().trim();
                
                if (email && !isValidEmail(email)) {
                    isValid = false;
                    $field.addClass('error');
                    $field.after('<span class="error-message">Adresse email non valide</span>');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Focus on first error field
                $form.find('.error').first().focus();
            }
        });
    }

    /**
     * Email validation helper
     */
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    /**
     * Initialize tooltips
     */
    function initTooltips() {
        $('[data-tooltip]').hover(
            function() {
                const tooltipText = $(this).attr('data-tooltip');
                const $tooltip = $('<div class="tooltip">' + tooltipText + '</div>');
                
                $('body').append($tooltip);
                
                const offset = $(this).offset();
                const elementWidth = $(this).outerWidth();
                const tooltipWidth = $tooltip.outerWidth();
                
                $tooltip.css({
                    top: offset.top - $tooltip.outerHeight() - 5,
                    left: offset.left + (elementWidth / 2) - (tooltipWidth / 2)
                }).fadeIn(200);
            },
            function() {
                $('.tooltip').fadeOut(200, function() {
                    $(this).remove();
                });
            }
        );
    }

    /**
     * Back to top button
     */
    function initBackToTop() {
        const $backToTop = $('<button id="back-to-top" title="Retour en haut"><span class="sr-only">Retour en haut</span>↑</button>');
        $('body').append($backToTop);
        
        $(window).scroll(function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });
        
        $backToTop.on('click', function() {
            $('html, body').animate({scrollTop: 0}, 600);
        });
    }

    // Initialize additional features
    $(document).ready(function() {
        initFormValidation();
        initTooltips();
        initBackToTop();
    });

})(jQuery);