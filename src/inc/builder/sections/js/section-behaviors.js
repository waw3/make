/* global jQuery, _ */
var oneApp = oneApp || {}, $oneApp = $oneApp || jQuery(oneApp);

(function (window, $, _, oneApp) {
	'use strict';

	$oneApp.on('viewInit', function(evt, view){
		var sectionType = view.model.get('sectionType');

		// Append the additional event to the view
		view.events = _.extend(view.events, {
			'click .ttf-one-gallery-add-item a': 'addItem'
		});

		// Append the needed function to the view
		view.addItem = function(evt){
			evt.preventDefault();
		}
	});
})(window, jQuery, _, oneApp);