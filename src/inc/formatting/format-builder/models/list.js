/* global Backbone, jQuery, _ */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function ( window, Backbone, $, _, ttfmakeFormatBuilder ) {
	'use strict';

	/**
	 * Defines the format parameters to register with the TinyMCE Formatter.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.definitions.list = {
		selector: 'ul',
		classes: 'ttfmake-list'
	};

	/**
	 * Define the selector for detecting this format in existing content.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.nodes.list = 'ul.ttfmake-list';

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
	 * The Button format model.
	 *
	 * @since 1.4.0.
	 */
	ttfmakeFormatBuilder.formats = ttfmakeFormatBuilder.formats || {};
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
			var node = ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list);

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
		parseAttributes: function(node) {
			var self = this,
				$node = $(node),
				iconClasses;

			if ($node.attr('id')) this.set('id', $node.attr('id'));

			iconClasses = $node.find('li').first().attr('class').split(/\s+/);
			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/) && ! iconClass.match(/fa-li/)) {
						self.set('icon', iconClass);
						return false;
					}
				});
			}

			if ($node.attr('data-icon-color')) this.set('colorIcon', $node.attr('data-icon-color'));
		},

		/**
		 * Insert the format markup into the editor.
		 *
		 * @since 1.4.0.
		 */
		insert: function() {
			var $node, iconClasses;

			if ('' == this.escape('icon')) {
				return;
			}

			if (true !== this.get('update')) {
				ttfmakeFormatBuilder.editor.formatter.apply('list');
			}

			$node = $(ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list));

			if (! $node.attr('id')) {
				$node.attr('id', this.escape('id'));
			}

			$node.attr('data-icon-color', this.escape('colorIcon'));

			iconClasses = $node.find('li').first().attr('class').split(/\s+/);
			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						$node.find('li').removeClass(iconClass);
					}
				});
			}
			$node.find('li').addClass(this.escape('icon'));
		},

		/**
		 * Remove the existing format node.
		 *
		 * @since 1.4.0.
		 */
		remove: function() {
			var $node = $(ttfmakeFormatBuilder.getParentNode(ttfmakeFormatBuilder.nodes.list)),
				listID = $node.attr('id'),
				iconClasses = $node.find('li').first().attr('class').split(/\s+/);

			if (listID.match(/^ttfmake-/)) {
				$node.removeAttr('id');
			}
			$node.removeClass('ttfmake-list');
			$node.removeAttr('data-icon-color');

			if (iconClasses) {
				$.each(iconClasses, function(index, iconClass) {
					if (iconClass.match(/^fa-/)) {
						$node.find('li').removeClass(iconClass);
					}
				});
			}
		}
	});
})( window, Backbone, jQuery, _, ttfmakeFormatBuilder );