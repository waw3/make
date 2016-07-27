/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	// Ensure property existence
	MakeBuilder.model = MakeBuilder.model || {};
	MakeBuilder.view = MakeBuilder.view || {};
	MakeBuilder.app = MakeBuilder.app || {};

	/**
	 * The Screen model contains data about the state of the Edit screen.
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.model.Screen = Backbone.Model.extend({
		defaults: {
			"state" : "inactive",
			"loaded": false
		},

		/**
		 * Processes data from MakeBuilder.environment
		 *
		 * @since 1.8.0.
		 */
		initialize: function(data) {
			// Show the page builder by default for new posts/pages if the make_builder_is_default filter is set to true
			if ('post-new.php' === data.screenID && true === data.initialState) {
				this.set('state', 'active');
			}
		},

		// Disable unused methods
		fetch: function() {},
		save: function() {},
		sync: function() {}
	});

	/**
	 * The Screen view controls the visibility of the page builder and various other elements. When the
	 * page builder is active, it loads the necessary scripts and kicks things off.
	 *
	 * @since 1.8.0.
	 */
	MakeBuilder.view.Screen = Backbone.View.extend({
		el: '#wpbody-content',

		/**
		 * Cache screen elements, set up listeners, fire initial screen update.
		 *
		 * @since 1.8.0.
		 */
		initialize: function() {
			// Control elements
			this.$pagetoggle = this.$('#page_template');
			this.$posttoggle = this.$('#make-builder-toggle');
			this.$screenoption = this.$('#ttfmake-builder-hide');

			// Toggling elements
			this.$builder = this.$('#ttfmake-builder');
			this.$editor = this.$('#postdivrich');
			this.$welcome = this.$('#make-notice-make-page-builder-welcome');

			// Listeners
			this.listenTo(this.model, "change:state", this.updateScreen);

			// Initial screen update
			this.updateScreen();
		},

		/**
		 * Bind events.
		 *
		 * @since 1.8.0.
		 */
		events: {
			"change #page_template"       : "updateState",
			"change #make-builder-toggle" : "updateState",
			"change #ttfmake-builder-hide": "updateState"
		},

		/**
		 * Update the Screen model's state value based on a triggered event.
		 *
		 * @since 1.8.0.
		 *
		 * @param event
		 */
		updateState: function(event) {
			var $toggle = $(event.target);

			event.preventDefault();
			event.stopPropagation();

			if (this.model.get('builderTemplate') === $toggle.val() || $toggle.is(':checked')) {
				this.model.set('state', 'active');
			} else {
				this.model.set('state', 'inactive');
			}
		},

		/**
		 * Update the screen based on the model's state.
		 *
		 * @since 1.8.0.
		 */
		updateScreen: function() {
			var state = this.model.get('state'),
				loaded = this.model.get('loaded');

			switch(state) {
				case 'active':
					this.toggleBuilder(state);
					if (! loaded) {
						this.loadBuilder();
					}
					break;

				case 'inactive':
					this.toggleBuilder(state);
					break;
			}
		},

		/**
		 * Update elements on the screen based on the state.
		 *
		 * @since 1.8.0.
		 *
		 * @param {string} state
		 */
		toggleBuilder: function(state) {
			switch(state) {
				case 'active':
					this.$editor.hide();
					this.$welcome.show();

					this.$pagetoggle.val(this.model.get('builderTemplate'));
					this.$posttoggle.prop('checked', true);
					this.$screenoption.prop('checked', true).triggerHandler('click');

					break;

				case 'inactive':
					this.$pagetoggle.val(this.model.get('defaultTemplate'));
					this.$posttoggle.prop('checked', false);
					this.$screenoption.prop('checked', false).triggerHandler('click');

					this.$editor.show();
					$(window).trigger('scroll'); // Fix editor layout issues
					this.$welcome.hide();

					break;
			}
		},

		/**
		 * Attempt to load the Builder's script dependencies. Kick off the Builder app if successful.
		 *
		 * @since 1.8.0.
		 */
		loadBuilder: function() {
			var self = this;

			// Show loading indicator
			self.startLoading();

			// Load scripts
			self.getMultipleScripts(MakeBuilder.scripts)
				.always(function() {
					// Update the model to prevent the load routine from running again.
					self.model.set('loaded', true)
				})
				.done(function() {
					self.loadSuccess();
				})
				.fail(function() {
					self.loadFailure();
				});
		},

		/**
		 * Show a loading indicator while the Builder scripts are loading.
		 *
		 * @since 1.8.0.
		 */
		startLoading: function() {
			var $loading = $('<span id="make-builder-loading">').text(MakeBuilder.l10n.loading);
			this.$builder.find('.inside').prepend($loading);
		},

		/**
		 * Hide the loading indicator.
		 *
		 * @since 1.8.0.
		 */
		stopLoading: function() {
			this.$builder.find('#make-builder-loading').remove();
		},

		/**
		 * Callback to kick off the Builder app upon successfully loading dependencies.
		 *
		 * @since 1.8.0.
		 */
		loadSuccess: function() {
			// Remove loading indicator
			this.stopLoading();


		},

		/**
		 * Callback to indicate that dependencies failed to load.
		 *
		 * @since 1.8.0.
		 */
		loadFailure: function() {
			var $message = $('<span>').text(MakeBuilder.l10n.loadFailure);

			// Remove loading indicator
			this.stopLoading();

			// Display message
			this.$builder.find('.inside').prepend($message);
		},

		/**
		 * Load an array of scripts using promises so a callback can be
		 * used when all scripts have finished loading.
		 *
		 * @link https://stackoverflow.com/a/11803418
		 *
		 * @since 1.8.0.
		 *
		 * @param {array} paths
		 * @returns {*|$.Deferred.promise}
		 */
		getMultipleScripts: function(paths) {
			var self = this,
				promises = $.map(paths, function(path) {
					return self.getCachableScript(path);
				});

			// Make sure there is at least one promise
			promises.push( $.Deferred(function(deferred) {
				$(deferred.resolve);
			}) );

			return $.when.apply($, promises);
		},

		/**
		 * Asynchronously load a script from a URL. Unlike $.getScript, this allows a cached
		 * version of the script to be retrieved.
		 *
		 * @link https://github.com/jquery/jquery/blob/373607aa78ce35de10ca12e5bc693a7e375336f9/src/ajax.js#L815-L839
		 *
		 * @since 1.8.0.
		 *
		 * @param {string} url
		 * @param {object} args
		 * @returns {*|$.Deferred.promise}
		 */
		getCachableScript: function(url) {
			var args = {
				url: url,
				type: "get",
				cache: true,
				dataType: "script"
			};

			return $.ajax( $.extend(args, $.isPlainObject(url) && url) );
		}
	});

	/**
	 * Blast off.
	 */
	MakeBuilder.app.screen = new MakeBuilder.view.Screen({
		model: new MakeBuilder.model.Screen( MakeBuilder.environment )
	});
})(jQuery, Backbone, _, wp, MakeBuilder);