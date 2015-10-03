<?php
/**
 * @package Make
 */

/**
 * Interface TTFMAKE_Util_Compatibility_CompatibilityInterface
 *
 * @since x.x.x.
 */
interface TTFMAKE_Util_Compatibility_CompatibilityInterface extends TTFMAKE_Util_LoadInterface {
	public function deprecated_function();

	public function deprecated_filter();
}