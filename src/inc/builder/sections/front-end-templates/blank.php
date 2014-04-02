<?php
/**
 * @package ttf-one
 */

global $ttf_one_section_data;
?>

<section class="builder-section <?php echo esc_attr( ttf_one_get_builder_save()->section_classes() ); ?>">
	<?php if ( ! empty( $ttf_one_section_data['title'] ) ) : ?>
	<header class="builder-section-header">
		<h2 class="builder-section-title">
			<?php echo ttf_one_allowed_tags( $ttf_one_section_data['title'] ); ?>
		</h2>
	</header>
	<?php endif; ?>

	<?php if ( ! empty( $ttf_one_section_data['content'] ) ) : ?>
	<div class="builder-section-content">
		<?php ttf_one_get_builder_save()->the_builder_content( $ttf_one_section_data['content'] ); ?>
	</div>
	<?php endif; ?>
</section>
