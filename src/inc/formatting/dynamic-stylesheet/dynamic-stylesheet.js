/**
 * Script for adding dynamic style rules to a page.
 *
 * Most useful for adding rules that use pseudo-selectors, which can't be inlined,
 * or other rules that can't be added in the normal stylesheet.
 *
 * @since 1.4.0.
 */
/* global jQuery, tinymce */

var ttfmakeDynamicStylesheet;

(function($) {
	'use strict';

	ttfmakeDynamicStylesheet = {
		/**
		 *
		 */
		cache: {
			$document: $(document)
		},

		/**
		 *
		 */
		cacheSelector: {
			$button: 'a.ttfmake-button[data-hover-color], a.ttfmake-button[data-hover-background-color]',
			$list: 'ul.ttfmake-list[data-icon-color]'
		},

		/**
		 *
		 */
		builder: {
			button: function(self) {
				if (self.cache.$button.length > 0) {
					self.createStylesheet();

					self.cache.$button.each(function() {
						var buttonID = $(this).attr('id'),
							backgroundColor = $(this).data('hover-background-color'),
							color = $(this).data('hover-color');

						if (buttonID) {
							if (backgroundColor) self.addCSSRule(self.stylesheet, '#' + buttonID + ':hover', 'background-color: ' + backgroundColor + ' !important');
							if (color) self.addCSSRule(self.stylesheet, '#' + buttonID + ':hover', 'color: ' + color + ' !important');
						}
					});
				}
			},
			list: function(self) {
				if (self.cache.$list.length > 0) {
					self.createStylesheet();

					self.cache.$list.each(function() {
						var listID = $(this).attr('id'),
							iconColor = $(this).attr('data-icon-color');

						if (listID && iconColor) {
							self.addCSSRule(self.stylesheet, '#' + listID + ' li:before', 'color: ' + iconColor);
						}
					});
				}
			}
		},

		/**
		 *
		 */
		init: function() {
			if ('undefined' === typeof ttfmakeDynamicStylesheetVars || ! ttfmakeDynamicStylesheetVars.tinymce) {
				this.root = this.cache.$document;

				var self = this;
				this.cache.$document.ready(function() {
					self.cacheElements();
					self.buildStyles();
				} );
			}
		},

		/**
		 *
		 * @param editor
		 */
		tinymceInit: function(editor) {
			this.root = $(editor.getBody());

			this.cacheElements();
			this.buildStyles();
		},

		/**
		 *
		 */
		cacheElements: function() {
			var self = this;

			$.each(this.cacheSelector, function(name, selector) {
				self.cache[name] = $(selector, self.root);
			});
		},

		/**
		 *
		 */
		buildStyles: function() {
			var self = this;

			$.each(this.builder, function(name, f) {
				f(self);
			});
		},

		/**
		 * @link http://davidwalsh.name/add-rules-stylesheets
		 */
		createStylesheet: function() {
			var self = this;

			this.stylesheet = this.stylesheet || (function() {
				// Create the <style> tag
				var $style = $('<style type="text/css">');

				// Add an id
				$style.attr('id', 'ttfmake-dynamic-styles');

				// WebKit hack :(
				//style.appendChild(document.createTextNode(''));
				$style.text('');

				// Add the <style> element to the page
				if (self.root.find('head').length > 0) {
					self.root.find('head').append($style);
				} else {
					self.root.parent().find('head').append($style);
				}

				return $style.get(0).sheet;
			})();
		},

		/**
		 *
		 */
		removeStylesheet: function() {
			if (this.root.find('head').length > 0) {
				$('#ttfmake-dynamic-styles', this.root).remove();
			} else {
				this.root.parent().find('#ttfmake-dynamic-styles').remove();
			}
			delete this.stylesheet;
		},

		/**
		 *
		 */
		resetStylesheet: function() {
			this.removeStylesheet();
			this.cacheElements();
			this.buildStyles();
		},

		/**
		 *
		 *
		 * @link http://davidwalsh.name/add-rules-stylesheets
		 *
		 * @param sheet
		 * @param selector
		 * @param rules
		 * @param index
		 */
		addCSSRule: function(sheet, selector, rules, index) {
			var ruleIndex = index || 0;

			if('insertRule' in sheet) {
				sheet.insertRule(selector + '{' + rules + '}', ruleIndex);
			}
			else if('addRule' in sheet) {
				sheet.addRule(selector, rules, ruleIndex);
			}
		}
	};

	ttfmakeDynamicStylesheet.init();
})(jQuery);