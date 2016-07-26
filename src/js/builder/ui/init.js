/**
 *
 */

/* global jQuery, Backbone, _, wp, MakeBuilder */

var MakeBuilder = MakeBuilder || {};

(function($, Backbone, _, wp, MakeBuilder) {
	'use strict';

	MakeBuilder = $.extend(MakeBuilder, {

		cache: {
			$document: $(document),
			$builder: $('#ttfmake-builder'),
			$menu: $('#ttfmake-menu'),
			$stage: $('#ttfmake-stage')
		},


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


		startLoading: function() {
			var self = this,
				$loading = $('<span id="make-builder-loading">').text(self.l10n.loading);

			self.cache.$builder.find('.inside').prepend($loading);
		},


		stopLoading: function() {
			var self = this;

			self.cache.$builder.find('#make-builder-loading').remove();
		},


		loadSuccess: function(self) {
			console.log('DONE');

			// Remove loading indicator
			self.stopLoading();
		},


		loadFailure: function(self) {
			console.log('FAIL');

			var $message = $('<span>').text(self.l10n.loadFailure);

			// Remove loading indicator
			self.stopLoading();

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
					//return self.getCachableScript(path);
					return $.getScript(path);
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
		 * @link https://api.jquery.com/jquery.getscript/
		 *
		 * @since 1.8.0.
		 *
		 * @param {string} url
		 * @param {object} args
		 * @returns {*|$.Deferred.promise}
		 */
		getCachableScript: function(url, args) {
			 $.extend(args || {}, {
				url: url,
				cache: true,
				dataType: 'script'
			});

			return $.ajax(args);
		}
	});

	MakeBuilder.init();
})(jQuery, Backbone, _, wp, MakeBuilder);