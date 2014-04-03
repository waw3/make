<?php global $ttf_one_section_data, $ttf_one_is_js_template, $ttf_one_banner_id; ?>
<?php
$section_name = 'ttf-one-section';
if ( true === $ttf_one_is_js_template ) {
	$section_name .= '[{{{ parentID }}}][banner-slides][{{{ id }}}]';
} else {
	$section_name .= '[' . $ttf_one_section_data['data']['id'] . '][banner-slides][' . $ttf_one_banner_id . ']';
}

$title            = ( isset( $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['title'] ) ) ? $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['title'] : '';
$link             = ( isset( $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['link'] ) ) ? $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['link'] : '';
$content          = ( isset( $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['content'] ) ) ? $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['content'] : '';
$background_color = ( isset( $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['background-color'] ) ) ? $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['background-color'] : '#ffffff';
$alignment        = ( isset( $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['alignment'] ) ) ? $ttf_one_section_data['data']['banner-slides'][ $ttf_one_banner_id ]['alignment'] : 'left';
?>