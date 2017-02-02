/* global Backbone, jQuery, _ */
var oneApp = oneApp || {};

(function (window, Backbone, $, _, oneApp) {
	'use strict';

	oneApp.views = oneApp.views || {}

	oneApp.views['text-item'] = oneApp.views.item.extend({
		el: '',
		elSelector: '',
		className: 'ttfmake-text-column',

		events: function() {
			return _.extend({}, oneApp.views.item.prototype.events, {
				'click .edit-content-link': 'onContentEdit',
<<<<<<< HEAD
				'click .ttfmake-overlay-open': 'openConfigurationOverlay',
				'overlay-open': 'onOverlayOpen',
=======
				'click .ttfmake-text-column-remove': 'onColumnRemove'
>>>>>>> 6b5ad0b... Make rows work as gallery items.
			});
		},

		initialize: function (options) {
			this.template = _.template(ttfMakeSectionTemplates['text-item'], oneApp.builder.templateSettings);
		},

		render: function () {
			var html = this.template(this.model);
			this.setElement(html);

			return this;
		},

		onOverlayOpen: function (e, $overlay) {
			e.stopPropagation();

<<<<<<< HEAD
			var $button = $('.ttfmake-overlay-close-update', $overlay);
=======
		onColumnRemove: function(evt) {
			evt.preventDefault();

			var $stage = this.$el.parents('.ttfmake-text-columns-stage');

			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.builder.options.closeSpeed, function() {
				this.$el.trigger('column-remove', this);
				this.remove();
			}.bind(this));
		},

		onContentEdit: function(e) {
			oneApp.views.item.prototype.onContentEdit.apply(this, arguments);

			var $overlay = oneApp.builder.tinymceOverlay.$el;
			var $button = $('.ttfmake-overlay-close', $overlay);
>>>>>>> 6b5ad0b... Make rows work as gallery items.
			$button.text('Update column');
		}
	});
})(window, Backbone, jQuery, _, oneApp);
