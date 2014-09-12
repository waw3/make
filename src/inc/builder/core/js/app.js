/*global jQuery, tinyMCE, switchEditors */
var oneApp = oneApp || {}, ttfMakeFrames = ttfMakeFrames || {};

(function ($, oneApp, ttfMakeFrames) {
	'use strict';

	// Kickoff Backbone App
	new oneApp.MenuView();

	oneApp.options = {
		openSpeed : 400,
		closeSpeed: 250
	};

	oneApp.cache = {
		$sectionOrder: $('#ttfmake-section-order'),
		$scrollHandle: $('html, body'),
		$makeEditor: $('#wp-make-wrap'),
		$makeTextArea: $('#make')
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
				var $item = $(ui.item.get(0)),
					$frames = $('iframe', $item);

				oneApp.setOrder( $(this).sortable('toArray', {attribute: 'data-id'}), oneApp.cache.$sectionOrder );

				$.each($frames, function() {
					var id = $(this).attr('id').replace('ttfmake-iframe-', '');
					oneApp.initFrame(id);
				});
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
			iframeBody = $('body', iframeContent),
			content;

		content = oneApp.getMakeContent();

		// Since content is being displayed in the iframe, run it through autop
		content = switchEditors.wpautop(content);

		iframeBody.html(content);
	};

	oneApp.setTextArea = function (textAreaID) {
		$('#' + textAreaID).val(oneApp.getMakeContent());
	};

	oneApp.getMakeContent = function () {
		var content = '';

		if (oneApp.isVisualActive()) {
			content = tinyMCE.get('make').getContent();
			console.log(content);
		} else {
			content = oneApp.cache.$makeTextArea.val();
		}

		return content;
	};

	oneApp.setMakeContent = function (content) {
		if (oneApp.isVisualActive()) {
			tinyMCE.get('make').setContent(content);
		} else {
			oneApp.cache.$makeTextArea.val(switchEditors.pre_wpautop(content));
		}
	};

	oneApp.setMakeContentFromTextArea = function (iframeID, textAreaID) {
		var textAreaContent = $('#' + textAreaID).val();

		oneApp.setActiveiframeID(iframeID);
		oneApp.setActiveTextAreaID(textAreaID);
		oneApp.setMakeContent(textAreaContent);
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

	oneApp.isTextActive = function() {
		return oneApp.cache.$makeEditor.hasClass('html-active');
	};

	oneApp.isVisualActive = function() {
		return oneApp.cache.$makeEditor.hasClass('tmce-active');
	};

	oneApp.initFrames = function() {
		if (ttfMakeFrames.length > 0) {
			var link = oneApp.getFrameHeadLinks();

			// Add content and CSS
			_.each(ttfMakeFrames, function(id) {
				oneApp.initFrame(id, link);
			});
		}
	};

	oneApp.initFrame = function(id, link) {
		var content = $('#ttfmake-content-' + id).val(),
			iframe = document.getElementById('ttfmake-iframe-' + id),
			iframeContent = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document,
			iframeHead = $('head', iframeContent),
			iframeBody = $('body', iframeContent);

		link = link || oneApp.getFrameHeadLinks();

		iframeHead.html(link);
		iframeBody.html(switchEditors.wpautop(content));
	};

	oneApp.getFrameHeadLinks = function() {
		var scripts = tinyMCEPreInit.mceInit.make.content_css.split(','),
			link = '';

		// Create the CSS links for the head
		_.each(scripts, function(e) {
			link += '<link type="text/css" rel="stylesheet" href="' + e + '" />';
		});

		return link;
	};

	oneApp.triggerInitFrames = function() {
		$(document).ready(function(){
			oneApp.initFrames();
		});
	};

	oneApp.initSortables();
	oneApp.initViews();
	oneApp.triggerInitFrames();
})(jQuery, oneApp, ttfMakeFrames);