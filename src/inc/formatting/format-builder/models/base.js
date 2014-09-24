/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.FormatModel = Backbone.Model.extend({
		defaults: {},

		initialize: function() {},

		getOptionFields: function() {},

		parseAttributes: function() {},

		getHTML: function() {},

		insert: function() {},

		remove: function() {},

		/**
		 * Wrap each control in a customized form item.
		 *
		 * This is way harder than it should be. :/
		 *
		 * @since 1.4.0.
		 *
		 * @param fields
		 * @returns {Array}
		 */
		wrapOptionFields: function(fields) {
			var wrapped = [],
				label, item,
				spacer = {
					type: 'spacer'
				};

			$.each(fields, function(index, field) {
				label = {
					type: 'label',
					text: field.label,
					style: 'float: left; line-height: 30px;'
				};
				item = {
					type: 'formitem',
					layout: 'stack',
					minWidth: 300,
					maxHeight: 50,
					border: '0 0 1 0',
					style: 'border-color: #e5e5e5; border-style: solid;',
					hidden: (true === field.hidden),
					defaults: {
						style: 'float: right; text-align: right;'
					},
					items: [
						label,
						field
					]
				};
				wrapped.push(item);
				wrapped.push(spacer);
			});

			return wrapped;
		},

		/**
		 * Sanitize incoming form values and store them in the model.
		 *
		 * @since 1.4.0.
		 *
		 * @param data
		 */
		sanitizeOptions: function( data ) {
			var self = this;

			$.each(data, function(key, value) {
				if (self.has(key)) {
					var sanitized = self.escAttr(value);
					self.set(key, sanitized);
				}
			});
		},

		/**
		 * Sanitize an input for output as an HTML attribute.
		 *
		 * @since 1.4.0.
		 *
		 * @link http://stackoverflow.com/a/9756789/719811
		 *
		 * @param s
		 * @param preserveCR
		 * @returns {string}
		 */
		escAttr: function(s, preserveCR) {
			preserveCR = preserveCR ? '&#13;' : '\n';
			return ('' + s) /* Forces the conversion to string. */
				.replace(/&/g, '&amp;') /* This MUST be the 1st replacement. */
				.replace(/'/g, '&apos;') /* The 4 other predefined entities, required. */
				.replace(/"/g, '&quot;')
				.replace(/</g, '&lt;')
				.replace(/>/g, '&gt;')
				.replace(/\r\n/g, preserveCR) /* Must be before the next replacement. */
				.replace(/[\r\n]/g, preserveCR);
		}
	});

	// Set up this model as a "no URL model" where data is not synced with the server
	ttfmakeFormatBuilder.FormatModel.prototype.sync  = function () { return null; };
	ttfmakeFormatBuilder.FormatModel.prototype.fetch = function () { return null; };
	ttfmakeFormatBuilder.FormatModel.prototype.save  = function () { return null; };
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );