/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	// Ensure property existence
	MakeBuilder.collection = MakeBuilder.collection || {};

	/**
	 *
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.collection.Sections = Backbone.Collection.extend({
		model: function(attrs, options) {
			return new MakeBuilder.model.Section(attrs, options);
		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);