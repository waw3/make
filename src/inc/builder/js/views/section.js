/* global Backbone, jQuery, _, wp:true, tinyMCE, switchEditors */
(function (window, Backbone, $, _, oneApp) {
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
			'click .basis-section-toggle': 'toggleSection',
			'click .basis-section-remove': 'removeSection',
			'keyup .basis-section-header-title-input': 'constructHeader',
		},

		initialize: function (options) {
			this.model = options.model;
			this.id = 'basis-section-' + this.model.get('iterator');
			this.serverRendered = ( options.serverRendered ) ? options.serverRendered : false;

			_.templateSettings = {
				evaluate   : /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape     : /\{\{([^\}]+?)\}\}(?!\})/g
			};
			this.template = _.template($('#tmpl-ttf-one-' + this.model.get('sectionType')).html());
		},

		render: function () {
			this.$el.html(this.template(this.model.toJSON())).addClass('ttf-one-section-' + this.model.get('sectionType')).attr('id', this.id);
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
			//BasisBuilderApp.removeSectionsOrder('basis-section-' + this.model.get('iterator'), this.model.get('builder'));

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
		}
	});
})(window, Backbone, jQuery, _, oneApp);