/*global jQuery, tinyMCE, switchEditors */
var oneApp = oneApp || {};

(function ($, oneApp) {
	'use strict';

	// Kickoff Backbone App
	new oneApp.MenuView();

	oneApp.options = {
		openSpeed : 400,
		closeSpeed: 250
	};

	oneApp.cache = {
		$sectionOrder: $('#ttfmake-section-order'),
		$scrollHandle: $('html, body')
	};

	oneApp.initSortables = function () {
		$('.ttfmake-stage').sortable({
			handle: '.ttfmake-section-header',
			placeholder: 'sortable-placeholder',
			forcePlaceholderSizeType: true,
			distance: 2,
			tolerance: 'pointer',
			start: function (event, ui) {
				// Set the height of the placeholder to that of the sorted item
				var $item = $(ui.item.get(0)),
					$stage = $item.parents('.ttfmake-stage');

				$('.sortable-placeholder', $stage).height($item.height());
			},
			stop: function (event, ui) {
				var $item = $(ui.item.get(0));

				oneApp.setOrder( $(this).sortable('toArray', {attribute: 'data-id'}), oneApp.cache.$sectionOrder );
			}
		});
	};

	oneApp.setOrder = function (order, $input) {
		// Use a comma separated list
		order = order.join();

		// Set the val of the input
		$input.val(order);
	};

	oneApp.addOrderValue = function (id, $input) {
		var currentOrder = $input.val(),
			currentOrderArray;

		if ('' === currentOrder) {
			currentOrderArray = [id];
		} else {
			currentOrderArray = currentOrder.split(',');
			currentOrderArray.push(id);
		}

		oneApp.setOrder(currentOrderArray, $input);
	};

	oneApp.removeOrderValue = function (id, $input) {
		var currentOrder = $input.val(),
			currentOrderArray;

		if ('' === currentOrder) {
			currentOrderArray = [];
		} else {
			currentOrderArray = currentOrder.split(',');
			currentOrderArray = _.reject(currentOrderArray, function (item) {
				return parseInt(id, 10) === parseInt(item, 10);
			});
		}

		oneApp.setOrder(currentOrderArray, $input);
	};

	oneApp.initViews = function () {
		$('.ttfmake-section').each(function () {
			var $section = $(this),
				idAttr = $section.attr('id'),
				id = $section.attr('data-id'),
				sectionType = $section.attr('data-section-type'),
				sectionModel, modelViewName, view, viewName;

			// Build the model
			sectionModel = new oneApp.SectionModel({
				sectionType: sectionType,
				id: id
			});

			// Ensure that a view exists for the section, otherwise use the base view
			modelViewName = sectionModel.get('viewName') + 'View';
			viewName      = (true === oneApp.hasOwnProperty(modelViewName)) ? modelViewName : 'SectionView';

			// Create view
			view = new oneApp[viewName]({
				model: sectionModel,
				el: $('#' + idAttr),
				serverRendered: true
			});
		});
	};

	oneApp.scrollToAddedView = function (view) {
		// Scroll to the new section
		oneApp.cache.$scrollHandle.animate({
			scrollTop: parseInt($('#' + view.idAttr).offset().top, 10) - 32 - 9 // Offset + admin bar height + margin
		}, 800, 'easeOutQuad', function() {
			oneApp.focusFirstInput(view);
		});
	};

	oneApp.focusFirstInput = function (view) {
		$('input[type="text"]', view.$el).not('.wp-color-picker').first().focus();
	};

	oneApp.filliframe = function (iframeID) {
		var iframe = document.getElementById(iframeID),
			iframeContent = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document,
			iframeBody = $('body', iframeContent);

		iframeBody.html(oneApp.getMakeContent());
	};

	oneApp.setTextArea = function (textAreaID) {
		$('#' + textAreaID).val(oneApp.getMakeContent());
	};

	oneApp.getMakeContent = function () {
		return tinyMCE.get('make').getContent();
	};

	oneApp.setMakeContent = function (content) {
		tinyMCE.get('make').setContent(content);
	};

	oneApp.setMakeContentFromiframe = function (iframeID, textAreaID) {
		var iframe = document.getElementById(iframeID),
			iframeContent = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document,
			iframeBody = $('body', iframeContent);

		oneApp.setMakeContent(iframeBody.html());
		oneApp.setActiveiframeID(iframeID);
		oneApp.setActiveTextAreaID(textAreaID);
	};

	oneApp.setActiveiframeID = function(iframeID) {
		oneApp.activeiframeID = iframeID;
	};

	oneApp.setActiveTextAreaID = function(textAreaID) {
		oneApp.activeTextAreaID = textAreaID;
	};

	oneApp.getActiveiframeID = function() {
		if (oneApp.hasOwnProperty('activeiframeID')) {
			return oneApp.activeiframeID;
		} else {
			return '';
		}
	};

	oneApp.getActiveTextAreaID = function() {
		if (oneApp.hasOwnProperty('activeTextAreaID')) {
			return oneApp.activeTextAreaID;
		} else {
			return '';
		}
	};

	oneApp.initSortables();
	oneApp.initViews();
})(jQuery, oneApp);