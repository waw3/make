/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	MakeBuilder.view = MakeBuilder.view || {};

	/**
	 *
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.view.MenuItem = Backbone.View.extend({
		tagName: 'li',

		template: wp.template('make-builder-menuitem'),

		/**
		 *
		 */
		initialize: function() {
			this.render();
		},

		/**
		 *
		 * @returns {MakeBuilder.view.MenuItem}
		 */
		render: function() {
			this.$el.html(this.template(this.model.toJSON()));

			return this;
		},

		/**
		 *
		 */
		events: {
			"click" : "addSection"
		},

		/**
		 *
		 * @since 1.8.0.
		 *
		 * @param event
		 */
		addSection: function(event) {
			event.preventDefault();
			console.log('Add a ' + this.model.get('label') + ' section!');
		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);