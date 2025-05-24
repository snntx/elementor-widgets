/**
 * DOT Elementor Modules - Widgets JavaScript
 * 
 * This file contains the JavaScript functionality for the DOT Elementor widgets:
 * 1. DOT Image Lightbox Widget
 *    - Handles lightbox functionality for images
 *    - Connected to: widgets/image-lightbox.php
 * 
 * 2. DOT Custom Tabs Widget
 *    - Handles tab switching functionality
 *    - Connected to: widgets/tabs.php
 * 
 * Dependencies:
 * - jQuery (required by Elementor)
 */

(function($) {
    'use strict';

    /**
     * DOT Image Lightbox Widget Functionality
     * Handles the lightbox behavior for images
     */
    function initImageLightbox() {
        $('.image-lightbox a[data-lightbox]').on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var imageUrl = $this.attr('href');
            var imageTitle = $this.data('title');

            // Create lightbox overlay
            var $overlay = $('<div class="lightbox-overlay"></div>');
            var $lightbox = $('<div class="lightbox-content"></div>');
            var $image = $('<img src="' + imageUrl + '" alt="' + imageTitle + '">');
            var $caption = $('<div class="lightbox-caption">' + imageTitle + '</div>');
            var $close = $('<button class="lightbox-close">&times;</button>');

            // Assemble lightbox
            $lightbox.append($image, $caption, $close);
            $overlay.append($lightbox);
            $('body').append($overlay);

            // Close lightbox on click
            $overlay.on('click', function(e) {
                if (e.target === this) {
                    $overlay.remove();
                }
            });

            $close.on('click', function() {
                $overlay.remove();
            });
        });
    }

    /**
     * DOT Custom Tabs Widget Functionality
     * Handles the tab switching behavior
     */
    function initCustomTabs() {
        $('.tab-title').on('click', function() {
            var $this = $(this);
            var tabId = $this.data('tab');
            
            // Update active states
            $this.closest('.tabs-navigation').find('.tab-title').removeClass('active');
            $this.addClass('active');
            
            // Show selected content
            $this.closest('.custom-tabs').find('.tab-content').removeClass('active');
            $this.closest('.custom-tabs').find('.tab-content[data-tab="' + tabId + '"]').addClass('active');
        });
    }

    // Initialize widgets when Elementor frontend is ready
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/dot_image_lightbox.default', initImageLightbox);
        elementorFrontend.hooks.addAction('frontend/element_ready/dot_custom_tabs.default', initCustomTabs);
    });

})(jQuery); 