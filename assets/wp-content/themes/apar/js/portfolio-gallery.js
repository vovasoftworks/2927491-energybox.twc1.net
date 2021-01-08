/**
 * Gallery js
 *
 * @package apar
 */

'use strict';

(function ($) {
	var WidgetAparGallery = function WidgetAparGallery($scope, $) {
		var content = $(".apar-gallery-archive"),
		    tabs = $(".apar-gallery-widget__label span");
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
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-gallery.default', WidgetAparGallery);
	});
})(jQuery);