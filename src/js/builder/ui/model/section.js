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
	MakeBuilder.model.Section = MakeBuilder.model.Base.extend({
		defaults: {}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);