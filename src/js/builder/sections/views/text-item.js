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
				'click .ttfmake-overlay-open': 'openConfigurationOverlay',
				'overlay-open': 'onOverlayOpen',
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
			var $button = $('.ttfmake-overlay-close-update', $overlay);
			$button.text('Update column');
		}
	});
})(window, Backbone, jQuery, _, oneApp);
