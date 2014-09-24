/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};

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
	 * Define the selector for detecting this format in existing content.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.nodes.button = 'a.ttfmake-button';

	/**
	 * The Button format model.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.formats.button = ttfmakeFormatBuilder.FormatModel.extend({
		/**
		 * Default format option values.
		 *
		 * @since 1.4.0.
		 */
		defaults: {
			update: false,
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
			borderRadius: '3',
			icon: ''
		},

		/**
		 * Populate the options with any existing values.
		 *
		 * @since 1.4.0.
		 */
		initialize: function() {
			var content = ttfmakeFormatBuilder.currentSelection.getContent(),
				node = ttfmakeFormatBuilder.currentSelection.getNode();

			if ( '' !== content ) {
				this.set({ text: content });
			}
			if (true === this.get('update')) {
				this.parseAttributes( node );
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
					name: 'text',
					hidden: true,
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
					size: 3,
					value: this.get('fontSize')
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
					value: this.get('paddingHorz')
				},
				{
					type: 'textbox',
					name: 'paddingVert',
					label: 'Vertical Padding (px)',
					size: 3,
					value: this.get('paddingVert')
				},
				{
					type: 'textbox',
					name: 'borderRadius',
					label: 'Border Radius (px)',
					size: 3,
					value: this.get('borderRadius')
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
			var $node = $(node),
				text, icon, fontSize, paddingHorz, paddingVert, borderRadius;

			icon = $node.find( 'i.fa' ).attr( 'class');
			if ( icon ) {
				icon.replace('fa ', '');
				this.set('icon', icon);
			}
			if ( $node.text() ) this.set('text', $node.text());
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
		 * Render the format markup.
		 *
		 * @since 1.4.0.
		 *
		 * @returns string
		 */
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
				padding: this.get('paddingVert') + 'px ' + this.get('paddingHorz') + 'px',
				borderRadius: this.get('borderRadius') + 'px'
			});

			content = this.get('text');
			if ('' !== this.get('icon')) {
				content = '<i class="fa ' + this.get('icon') + '"></i> ' + content;
			}
			$button.html(content);

			return $button.wrap('<p>').parent().html();
		},

		/**
		 * Insert the format markup into the editor.
		 *
		 * @since 1.4.0.
		 */
		insert: function() {
			var html = this.getHTML(),
				parent;

			if ( true === this.get( 'update' ) ) {
				// Make sure we get the right node.
				parent = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.button);

				if (parent) {
					// Select the existing format markup.
					ttfmakeFormatBuilder.currentSelection.select(parent);

					// Replace with the new markup.
					ttfmakeFormatBuilder.currentSelection.setContent(html);
				}
			} else {
				// Insert the new markup.
				ttfmakeFormatBuilder.currentSelection.setContent(html);
			}
		},

		/**
		 * Remove the existing format node.
		 *
		 * @since 1.4.0.
		 */
		remove: function() {
			var parent = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.button),
				content;

			if (parent) {
				// Get the button text
				content = $(parent).text();

				// Select the existing format markup.
				ttfmakeFormatBuilder.currentSelection.select(parent);

				// Remove the markup.
				ttfmakeFormatBuilder.currentSelection.setContent(content.trim());
			}
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );