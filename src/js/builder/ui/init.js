/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	MakeBuilder = $.extend(MakeBuilder, {
		/**
		 *
		 *
		 * @since 1.8.0.
		 */
		cache: {
			$document: $(document),
			$builder : $('#ttfmake-builder'),
			$menu    : $('#ttfmake-menu'),
			$stage   : $('#ttfmake-stage')
		},

		/**
		 *
		 *
		 * @since 1.8.0.
		 */
		init: function() {
			var self = this;

			//
			self.cache.$document.ready(function() {
				// Show loading indicator
				self.startLoading();

				// Load scripts
				self.getMultipleScripts(self.scripts)
					.done(function() {
						self.loadSuccess(self);
					})
					.fail(function() {
						self.loadFailure(self);
					});
			});
		},

		/**
		 *
		 *
		 * @since 1.8.0.
		 */
		startLoading: function() {
			var self = this,
				$loading = $('<span id="make-builder-loading">').text(self.l10n.loading);

			self.cache.$builder.find('.inside').prepend($loading);
		},

		/**
		 *
		 *
		 * @since 1.8.0.
		 */
		stopLoading: function() {
			var self = this;

			self.cache.$builder.find('#make-builder-loading').remove();
		},

		/**
		 *
		 *
		 * @since 1.8.0.
		 *
		 * @param self
		 */
		loadSuccess: function(self) {
			// Remove loading indicator
			self.stopLoading();


		},

		/**
		 *
		 *
		 * @since 1.8.0.
		 *
		 * @param self
		 */
		loadFailure: function(self) {
			var $message = $('<span>').text(self.l10n.loadFailure);

			// Remove loading indicator
			self.stopLoading();

			// Display message
			self.cache.$builder.find('.inside').prepend($message);
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
			promises.push($.Deferred(function(deferred) {
				$(deferred.resolve);
			}));

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

	MakeBuilder.init();
})(jQuery, Backbone, _, wp, MakeBuilder);