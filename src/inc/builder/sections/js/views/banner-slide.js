/* global Backbone, jQuery, _, wp:true, tinyMCE, switchEditors */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, Backbone, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.BannerSlideView = Backbone.View.extend({
		template: '',
		className: 'ttf-one-banner-slide ttf-one-banner-slide-open',

		events: {
			'click .ttf-one-banner-slide-remove': 'removeItem',
			'click .ttf-one-banner-slide-toggle': 'toggleSection'
		},

		initialize: function (options) {
			this.model = options.model;
			this.idAttr = 'ttf-one-banner-slide-' + this.model.get('id');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;
			this.template = _.template($('#tmpl-ttf-one-banner-slide').html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON()))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'));
			return this;
		},

		removeItem: function (evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttf-one-banner-slides'),
				$orderInput = $('.ttf-one-banner-slide-order', $stage);

			oneApp.removeOrderValue(this.model.get('id'), $orderInput);

			// Fade and slide out the section, then cleanup view
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.remove();
			}.bind(this));
		},

		toggleSection: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$section = $this.parents('.ttf-one-banner-slide'),
				$sectionBody = $('.ttf-one-banner-slide-body', $section),
				$input = $('.ttf-one-banner-slide-state', this.$el);

			if ($section.hasClass('ttf-one-banner-slide-open')) {
				$sectionBody.slideUp(oneApp.options.closeSpeed, function() {
					$section.removeClass('ttf-one-banner-slide-open');
					$input.val('closed');
				});
			} else {
				$sectionBody.slideDown(oneApp.options.openSpeed, function() {
					$section.addClass('ttf-one-banner-slide-open');
					$input.val('open');
				});
			}
		}
	});
})(window, Backbone, jQuery, _, oneApp, $oneApp);