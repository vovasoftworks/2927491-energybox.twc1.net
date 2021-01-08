/**
 * Testimonial js
 *
 * @package apar
 */

'use strict';

(function ($) {
	var AparTestimonial = function AparTestimonial($scope, $) {
		var slide = $scope.find('.js-testimonial'),
		    show = $scope.find('.testimonial-wrapper').attr('data-show') || 1,
		    showtablet = $scope.find('.testimonial-wrapper').attr('data-show-tablet') || show,
		    showmobile = $scope.find('.testimonial-wrapper').attr('data-show-mobile') || show;

		$(slide).slick({
			dots: true,
			arrows: false,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 2000,
			slidesToShow: show,
			appendDots: $scope.find(".testimonial-slider-dots"),
			customPaging: function customPaging(slider, i) {
				return '<span class="dots-bullet"></span>';
			},
			responsive: [{
				breakpoint: 1622,
				settings: {
					slidesToShow: show,
					slidesToScroll: 1
				}
			}, {
				breakpoint: 1170,
				settings: {
					slidesToShow: showtablet,
					slidesToScroll: 1
				}
			}, {
				breakpoint: 600,
				settings: {
					slidesToShow: showmobile,
					slidesToScroll: 1
				}
			}]
		});

		$('.testimonial-wrapper .arrows-prev').click(function () {
			$(slide).slick('slickPrev');
		});

		$('.testimonial-wrapper .arrows-next').click(function () {
			$(slide).slick('slickNext');
		});
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-testimonial.default', AparTestimonial);
	});
})(jQuery);