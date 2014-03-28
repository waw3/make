/* global Backbone, jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, Backbone, $, _, oneApp, $oneApp) {
	'use strict';

	oneApp.GalleryItems = Backbone.Collection.extend({
		model: oneApp.GalleryItem,
		$stage: $('#ttf-one-stage')
	});
})(window, Backbone, jQuery, _, oneApp, $oneApp);