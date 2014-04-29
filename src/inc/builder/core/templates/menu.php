<?php
/**
 * @package ttf-one
 */

$class = ( 'c' === get_user_setting( 'ttfonemt' . get_the_ID() ) ) ? 'closed' : 'opened';
?>

<div class="ttf-one-menu ttf-one-menu-<?php echo esc_attr( $class ); ?>" id="ttf-one-menu">
	<div class="ttf-one-menu-pane">
		<ul class="ttf-one-menu-list">
			<?php foreach ( ttf_one_get_sections_by_order() as $key => $item ) : ?>
				<li class="ttf-one-menu-list-item">
					<a href="#" title="<?php esc_attr_e( 'Add', 'make' ); ?>" class="ttf-one-menu-list-item-link" id="ttf-one-menu-list-item-link-<?php echo esc_attr( $item['id'] ); ?>" data-section="<?php echo esc_attr( $item['id'] ); ?>">
						<div class="ttf-one-menu-list-item-link-icon-wrapper clear">
							<span class="ttf-one-menu-list-item-link-icon"></span>
						</div>
						<div class="section-type-description">
							<h4>
								<?php echo esc_html( $item['label'] ); ?>
							</h4>
							<p>
								<?php echo esc_html( $item['description'] ); ?>
							</p>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="ttf-one-menu-tab">
		<a href="#" class="ttf-one-menu-tab-link">
			<span><?php _e( 'Add New Section', 'make' ); ?></span>
		</a>
	</div>
</div>