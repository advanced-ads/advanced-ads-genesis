<?php
/**
 * Frontend functionality.
 *
 * @package AdvancedAds\Genesis
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.0.0
 */

namespace AdvancedAds\Genesis;

use AdvancedAds\Framework\Interfaces\Integration_Interface;

defined( 'ABSPATH' ) || exit;

/**
 * Frontend Class.
 */
class Frontend implements Integration_Interface {

	/**
	 * Hold genesis hooks from placements.
	 *
	 * @var array
	 */
	private $genesis_hooks = null;

	/**
	 * Hook into WordPress.
	 *
	 * @return void
	 */
	public function hooks(): void {
		$hooks = array_keys( $this->get_genesis_hooks() );
		foreach ( $hooks as $hook ) {
			add_action( $hook, [ $this, 'execute_hook' ] );
		}
	}

	/**
	 * Execute genesis hooks
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function execute_hook() {
		$current_hook = current_filter();
		$hooks        = $this->get_genesis_hooks();

		if ( in_array( $current_hook, $hooks, true ) ) {
			the_ad_placement( $hooks[ $current_hook ] );
		}
	}

	/**
	 * Get genesis hooks from placements.
	 *
	 * @return array
	 */
	private function get_genesis_hooks() {
		// Early bail!!
		if ( null !== $this->genesis_hooks ) {
			return $this->genesis_hooks;
		}

		$this->genesis_hooks = [];
		$placements          = get_option( 'advads-ads-placements', [] );

		foreach ( $placements as $placement_id => $placement ) {
			if ( isset( $placement['type'] ) && 'genesis' === $placement['type'] && isset( $placement['options']['genesis_hook'] ) ) {
				$hook = 'genesis_' . $placement['options']['genesis_hook'];

				$this->genesis_hooks[ $hook ] = $placement_id;
			}
		}

		return $this->genesis_hooks;
	}
}
