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
				'click': 'handleClick',
				'click .edit-content-link': 'onContentEdit',
				'click .ttfmake-overlay-open': 'openConfigurationOverlay',
				'overlay-open': 'onOverlayOpen',
				'click .ttfmake-text-column-remove': 'onColumnRemove'
			});
		},

		handleClick: function(e) {
			e.preventDefault();
			e.stopPropagation();

			$('.column-context-menu').hide();

			var $contextMenu = this.$el.find('.column-context-menu');

			if (e.srcElement.offsetParent.className !== 'column-context-menu') {
				$contextMenu.css({
					'top': e.pageY - this.$el.offset().top,
					'left': e.pageX - this.$el.offset().left
				}).show();

				$contextMenu.find('a').on('click', function() {
					$contextMenu.hide();
				});
			}

			$('body').click(function() {
				$contextMenu.hide();
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

		onOverlayOpen: function (e, $overlay) {
			e.stopPropagation();

			var $button = $('.ttfmake-overlay-close-update', $overlay);
			$button.text('Update column');
		}
	});
})(window, Backbone, jQuery, _, oneApp);
