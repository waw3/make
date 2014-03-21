<?php

global $ttf_one_section_data; ?>
<section class="product-section basis-list <?php echo esc_attr( ttf_one_get_builder_save()->section_classes() ); ?>">
	<?php if ( ! empty( $ttf_one_section_data['title'] ) ) : ?>
		<h3 class="text-section-title"><?php echo ttf_one_allowed_tags( $ttf_one_section_data['title'] ); ?></h3>
	<?php endif; ?>

	<?php if ( ! empty( $ttf_one_section_data['content'] ) ) : ?>
		<?php ttf_one_get_builder_save()->the_builder_content( $ttf_one_section_data['content'] ); ?>
	<?php endif; ?>
</section>