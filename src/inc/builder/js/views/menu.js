/* global Backbone, jQuery, _, BasisBuilderApp, setUserSetting, deleteUserSetting, basisHTMLBuilderData */
var oneApp = oneApp || {};

(function (window, Backbone, $, _) {
	'use strict';

	oneApp.MenuView = Backbone.View.extend({
		el: '#ttf-one-menu',

		$stage: $('#ttf-one-stage'),

		$document: $(window.document),

		$scrollHandle: $('html, body'),

		$pane: $('.ttf-one-menu-pane'),

		events: {
			'click .ttf-one-menu-list-item-link': 'addSection',
			'click .ttf-one-menu-tab-link': 'menuToggle'
		},

		menuToggle: function(evt) {
			evt.preventDefault();
			var id = ttfOneBuilderData.pageID,
				key = 'ttfonemt' + parseInt(id, 10);

			// Open it down
			if (this.$pane.is(':hidden')) {
				this.$pane.slideDown({
					duration: oneApp.options.openSpeed,
					easing: 'easeInOutQuad',
					complete: function() {
						deleteUserSetting( key );
						this.$el.addClass('ttf-one-menu-opened').removeClass('ttf-one-menu-closed');
					}.bind(this)
				});

			// Close it up
			} else {
				this.$pane.slideUp({
					duration: oneApp.options.closeSpeed,
					easing: 'easeInOutQuad',
					complete: function() {
						setUserSetting( key, 'c' );
						this.$el.addClass('ttf-one-menu-closed').removeClass('ttf-one-menu-opened');
					}.bind(this)
				});
			}
		}
	});
})(window, Backbone, jQuery, _);