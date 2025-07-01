/**
 * Images slider js
 *
 * @package apar
 */

'use strict';

(function ($) {
	var AparImageSlider = function AparImageSlider($scope, $) {
		var slide = $scope.find('.js-images-slider'),
		    show = $scope.find('.images-slider-wrapper').attr('data-show') || 1,
		    showtablet = $scope.find('.images-slider-wrapper').attr('data-show-tablet') || show,
		    showmobile = $scope.find('.images-slider-wrapper').attr('data-show-mobile') || show;

		$(slide).slick({
			dots: false,
			arrows: false,
			slidesToScroll: 1,
			//autoplay: true,
			autoplaySpeed: 2000,
			slidesToShow: show,
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
				breakpoint: 480,
				settings: {
					slidesToShow: showmobile,
					slidesToScroll: 1
				}
			}]
		});

		$('.images-slider-wrapper .arrows-prev').click(function () {
			$(slide).slick('slickPrev');
		});

		$('.images-slider-wrapper .arrows-next').click(function () {
			$(slide).slick('slickNext');
		});
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-images-slider.default', AparImageSlider);
	});
})(jQuery);