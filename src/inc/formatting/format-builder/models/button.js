/* global Backbone, jQuery, _, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	/**
	 * Defines the format parameters to register with the TinyMCE Formatter.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.definitions.button = {
		inline: 'a',
		classes: 'ttfmake-button'
	};

	/**
	 * Define the selector for detecting this format in existing content.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.nodes.button = 'a.ttfmake-button';

	/**
	 * Defines the listbox item in the 'Choose a format' dropdown.
	 *
	 * @since 1.4.0.
	 *
	 * @returns object
	 */
	ttfmakeFormatBuilder.choices.button = function() {
		var content = ttfmakeFormatBuilder.currentSelection.getContent(),
			choice;

		choice = {
			value: 'button',
			text: 'Button',
			disabled: ( '' == content )
		};

		return choice;
	};

	/**
	 * The Button format model.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};
	ttfmakeFormatBuilder.formats.button = ttfmakeFormatBuilder.FormatModel.extend({
		/**
		 * Default format option values.
		 *
		 * @since 1.4.0.
		 */
		defaults: {
			update: false,
			id: 0,
			url: '',
			target: false,
			fontSize: '17',
			colorBackground: '#000000',
			colorBackgroundHover: '#e5e5e5',
			colorText: '#ffffff',
			colorTextHover: '#000000',
			paddingHorz: '6',
			paddingVert: '4',
			borderRadius: '3',
			icon: ''
		},

		/**
		 * Populate the options with any existing values.
		 *
		 * @since 1.4.0.
		 */
		initialize: function() {
			var node = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.button);

			this.set('id', this.createID());

			if (true === this.get('update')) {
				this.parseAttributes(node);
			}
		},

		/**
		 * Defines the fields in the options form.
		 *
		 * @since 1.4.0.
		 *
		 * @returns array
		 */
		getOptionFields: function() {
			var items = [
				{
					type: 'textbox',
					name: 'url',
					label: 'URL',
					classes: 'monospace',
					value: this.escape('url')
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
					size: 3,
					classes: 'monospace',
					value: this.escape('fontSize')
				},
				ttfmakeFormatBuilder.getColorButton( 'colorBackground', 'Background Color' ),
				ttfmakeFormatBuilder.getColorButton( 'colorBackgroundHover', 'Background Color (hover)' ),
				ttfmakeFormatBuilder.getColorButton( 'colorText', 'Text Color' ),
				ttfmakeFormatBuilder.getColorButton( 'colorTextHover', 'Text Color (hover)' ),
				{
					type: 'textbox',
					name: 'paddingHorz',
					label: 'Horizontal Padding (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('paddingHorz')
				},
				{
					type: 'textbox',
					name: 'paddingVert',
					label: 'Vertical Padding (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('paddingVert')
				},
				{
					type: 'textbox',
					name: 'borderRadius',
					label: 'Border Radius (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('borderRadius')
				},
				ttfmakeFormatBuilder.getIconButton( 'icon', 'Icon' )
			];

			return this.wrapOptionFields(items);
		},

		/**
		 * Parse an existing format node and extract its format options.
		 *
		 * @since 1.4.0.
		 *
		 * @param node
		 */
		parseAttributes: function( node ) {
			var self = this,
				$node = $(node),
				icon, iconClasses, fontSize, paddingHorz, paddingVert, borderRadius;

			if ( $node.attr('id') ) this.set('id', $node.attr('id'));

			icon = $node.find('i.ttfmake-button-icon');
			if (icon.length > 0) {
				iconClasses = icon.attr('class').split(/\s+/);
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						self.set('icon', iconClass);
						return false;
					}
				});
			}

			if ( $node.attr('href') ) this.set('url', $node.attr('href'));
			if ( $node.attr('data-hover-background-color') ) this.set('colorBackgroundHover', $node.attr('data-hover-background-color'));
			if ( $node.attr('data-hover-color') ) this.set('colorTextHover', $node.attr('data-hover-color'));
			if ( '_blank' === $node.attr('target') ) this.set('target', true);
			if ( $node.css('backgroundColor') ) this.set('colorBackground', $node.css('backgroundColor'));
			if ( $node.css('color') ) this.set('colorText', $node.css('color'));
			if ( $node.css('fontSize') ) {
				fontSize = parseInt( $node.css('fontSize') );
				this.set('fontSize', fontSize + ''); // Convert integer to string for TinyMCE
			}
			if ( $node.css('paddingLeft') ) {
				paddingHorz = parseInt( $node.css('paddingLeft') );
				this.set('paddingHorz', paddingHorz + ''); // Convert integer to string for TinyMCE
			}
			if ( $node.css('paddingTop') ) {
				paddingVert = parseInt( $node.css('paddingTop') );
				this.set('paddingVert', paddingVert + ''); // Convert integer to string for TinyMCE
			}
			if ( $node.css('borderTopLeftRadius') ) {
				borderRadius = parseInt( $node.css('borderTopLeftRadius') );
				this.set('borderRadius', borderRadius + ''); // Convert integer to string for TinyMCE
			}
		},

		/**
		 * Insert the format markup into the editor.
		 *
		 * @since 1.4.0.
		 */
		insert: function() {
			var $node, $icon;

			if (true !== this.get('update')) {
				ttfmakeFormatBuilder.editor.formatter.apply('button');
			}

			$node = $(ttfmakeFormatBuilder.currentSelection.getNode());
			if (! $node.is(ttfmakeFormatBuilder.nodes.button)) {
				$node = $node.find(ttfmakeFormatBuilder.nodes.button);
			}

			if (! $node.attr('id')) {
				$node.attr('id', this.escape('id'));
			}

			$node.attr({
				href: this.escape('url'),
				'data-hover-background-color': this.escape('colorBackgroundHover'),
				'data-hover-color': this.escape('colorTextHover')
			});
			if ( 'true' == this.get('target') ) {
				$node.attr('target', '_blank');
			}

			$node.css({
				backgroundColor: this.escape('colorBackground'),
				color: this.escape('colorText'),
				fontSize: this.escape('fontSize') + 'px',
				padding: this.escape('paddingVert') + 'px ' + this.escape('paddingHorz') + 'px',
				borderRadius: this.escape('borderRadius') + 'px'
			});

			if ('' !== this.get('icon')) {
				// Build the icon.
				$icon = $('<i>');
				$icon.attr('class', 'ttfmake-button-icon fa ' + this.escape('icon'));

				// Remove any existing icons.
				$node.find('i.ttfmake-button-icon').remove();

				// Add the new icon.
				$node.prepend($icon);
			}
		},

		/**
		 * Remove the existing format node.
		 *
		 * @since 1.4.0.
		 */
		remove: function() {
			var node = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.button),
				content;

			// Remove the icon if it exists.
			$(node).find('i.ttfmake-button-icon').remove();

			// Get inner content.
			content = $(node).html().trim();

			// Set the selection to the whole node.
			ttfmakeFormatBuilder.currentSelection.select(node);

			// Replace the current selection with the inner content.
			ttfmakeFormatBuilder.currentSelection.setContent(content);
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );