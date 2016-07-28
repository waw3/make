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
		}
	});
})(jQuery, Backbone, _, wp, MakeBuilder);