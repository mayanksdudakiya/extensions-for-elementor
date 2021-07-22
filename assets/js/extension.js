( function( $ ) { 
 /*@ Column Stretch */
    function elementor_strecth_column() {
        var $column, $container;

        if (jQuery('.elementor-stretch-column-left').length > 0) {

            jQuery('.elementor-stretch-column-left').each(function () {

                $column = jQuery(this);
                $container = $column.parents('.elementor-container');

                if ($container.length === 0) {
                    return;
                }

                $container = Math.ceil($container.offset().left);
                var tempUpdated = $container;
                $column.find('> div').css({'margin-left': -tempUpdated + "px", 'width': 'calc( 100% + ' + tempUpdated + 'px )'});
            });
        }
        
        if (jQuery('.elementor-stretch-column-right').length > 0) {
            jQuery('.elementor-stretch-column-right').each(function () {

                $column = jQuery(this);
                $container = $column.parents('.elementor-container');

                if ($container.length === 0) {
                    return;
                }

                $container = Math.ceil($container.offset().left);
                var tempUpdated = $container;
                $column.find('> div').css({'margin-right': -tempUpdated + "px", 'width': 'calc( 100% + ' + tempUpdated + 'px )'});
            });
        }
    }

    /*@ Support megamenu with stretch column */
    if(jQuery(document).find('.elementor-stretch-column-left, .elementor-stretch-column-right').length) {
        jQuery(document).find('.ee-mb-megamenu-wrapper').mouseenter(function() { 
            elementor_strecth_column();
        });
    }
    jQuery(document).ready(elementor_strecth_column);
    jQuery(window).resize(elementor_strecth_column);

    /*@ Clickable Column */
    jQuery(document).on('click', 'body:not(.elementor-editor-active) .make-column-clickable-elementor', function (e) {

        var wrapper = jQuery(this),
            url = wrapper.data('column-clickable');

        if (url) {

            if (jQuery(e.target).filter('a, a *, .no-link, .no-link *').length) {
                return true;
            }

            // handle elementor actions
            if (url.match("^#elementor-action")) {

                var hash = url;
                var hash = decodeURIComponent(hash);

                // if is Popup
                if (hash.includes("elementor-action:action=popup:open") || hash.includes("elementor-action:action=lightbox")) {

                    if (0 === wrapper.find('#make-column-clickable-open-dynamic').length) {
                        wrapper.append('<a id="make-column-clickable-open-dynamic" style="display: none !important;" href="' + url + '">Open dynamic content</a>');
                    }

                    wrapper.find('#make-column-clickable-open-dynamic').click();

                    return true;
                }

                return true;
            }

            // smooth scroll
            if (url.match("^#")) {
                var hash = url;

                jQuery('html, body').animate({
                    scrollTop: jQuery(hash).offset().top
                }, 800, function () {
                    window.location.hash = hash;
                });

                return true;
            }

            window.open(url, wrapper.data('column-clickable-blank'));
            return false;
        }
    });
} )( jQuery );