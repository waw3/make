/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.FormatModel = Backbone.Model.extend({
		defaults: {},

		initialize: function() {},

		getOptionFields: function() {},

		parseAttributes: function() {},

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

		getHTML: function() {},

		insert: function() {},

		remove: function() {},

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