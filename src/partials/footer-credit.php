<?php
/**
 * @package ttf-one
 */

$footer_text = ttf_one_sanitize_text( get_theme_mod( 'footer-text', ttf_one_get_default( 'footer-text' ) ) );

if ( $footer_text ) : ?>
<div class="footer-text">
	<?php echo ttf_one_sanitize_text( $footer_text ); ?>
</div>
<?php endif; ?>

<div class="site-info">
	<?php // Footer credit
	printf(
		__( '%s theme', 'make' ),
		'<span class="theme-name">One</span>'
	);
	?>
	<span class="theme-by"><?php _ex( 'by', 'attribution', 'make' ); ?></span>
	<span class="theme-author">
		<a title="The Theme Foundry <?php esc_attr_e( 'homepage', 'make' ); ?>" href="https://thethemefoundry.com/">
			The Theme Foundry
		</a>
	</span>
</div>