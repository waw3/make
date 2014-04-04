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
			var atts = this.model.attributes;

			// Begin with default function
			renderFn.apply( this, arguments );

			// Append the template
			this.$el.append( media.template( 'ttf-one-gallery-settings' ) );

			// Set up inputs
			// slider
			media.gallery.defaults.ttf_one_slider = false;
			this.update.apply( this, ['ttf_one_slider'] );
			// utoplay
			media.gallery.defaults.ttf_one_autoplay = false;
			this.update.apply( this, ['ttf_one_autoplay'] );
			// prevnext
			media.gallery.defaults.ttf_one_prevnext = false;
			this.update.apply( this, ['ttf_one_prevnext'] );
			// pager
			media.gallery.defaults.ttf_one_pager = false;
			this.update.apply( this, ['ttf_one_pager'] );
			// transition
			media.gallery.defaults.ttf_one_transition = 4000;
			this.update.apply( this, ['ttf_one_transition'] );

			// Toggle slider settings
			if ('undefined' === typeof atts.ttf_one_slider || false == atts.ttf_one_slider) {
				this.$el.find('#ttf-one-slider-settings').hide();
			}
			this.model.on('change', function() {
				var toggle = $('[data-setting="ttf_one_slider"]').prop('checked'),
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