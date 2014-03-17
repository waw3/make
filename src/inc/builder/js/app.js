/*global jQuery */
var oneApp = oneApp || {};

(function ($) {
	'use strict';

	// Kickoff Backbone App
	new oneApp.MenuView();

	oneApp.options = {
		openSpeed: 400,
		closeSpeed: 250
	};
})(jQuery);