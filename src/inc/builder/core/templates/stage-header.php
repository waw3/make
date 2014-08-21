<?php
/**
 * @package Make
 */

global $ttfmake_sections;
?>

<div class="ttfmake-stage<?php if ( empty( $ttfmake_sections ) ) echo ' ttfmake-stage-closed'?>" id="ttfmake-stage">
	<?php do_action( 'make_before_builder_stage' );