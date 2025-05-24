/*
 * Elementor Modules Widgets JavaScript
 * 
 * This file handles all interactive functionality for the custom Elementor widgets:
 * 1. Tabs Widget: Manages tab switching and content display
 * 2. Image Lightbox: Handles image popup functionality with captions
 * 
 * Dependencies:
 * - jQuery (required by Elementor)
 * - Connected to: widgets/image-lightbox.php and widgets/tabs.php
 */

jQuery(document).ready(function($) {
    // Tabs Widget Functionality
    // Handles the switching between tabs and their content
    // Connected to: widgets/tabs.php
    $('.tab-title').on('click', function() {
        var tabId = $(this).data('tab');
        var $tabsContainer = $(this).closest('.custom-tabs');
        
        $tabsContainer.find('.tab-title').removeClass('active');
        $tabsContainer.find('.tab-content').removeClass('active');
        
        $(this).addClass('active');
        $tabsContainer.find('.tab-content[data-tab="' + tabId + '"]').addClass('active');
    });

    // Image Lightbox Widget Functionality
    // Creates a popup overlay for images with captions
    // Connected to: widgets/image-lightbox.php
    $('.image-lightbox a').on('click', function(e) {
        e.preventDefault();
        
        var imageUrl = $(this).attr('href');
        var imageTitle = $(this).data('title');
        
        // Create lightbox overlay
        var $overlay = $('<div class="lightbox-overlay"></div>');
        var $lightbox = $('<div class="lightbox-container"></div>');
        var $image = $('<img src="' + imageUrl + '" alt="' + imageTitle + '">');
        var $caption = $('<div class="lightbox-caption">' + imageTitle + '</div>');
        var $close = $('<div class="lightbox-close">&times;</div>');
        
        $lightbox.append($image, $caption, $close);
        $overlay.append($lightbox);
        $('body').append($overlay);
        
        // Add lightbox styles
        $('<style>')
            .text(`
                .lightbox-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 9999;
                }
                .lightbox-container {
                    position: relative;
                    max-width: 90%;
                    max-height: 90%;
                }
                .lightbox-container img {
                    max-width: 100%;
                    max-height: 80vh;
                    display: block;
                    margin: 0 auto;
                }
                .lightbox-caption {
                    color: white;
                    text-align: center;
                    padding: 10px;
                    font-size: 16px;
                }
                .lightbox-close {
                    position: absolute;
                    top: -40px;
                    right: 0;
                    color: white;
                    font-size: 30px;
                    cursor: pointer;
                    width: 30px;
                    height: 30px;
                    line-height: 30px;
                    text-align: center;
                }
            `)
            .appendTo('head');
        
        // Close lightbox handlers
        $close.on('click', function() {
            $overlay.remove();
        });
        
        $overlay.on('click', function(e) {
            if ($(e.target).hasClass('lightbox-overlay')) {
                $overlay.remove();
            }
        });
        
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // ESC key
                $overlay.remove();
            }
        });
    });
}); 