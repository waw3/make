/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	// Ensure property existence
	MakeBuilder.model = MakeBuilder.model || {};

	/**
	 *
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.model.Menu = MakeBuilder.model.Base.extend({
		defaults: {
			state: 'open'
		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);