/* global Backbone, jQuery, _, wp:true, tinyMCE, switchEditors */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, Backbone, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.SectionView = Backbone.View.extend({
		template: '',
		className: 'ttf-one-section ttf-one-section-open',
		$headerTitle: '',
		$titleInput: '',
		$titlePipe: '',
		serverRendered: false,
		$document: $(window.document),

		events: {
			'click .ttf-one-section-toggle': 'toggleSection',
			'click .ttf-one-section-remove': 'removeSection',
			'keyup .ttf-one-section-header-title-input': 'constructHeader',
			'click .ttf-one-media-uploader-add': 'initUploader',
			'click .ttf-one-media-uploader-remove': 'removeImage',
			'click .wp-switch-editor': 'adjustEditorHeightOnClick'
		},

		initialize: function (options) {
			this.model = options.model;
			this.idAttr = 'ttf-one-section-' + this.model.get('id');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;

			// Allow custom init functions
			$(oneApp).trigger('viewInit', this);

			_.templateSettings = {
				evaluate   : /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape     : /\{\{([^\}]+?)\}\}(?!\})/g
			};
			this.template = _.template($('#tmpl-ttf-one-' + this.model.get('sectionType')).html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON()))
				.addClass('ttf-one-section-' + this.model.get('sectionType'))
				.attr('id', this.idAttr)
				.attr('data-id', this.model.get('id'))
				.attr('data-section-type', this.model.get('sectionType'));
			return this;
		},

		toggleSection: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$section = $this.parents('.ttf-one-section'),
				$sectionBody = $('.ttf-one-section-body', $section),
				$input = $('.ttf-one-section-state', this.$el);

			if ($section.hasClass('ttf-one-section-open')) {
				$sectionBody.slideUp(oneApp.options.closeSpeed, function() {
					$section.removeClass('ttf-one-section-open');
					$input.val('closed');
				});
			} else {
				$sectionBody.slideDown(oneApp.options.openSpeed, function() {
					$section.addClass('ttf-one-section-open');
					$input.val('open');
				});
			}
		},

		removeSection: function (evt) {
			evt.preventDefault();
			oneApp.removeOrderValue(this.model.get('id'), oneApp.cache.$sectionOrder);

			// Fade and slide out the section, then cleanup view and reset stage on complete
			this.$el.animate({
				opacity: 'toggle',
				height: 'toggle'
			}, oneApp.options.closeSpeed, function() {
				this.remove();
				oneApp.sections.toggleStageClass();
			}.bind(this));
		},

		constructHeader: function () {
			if ('' === this.$headerTitle) {
				this.$headerTitle = $('.ttf-one-section-header-title', this.$el);
			}

			if ('' === this.$titleInput) {
				this.$titleInput = $('.ttf-one-section-header-title-input', this.$el);
			}

			if ('' === this.$titlePipe) {
				this.$titlePipe = $('.ttf-one-section-header-pipe', this.$el);
			}

			var input = this.$titleInput.val();

			// Set the input
			this.$headerTitle.html(_.escape(input));

			// Hide or show the pipe depending on what content is available
			if ('' === input) {
				this.$titlePipe.addClass('ttf-one-section-header-pipe-hidden');
			} else {
				this.$titlePipe.removeClass('ttf-one-section-header-pipe-hidden');
			}
		},

		initUploader: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$parent = $this.parents('.ttf-one-uploader'),
				$placeholder = $('.ttf-one-media-uploader-placeholder', $parent),
				$input = $('.ttf-one-media-uploader-value', $parent),
				$remove = $('.ttf-one-media-uploader-remove', $parent),
				$add = $('.ttf-one-media-uploader-set-link', $parent);

			var frame = frame || {};

			// If the media frame already exists, reopen it.
			if ('function' === typeof frame.open) {
				frame.open();
				return;
			}

			// Create the media frame.
			frame = wp.media.frames.frame = wp.media({
				title: $this.data('title'),
				button: {
					text: $this.data('buttonText')
				},
				multiple: false
			});

			// When an image is selected, run a callback.
			frame.on('select', function () {
				// We set multiple to false so only get one image from the uploader
				var attachment = frame.state().get('selection').first().toJSON();

				// Remove the attachment caption
				attachment.caption = '';

				// Build the image
				var props = wp.media.string.props(
					{},
					attachment
				);

				// The URL property is blank, so complete it
				props.url = attachment.url;

				var image = wp.media.string.image( props );

				// Show the image
				$placeholder.html(image);

				// Record the chosen value
				$input.val(attachment.id);

				// Hide the link to set the image
				$add.hide();

				// Show the remove link
				$remove.show();
			});

			// Finally, open the modal
			frame.open();
		},

		removeImage: function (evt) {
			evt.preventDefault();

			var $this = $(evt.target),
				$parent = $this.parents('.ttf-one-uploader'),
				$placeholder = $('.ttf-one-media-uploader-placeholder', $parent),
				$input = $('.ttf-one-media-uploader-value', $parent),
				$set = $('.ttf-one-media-uploader-add', $parent);

			// Remove the image
			$placeholder.empty();

			// Remove the value from the input
			$input.removeAttr('value');

			// Hide the remove link
			$this.hide();

			// Show the set link
			$set.show();
		},

		adjustEditorHeightOnClick: function (evt) {
			oneApp.adjustEditorHeightOnClick(evt);
		}
	});
})(window, Backbone, jQuery, _, oneApp, $oneApp);