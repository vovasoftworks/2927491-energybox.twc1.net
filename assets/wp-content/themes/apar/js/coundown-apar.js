'use strict';

/**
 * Coundown JS
 *
 * @package apar
 */

(function ($) {
	'use strict';

	/**
  * WidgetCountdown
  *
  * @param $scope The widget wrapper element as a jQuery element
  * @param $ The jQuery alias
  */

	var WidgetCountdown = function WidgetCountdown($scope, $) {
		var countDown = function countDown() {
			var el = document.getElementsByClassName('flash-sale-cd'),
			    elen = el.length,
			    i = void 0;
			if (elen < 1) {
				return;
			}

			for (i = 0; i < elen; i++) {
				var _date = el[i].getAttribute('data-date'),
				    days_id = el[i].getElementsByClassName('cd-time')[0].id,
				    hours_id = el[i].getElementsByClassName('cd-time')[1].id,
				    mins_id = el[i].getElementsByClassName('cd-time')[2].id,
				    secs_id = el[i].getElementsByClassName('cd-time')[3].id;

				var counter = Doom({
					targetDate: _date,
					ids: {
						days: days_id,
						hours: hours_id,
						mins: mins_id,
						secs: secs_id
					}
				});

				counter.doom();
			}
		};

		var comingSoon = function comingSoon() {
			var countdowns = document.querySelectorAll('.apar-countdown-wrapper');

			if (!countdowns) {
				return;
			}

			countdowns.forEach(function (countdownContainer) {
				var digits = Array.from(countdownContainer.children);
				var targetDate = countdownContainer.getAttribute('data-date');
				var countdown = Doom({
					targetDate: targetDate,
					ids: {
						days: digits[0].querySelector('.apar-countdown-digit').id,
						hours: digits[1].querySelector('.apar-countdown-digit').id,
						mins: digits[2].querySelector('.apar-countdown-digit').id,
						secs: digits[3].querySelector('.apar-countdown-digit').id
					}
				});

				countdown.doom();
			});
		};

		countDown();
		comingSoon();
	};

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/apar-countdown.default', WidgetCountdown);
	});
})(jQuery);