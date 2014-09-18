/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.FormatModel = Backbone.Model.extend({
		defaults: {},

		initialize: function () {},

		getOptionFields: {}
	});

	// Set up this model as a "no URL model" where data is not synced with the server
	ttfmakeFormatBuilder.FormatModel.prototype.sync  = function () { return null; };
	ttfmakeFormatBuilder.FormatModel.prototype.fetch = function () { return null; };
	ttfmakeFormatBuilder.FormatModel.prototype.save  = function () { return null; };
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );