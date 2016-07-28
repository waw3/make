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
	MakeBuilder.view.Menu = Backbone.View.extend({
		el: '#ttfmake-menu',

		/**
		 *
		 */
		initialize: function() {
			var self = this;

			// Cache the list element
			this.$list = this.$('.ttfmake-menu-list');

			// Add models to the collection
			_.each(this.model.get('items'), function(item) {
				self.collection.add(item);
			});

			this.render();
		},

		/**
		 *
		 * @returns {MakeBuilder.view.Menu}
		 */
		render: function() {
			var self = this;

			// Create a menu item view for each model in the collection
			this.collection.each(function(item) {
				var menuItem = new MakeBuilder.view.MenuItem({ model: item });
				self.$list.append(menuItem.$el);
			});

			return this;
		},

		/**
		 * Bind events.
		 *
		 * @since 1.8.0.
		 */
		events: {

		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);