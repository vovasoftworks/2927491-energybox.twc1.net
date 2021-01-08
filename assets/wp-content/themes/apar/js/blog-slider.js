'use strict';

/**
 * Blog Slider js
 *
 * @package apar
 */

(function ($) {
	'use strict';

	/**
  * Blog Slider js
  *
  * @param $scope The widget wrapper element as a jQuery element.
  * @param $ The jQuery alias.
  */

	var WidgetBlogSlider = function WidgetBlogSlider($scope, $) {
		var slide = $scope.find('.js-blog-slider'),
		    showdot = slide.attr('data-dot'),
		    show = $scope.find('.blog-slider-wrapper').attr('data-show') || 2,
		    showtablet = $scope.find('.blog-slider-wrapper').attr('data-show-tablet') || show,
		    showmobile = $scope.find('.blog-slider-wrapper').attr('data-show-mobile') || show;

		if (slide.attr('data-dot') === 'yes') {
			showdot = true;
		} else {
			showdot = false;
		}

		$(slide).slick({
			dots: showdot,
			arrows: false,
			infinite: true,
			speed: 1000,
			centerMode: true,
			centerPadding: '0px',
			autoplay: true,
			autoplaySpeed: 3000,
			slidesToShow: show,
			slidesToScroll: 1,
			appendDots: $scope.find(".blog-slider-dots"),
			customPaging: function customPaging(slider, i) {
				return '<span class="dots-bullet"></span>';
			},
			responsive: [{
				breakpoint: 1622,
				settings: { slidesToShow: show }
			}, {
				breakpoint: 1025,
				settings: { slidesToShow: showtablet }
			}, {
				breakpoint: 768,
				settings: { slidesToShow: showmobile }
			}]
		});

		$('.blog-slider-wrapper .arrows-prev').click(function () {
			$(slide).slick('slickPrev');
		});

		$('.blog-slider-wrapper .arrows-next').click(function () {
			$(slide).slick('slickNext');
		});
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-blog-slider.default', WidgetBlogSlider);
	});
})(jQuery);