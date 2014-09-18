/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};

	ttfmakeFormatBuilder.formats.button = ttfmakeFormatBuilder.FormatModel.extend({
		defaults: {
			text: 'Click Here',
			url: '',
			target: false,
			fontSize: '17',
			colorBackground: '#000000',
			colorBackgroundHover: '#e5e5e5',
			colorText: '#ffffff',
			colorTextHover: '#000000',
			paddingHorz: '6',
			paddingVert: '4',
			icon: ''
		},

		initialize: function() {
			var content = ttfmakeFormatBuilder.currentSelection.content || '';
			if ( '' !== content ) {
				this.set({ text: content });
			}
		},

		parseAttributes: function() {
			var node = ttfmakeFormatBuilder.currentSelection.node || {};
			console.log(node);
		},

		getOptionFields: function() {
			var items = [
				{
					type: 'textbox',
					name: 'text',
					label: 'Text',
					value: this.get('text')
				},
				{
					type: 'textbox',
					name: 'url',
					label: 'URL',
					value: this.get('url')
				},
				{
					type: 'checkbox',
					name: 'target',
					label: 'Open link in a new window/tab',
					checked: this.get('target')
				},
				{
					type: 'textbox',
					name: 'fontSize',
					label: 'Font Size (px)',
					value: this.get('fontSize')
				},
				{
					type: 'textbox',
					name: 'colorBackground',
					label: 'Background Color',
					value: this.get('colorBackground')
				},
				{
					type: 'textbox',
					name: 'colorBackgroundHover',
					label: 'Background Color (hover)',
					value: this.get('colorBackgroundHover')
				},
				{
					type: 'textbox',
					name: 'colorText',
					label: 'Text Color',
					value: this.get('colorText')
				},
				{
					type: 'textbox',
					name: 'colorTextHover',
					label: 'Text Color (hover)',
					value: this.get('colorTextHover')
				},
				{
					type: 'textbox',
					name: 'paddingHorz',
					label: 'Horizontal Padding (px)',
					value: this.get('paddingHorz')
				},
				{
					type: 'textbox',
					name: 'paddingVert',
					label: 'Vertical Padding (px)',
					value: this.get('paddingVert')
				},
				{
					type: 'textbox',
					name: 'icon',
					label: 'Icon',
					value: this.get('icon')
				}
			];

			return items;
		},

		sanitizeOptions: function( data ) {
			var self = this;

			$.each(data, function(key, value) {
				if (self.has(key)) {
					var sanitized = self.escAttr(value);
					self.set(key, sanitized);
				}
			});
		},

		getHTML: function() {
			var $button = $('<a>'),
				content;

			$button.attr({
				href: this.get('url'),
				class: 'ttfmake-button',
				'data-hover-background-color': this.get('colorBackgroundHover'),
				'data-hover-color': this.get('colorTextHover')
			});
			if ( 'true' == this.get('target') ) {
				$button.attr('target', '_blank');
			}

			$button.css({
				backgroundColor: this.get('colorBackground'),
				color: this.get('colorText'),
				fontSize: this.get('fontSize') + 'px',
				padding: this.get('paddingVert') + 'px ' + this.get('paddingHorz') + 'px'
			});

			content = this.get('text');
			if ('' !== this.get('icon')) {
				content = this.get('icon') + content;
			}
			$button.text(content);

			return $button.wrap('<p>').parent().html();
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );