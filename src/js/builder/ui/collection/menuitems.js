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
	MakeBuilder.collection.MenuItems = Backbone.Collection.extend({
		model: function(attrs, options) {
			return new MakeBuilder.model.MenuItem(attrs, options);
		},

		comparator: 'priority'
	});
})(jQuery, Backbone, _, wp, MakeBuilder);