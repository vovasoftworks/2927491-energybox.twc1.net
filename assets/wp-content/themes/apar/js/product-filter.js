/**
 * Product Filter JS
 *
 * @package apar
 */

'use strict';

(function ($) {
	/**
  * Product Filter
  *
  * @param $scope The widget wrapper element as a jQuery element
  * @param $ The jQuery alias
  */
	var WidgetProductFilter = function WidgetProductFilter($scope, $) {

		/**
   * Filter JS
   */
		var $tabs = $scope.find('.tab-item'),
		    $contents = $scope.find('.data-content');

		$tabs.each(function (index) {
			var $tab = $(this);
			if ($tab.hasClass('active')) {
				var atttab = $tab.attr('data-content');
				$contents.each(function (index) {
					var $t = $(this).attr('data-content');
					if (atttab === $t) {
						$(this).addClass('tab-active');
					}
				});
			}

			$($tab).on('click', function (argument) {
				var $product = $(this).attr('data-content');

				$(this).parent().find('.active').removeClass('active');
				$(this).addClass('active');

				$contents.each(function (index) {
					var $t = $(this).attr('data-content');
					if ($product === $t) {
						$(this).parents('.product-filter-content').find('.tab-active').removeClass('tab-active');
						$(this).addClass('tab-active');
					}
				});
			});
		});

		/**
   * Slider JS
   */
		var slide = $scope.find('.js-products-slider'),
		    rows = $scope.find('.product-filter-content').attr('data-rows') || 2,
		    auto = $scope.find('.product-filter-content').attr('data-autoplay');

		if ('yes' === auto) {
			auto = true;
		} else {
			auto = false;
		}

		$(slide).slick({
			dots: false,
			arrows: false,
			rows: rows,
			infinite: true,
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 3,
			slidesToScroll: 1,
			autoplay: auto,
			autoplaySpeed: 3000,
			responsive: [{
				breakpoint: 1622,
				settings: { slidesToShow: 3 }
			}, {
				breakpoint: 960,
				settings: { slidesToShow: 2 }
			}, {
				breakpoint: 600,
				settings: { slidesToShow: 1 }
			}]
		});

		$('.product-filter-content .arrows-prev').click(function () {
			$(slide).slick('slickPrev');
		});

		$('.product-filter-content .arrows-next').click(function () {
			$(slide).slick('slickNext');
		});
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-product-filter.default', WidgetProductFilter);
	});
})(jQuery);