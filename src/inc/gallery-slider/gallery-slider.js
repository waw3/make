/*!
 * Script for adding functionality to the Create Gallery view.
 *
 * @since 1.0.0
 */

(function($){
	var media = wp.media,
		renderFn = media.view.Settings.Gallery.prototype.render;

	media.view.Settings.Gallery = media.view.Settings.Gallery.extend({
		render: function() {
			var self = this,
				atts = self.model.attributes;

			// Begin with default function
			renderFn.apply( this, arguments );

			// Append the template
			this.$el.append( media.template( 'ttf-one-gallery-settings' ) );

			// Set up inputs
			// slider
			media.gallery.defaults.ttf_one_slider = false;
			this.update.apply( this, ['ttf_one_slider'] );
			// Autoplay
			media.gallery.defaults.ttf_one_autoplay = false;
			this.update.apply( this, ['ttf_one_autoplay'] );
			// prevnext
			media.gallery.defaults.ttf_one_prevnext = false;
			this.update.apply( this, ['ttf_one_prevnext'] );
			// pager
			media.gallery.defaults.ttf_one_pager = false;
			this.update.apply( this, ['ttf_one_pager'] );
			// delay
			media.gallery.defaults.ttf_one_delay = 6000;
			if ('undefined' === typeof this.model.attributes.ttf_one_delay) {
				this.model.attributes.ttf_one_delay = media.gallery.defaults.ttf_one_delay;
			}
			this.update.apply( this, ['ttf_one_delay'] );
			// effect
			media.gallery.defaults.ttf_one_effect = 'scrollHorz';
			this.update.apply( this, ['ttf_one_effect'] );

			// Toggle slider settings
			if ('undefined' === typeof atts.ttf_one_slider || false == atts.ttf_one_slider) {
				this.$el.find('#ttf-one-slider-settings').hide();
			}
			this.model.on('change', function(t) {
				// Only proceed if the slider toggle changed
				if ('undefined' === typeof this.changed.ttf_one_slider) {
					return;
				}

				var toggle = this.changed.ttf_one_slider,
					$settingsDiv = $('#ttf-one-slider-settings');

				if ( true === toggle ) {
					$settingsDiv.show();
				} else {
					$settingsDiv.hide();
				}
			});

			return this;
		}
	});
}(jQuery));