/**
 * Product Slider JS
 *
 * @package apar
 */

'use strict';

(function ($) {

	/**
  * Product Slider
  *
  * @param $scope The widget wrapper element as a jQuery element
  * @param $ The jQuery alias
  */
	var WidgetProductSlider = function WidgetProductSlider($scope, $) {
		/**
   * Slider JS
   */
		var slide = $scope.find('.js-products-slider-sidebar'),
		    show = $scope.find('.product-js-products-slider-sidebar').attr('data-show') || 1,
		    showtablet = $scope.find('.product-js-products-slider-sidebar').attr('data-show-tablet') || show,
		    showmobile = $scope.find('.product-js-products-slider-sidebar').attr('data-show-mobile') || show,
		    rows = $scope.find('.product-js-products-slider-sidebar').attr('data-rows') || 3;

		$(slide).slick({
			dots: false,
			arrows: false,
			rows: rows,
			infinite: true,
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: show,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 3000,
			responsive: [{
				breakpoint: 1622,
				settings: { slidesToShow: show }
			}, {
				breakpoint: 960,
				settings: { slidesToShow: showtablet }
			}, {
				breakpoint: 600,
				settings: { slidesToShow: showmobile }
			}]
		});

		$('.product-js-products-slider-sidebar .arrows-prev').click(function () {
			$(slide).slick('slickPrev');
		});

		$('.product-js-products-slider-sidebar .arrows-next').click(function () {
			$(slide).slick('slickNext');
		});
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-product-slider.default', WidgetProductSlider);
	});
})(jQuery);