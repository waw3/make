/* global Backbone, jQuery, _, ttfmakeFormatBuilder, ttfmakeFormatBuilderVars */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder, ttfmakeFormatBuilderVars ) {
	'use strict';

	/**
	 * Defines the format parameters to register with the TinyMCE Formatter.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.definitions.alert = {
		block: 'div',
		classes: 'ttfmake-alert',
		wrapper: true
	};

	/**
	 * Define the selector for detecting this format in existing content.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.nodes.alert = 'div.ttfmake-alert';

	/**
	 * Defines the listbox item in the 'Choose a format' dropdown.
	 *
	 * @since 1.4.0.
	 *
	 * @returns object
	 */
	ttfmakeFormatBuilder.choices.alert = function() {
		var content = ttfmakeFormatBuilder.currentSelection.getContent(),
			parent = ttfmakeFormatBuilder.getParentNode('p'),
			choice, isP;

		isP = ($(parent).is('p'));

		choice = {
			value: 'alert',
			text: 'Alert Box',
			disabled: (false === isP && '' == content)
		};

		return choice;
	};

	/**
	 * The Button format model.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};
	ttfmakeFormatBuilder.formats.alert = ttfmakeFormatBuilder.FormatModel.extend({
		/**
		 * Default format option values.
		 *
		 * @since 1.4.0.
		 */
		defaults: {
			update: false,
			id: 0,
			text: '',
			fontSize: ttfmakeFormatBuilderVars.userSettings.fontSizeBody,
			icon: '',
			iconSize: (parseInt(ttfmakeFormatBuilderVars.userSettings.fontSizeBody) * 2) + '',
			colorIcon: '#808080',
			iconPosition: 'left',
			paddingHorz: '20',
			paddingVert: '10',
			borderWidth: '2',
			borderStyle: 'solid',
			colorBorder: '#808080',
			colorBackground: '#e5e5e5',
			colorText: '#808080'
		},

		/**
		 * Populate the options with any existing values.
		 *
		 * @since 1.4.0.
		 */
		initialize: function() {
			var node = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.alert);

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
				ttfmakeFormatBuilder.getColorButton( 'colorBackground', 'Background Color' ),
				ttfmakeFormatBuilder.getColorButton( 'colorText', 'Text Color' ),
				{
					type: 'textbox',
					name: 'fontSize',
					label: 'Font Size (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('fontSize')
				},
				ttfmakeFormatBuilder.getIconButton( 'icon', 'Icon' ),
				{
					type: 'textbox',
					name: 'iconSize',
					label: 'Icon Size (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('iconSize')
				},
				ttfmakeFormatBuilder.getColorButton( 'colorIcon', 'Icon Color' ),
				{
					type: 'listbox',
					name: 'iconPosition',
					label: 'Icon Position',
					value: this.escape('iconPosition'),
					values: [
						{
							text: 'left',
							value: 'left'
						},
						{
							text: 'right',
							value: 'right'
						}
					]
				},
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
					type: 'listbox',
					name: 'borderStyle',
					label: 'Border Style',
					value: this.escape('borderStyle'),
					values: [
						{
							text: 'none',
							value: 'none'
						},
						{
							text: 'solid',
							value: 'solid'
						},
						{
							text: 'dotted',
							value: 'dotted'
						},
						{
							text: 'dashed',
							value: 'dashed'
						},
						{
							text: 'double',
							value: 'double'
						},
						{
							text: 'groove',
							value: 'groove'
						},
						{
							text: 'ridge',
							value: 'ridge'
						},
						{
							text: 'inset',
							value: 'inset'
						},
						{
							text: 'outset',
							value: 'outset'
						}
					]
				},
				{
					type: 'textbox',
					name: 'borderWidth',
					label: 'Border Width (px)',
					size: 3,
					classes: 'monospace',
					value: this.escape('borderWidth')
				},
				ttfmakeFormatBuilder.getColorButton( 'colorBorder', 'Border Color' )
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
		parseAttributes: function(node) {
			var self = this,
				$node = $(node),
				icon, iconClasses, iconSize, iconColor, fontSize, paddingHorz, paddingVert, borderWidth;

			// Get an existing ID.
			if ($node.attr('id')) this.set('id', $node.attr('id'));

			// Parse the icon.
			icon = $node.find('i.ttfmake-alert-icon');
			if ( icon.length > 0 ) {
				iconClasses = icon.attr('class').split(/\s+/);
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						self.set('icon', iconClass);
					} else if (iconClass.match(/^pull-/)) {
						self.set('iconPosition', iconClass.replace('pull-', ''));
					}
				});
				if (icon.css('fontSize')) {
					iconSize = parseInt( icon.css('fontSize') );
					this.set('iconSize', iconSize + ''); // Convert integer to string for TinyMCE
				}
				if (icon.css('color')) {
					iconColor = icon.css('color');
					this.set('colorIcon', iconColor);
				}
			}

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
			if ( $node.css('borderTopStyle') ) this.set('borderStyle', $node.css('borderTopStyle'));
			if ( $node.css('borderTopWidth') ) {
				borderWidth = parseInt( $node.css('borderTopWidth') );
				this.set('borderWidth', borderWidth + ''); // Convert integer to string for TinyMCE
			}
			if ( $node.css('borderTopColor') ) this.set('colorBorder', $node.css('borderTopColor'));
			if ( $node.css('backgroundColor') ) this.set('colorBackground', $node.css('backgroundColor'));
			if ( $node.css('color') ) this.set('colorText', $node.css('color'));
		},

		/**
		 * Insert the format markup into the editor.
		 *
		 * @since 1.4.0.
		 */
		insert: function() {
			var $node, $icon;

			if (true !== this.get('update')) {
				ttfmakeFormatBuilder.editor.formatter.apply('alert');
			}

			$node = $(ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.alert));

			if (! $node.attr('id')) {
				$node.attr('id', this.escape('id'));
			}

			$node.css({
				backgroundColor: this.escape('colorBackground'),
				color: this.escape('colorText'),
				padding: this.escape('paddingVert') + 'px ' + this.escape('paddingHorz') + 'px',
				borderStyle: this.escape('borderStyle'),
				borderWidth: this.escape('borderWidth') + 'px',
				borderColor: this.escape('colorBorder')
			});

			if (this.escape('fontSize') != ttfmakeFormatBuilderVars.userSettings.fontSizeBody) {
				$node.css('fontSize', this.escape('fontSize') + 'px');
			}

			if ('' !== this.get('icon')) {
				// Build the icon.
				$icon = $('<i>');
				$icon.attr('class', 'ttfmake-alert-icon fa ' + this.escape('icon') + ' pull-' + this.escape('iconPosition'));
				$icon.css({
					fontSize: this.escape('iconSize') + 'px',
					color: this.escape('colorIcon')
				});

				// Remove any existing icons.
				$node.find('i.ttfmake-alert-icon').remove();

				// Add the new icon.
				$node.prepend($icon);
			}

			$node.removeAttr('data-mce-style');
		},

		/**
		 * Remove the existing format node.
		 *
		 * @since 1.4.0.
		 */
		remove: function() {
			var node = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.alert),
				content;

			// Remove the icon if it exists.
			$(node).find('i.ttfmake-alert-icon').remove();

			// Get inner content.
			content = $(node).html().trim();

			// Set the selection to the whole node.
			ttfmakeFormatBuilder.currentSelection.select(node);

			// Replace the current selection with the inner content.
			ttfmakeFormatBuilder.currentSelection.setContent(content);
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder, ttfmakeFormatBuilderVars );