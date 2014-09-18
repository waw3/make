/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};

	ttfmakeFormatBuilder.formats.button = ttfmakeFormatBuilder.FormatModel.extend({
		defaults: {
			text: 'Click Here',
			url: '',
			target: 0,
			colorBackground: '#000000',
			colorBackgroundHover: '#e5e5e5',
			colorText: '#ffffff',
			colorTextHover: '#000000',
			icon: ''
		},

		initialize: function() {

		},

		parseAttributes: function() {

		},

		getOptionFields: function() {
			var items = [
				{
					type: 'textbox',
					name: 'buttonText',
					label: 'Text',
					value: this.get('text')
				},
				{
					type: 'textbox',
					name: 'buttonUrl',
					label: 'URL',
					value: this.get('url')
				},
				{
					type: 'checkbox',
					name: 'buttonTarget',
					label: 'Open link in a new window/tab',
					value: this.get('target')
				},
				{
					type: 'textbox',
					name: 'buttonColorBackground',
					label: 'Background Color',
					value: this.get('colorBackground')
				},
				{
					type: 'textbox',
					name: 'buttonColorBackgroundHover',
					label: 'Background Color (hover)',
					value: this.get('colorBackgroundHover')
				},
				{
					type: 'textbox',
					name: 'buttonColorText',
					label: 'Text Color',
					value: this.get('colorText')
				},
				{
					type: 'textbox',
					name: 'buttonColorTextHover',
					label: 'Text Color (hover)',
					value: this.get('colorTextHover')
				},
				{
					type: 'textbox',
					name: 'buttonIcon',
					label: 'Icon',
					value: this.get('icon')
				}
			];

			return items;
		},

		getHTML: function() {

		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );