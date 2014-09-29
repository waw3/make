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
	ttfmakeFormatBuilder.choices.list = function() {
		var parent = ttfmakeFormatBuilder.getParentNode('ul'),
			choice, isUL;

		isUL = ( $(parent).is('ul') );

		choice = {
			value: 'list',
			text: 'List',
			disabled: (false === isUL)
		};

		return choice;
	};

	/**
	 * Define the selector for detecting this format in existing content.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.nodes.list = 'ul.ttfmake-list';

	/**
	 * The Button format model.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.formats.list = ttfmakeFormatBuilder.FormatModel.extend({
		/**
		 * Default format option values.
		 *
		 * @since 1.4.0.
		 */
		defaults: {
			update: false,
			id: 0,
			icon: '',
			colorIcon: '#808080'
		},

		/**
		 * Populate the options with any existing values.
		 *
		 * @since 1.4.0.
		 */
		initialize: function() {
			var node = ttfmakeFormatBuilder.currentSelection.getNode();

			this.set('id', this.createID());

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
				ttfmakeFormatBuilder.getIconButton( 'icon', 'Icon' ),
				ttfmakeFormatBuilder.getColorButton( 'colorIcon', 'Icon Color' )
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
				$node = $(ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list)),
				iconClasses;

			if ( $node.attr('id') ) this.set('id', $node.attr('id'));

			iconClasses = $node.find('li').first().attr('class').split(/\s+/);
			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/) && ! iconClass.match(/fa-li/)) {
						self.set('icon', iconClass);
					}
				});
			}

			if ( $node.attr('data-icon-color') ) this.set('colorIcon', $node.attr('data-icon-color'));
		},

		/**
		 * Insert the format markup into the editor.
		 *
		 * @since 1.4.0.
		 */
		insert: function() {
			var parent,
				iconClasses;

			if ('' == this.escape('icon')) {
				return;
			}

			if ( true === this.get( 'update' ) ) {
				// Make sure we get the right node.
				parent = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list);
			} else {
				// Make sure we get the right node.
				parent = ttfmakeFormatBuilder.getParentNode('ul');
			}

			if (! $(parent).attr('id')) {
				$(parent).attr('id', this.escape('id'));
			}
			$(parent).addClass('ttfmake-list');
			$(parent).attr('data-icon-color', this.escape('colorIcon'));

			iconClasses = $(parent).find('li').first().attr('class').split(/\s+/);
			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						$(parent).find('li').removeClass(iconClass);
					}
				});
			}
			$(parent).find('li').addClass(this.escape('icon'));
		},

		/**
		 * Remove the existing format node.
		 *
		 * @since 1.4.0.
		 */
		remove: function() {
			var parent = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list),
				listID = $(parent).attr('id'),
				iconClasses = $(parent).find('li').first().attr('class').split(/\s+/);

			if (listID.match(/^ttfmake-/)) {
				$(parent).removeAttr('id');
			}
			$(parent).removeClass('ttfmake-list');
			$(parent).removeAttr('data-icon-color');

			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						$(parent).find('li').removeClass(iconClass);
					}
				});
			}
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );