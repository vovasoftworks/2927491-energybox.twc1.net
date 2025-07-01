"use strict";

(function ($) {
    'use strict';

    /**
     * @param $scope The widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */

    var WidgetFilmicGallery = function WidgetFilmicGallery($scope, $) {
        var content = $(".filmic-gallery-archive"),
            tabs = $(".filmic-gallery-widget__label span");
        tabs.on('click', function () {
            tabs.removeClass('active-image').filter(this).addClass('active-image');
            var filter = $(this).data('filter');
            content.isotope({
                filter: filter
            });
            return false;
        });
    };
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/filmic_gallery.default', WidgetFilmicGallery);
    });
})(jQuery);