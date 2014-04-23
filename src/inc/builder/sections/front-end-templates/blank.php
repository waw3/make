<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
?>

<section id="builder-section-<?php echo esc_attr( $ttf_one_section_data['id'] ); ?>" class="builder-section <?php echo esc_attr( ttf_one_get_builder_save()->section_classes( $ttf_one_section_data ) ); ?>">
	<?php if ( ! empty( $ttf_one_section_data['title'] ) ) : ?>
	<header class="builder-section-header">
		<h3 class="builder-section-title">
			<?php echo apply_filters( 'the_title', $ttf_one_section_data['title'] ); ?>
		</h3>
	</header>
	<?php endif; ?>

	<?php if ( ! empty( $ttf_one_section_data['content'] ) ) : ?>
	<div class="builder-section-content">
		<?php if ( '' !== $ttf_one_section_data['content'] ) : ?>
		<div class="builder-blank-content">
			<?php ttf_one_get_builder_save()->the_builder_content( $ttf_one_section_data['content'] ); ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</section>
