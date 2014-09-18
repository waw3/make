/* global jQuery, ttfmakeFormatBuilder */
var ttfmakeFormatBuilder = ttfmakeFormatBuilder || {};

( function( $ ) {
	var formatWindow;

	ttfmakeFormatBuilder = {
		formats: {},
		nodes: {},
		currentFormat: {},
		currentSelection: {},

		open: function( editor ) {
			this.currentSelection.node = editor.selection.getNode();
			this.currentSelection.selection = editor.selection.getSel();
			this.currentSelection.content = editor.selection.getContent();

			var format = this.parseNode( editor, this.currentSelection.node),
				items;

			if ('' == format) {
				items = [
					{
						type: 'form',
						name: 'listboxForm',
						items: ttfmakeFormatBuilder.getFormatListBox()
					}
				]
			} else if ('undefined' !== typeof ttfmakeFormatBuilder.formats[format]) {
				ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[format]({ update: true });
				items = [
					{
						type: 'form',
						name: 'optionsForm',
						items: ttfmakeFormatBuilder.currentFormat.getOptionFields()
					}
				]
			}

			formatWindow = editor.windowManager.open( {
				title: 'Format Builder',
				autoScroll: true,
				width: 400,
				height: 400,
				items: {
					type: 'container',
					name: 'formatContainer',
					layout: 'flow',
					align: 'stretch',
					padding: 5,
					spacing: 10,
					items: items
				},
				buttons: {
					text: 'Insert',
					name: 'formatSubmit',
					onclick: function() {
						if ('undefined' === typeof formatWindow.find('#optionsForm')[0]) {
							return;
						}

						var data = formatWindow.find('#optionsForm')[0].toJSON(),
							html;

						ttfmakeFormatBuilder.currentFormat.sanitizeOptions(data);
						html = ttfmakeFormatBuilder.currentFormat.getHTML(data);

						editor.insertContent(html);
						formatWindow.fire('submit');
					}
				},
				onclose: function() {
					ttfmakeFormatBuilder.currentFormat = {};
					ttfmakeFormatBuilder.currentSelection = {};
				}
			} );

		},


		parseNode: function( editor, node ) {
			var format = '';

			$.each(this.nodes, function( fmt, selector ) {
				var match = editor.dom.getParents( node, selector );
				if ( match.length > 0 ) {
					format = fmt;
					return false;
				}
			});

			return format;
		},


		getFormatListBox: function() {
			var listbox = {
				type: 'listbox',
				name: 'format',
				label: 'Choose a format',
				id: 'ttfmake-format-builder-picker',
				values: this.getFormatChoices(),
				onselect: function() {
					var choice = this.value(),
						fields = {
							type: 'form',
							name: 'optionsForm'
						};

					if ('undefined' !== typeof ttfmakeFormatBuilder.formats[choice]) {
						ttfmakeFormatBuilder.currentFormat = new ttfmakeFormatBuilder.formats[choice];

						fields.items = ttfmakeFormatBuilder.currentFormat.getOptionFields();
						formatWindow.find('#optionsForm').remove();
						formatWindow.find('#formatContainer')[0].append(fields).reflow();
						formatWindow.repaint();
					}
				}
			};

			return listbox;
		},


		getFormatChoices: function() {
			var choices = [
				{ value: '', text: '--- Formats ---', selected: 'selected', disabled: 'disabled' },
				{ value: 'button', text: 'Button' }
			];

			return choices;
		}
	};
})( jQuery );