/* global Backbone, jQuery, _, wp:true, tinyMCE, switchEditors */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, Backbone, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.GalleryItemView = Backbone.View.extend({
		template: '',
		className: 'ttf-one-gallery-item',

		events: {
			'click .ttf-one-gallery-item-remove': 'removeItem'
		},

		initialize: function (options) {
			this.model = options.model;
			this.idAttr = 'ttf-one-gallery-item-' + this.model.get('id');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;
			this.template = _.template($('#tmpl-ttf-one-gallery-item').html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON()))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'));
			return this;
		},

		removeItem: function (evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttf-one-gallery-items'),
				$orderInput = $('.ttf-one-gallery-item-order', $stage);

			oneApp.removeOrderValue(this.model.get('id'), $orderInput);

			// Fade and slide out the section, then cleanup view
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.remove();
			}.bind(this));
		}
	});
})(window, Backbone, jQuery, _, oneApp, $oneApp);