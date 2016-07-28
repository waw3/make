/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	// Ensure property existence
	MakeBuilder.view = MakeBuilder.view || {};

	/**
	 *
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.view.Stage = Backbone.View.extend({
		el: '#ttfmake-stage',

		initialize: function() {

		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);