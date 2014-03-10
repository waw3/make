/* global jQuery */
(function($) {
	'use strict';

	var ttfOne = {
		cache: {
			$document: $(document)
		},

		init: function() {
			this.cacheElements();
			this.bindEvents();
		},

		cacheElements: function() {},

		bindEvents: function() {}
	};

	ttfOne.init();
})(jQuery);