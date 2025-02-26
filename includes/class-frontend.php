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
		add_action( 'init', [ $this, 'find_genesis_hooks' ], 30 );
	}

	/**
	 * Execute genesis hooks
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function execute_hook() {
		$current_hook = current_filter();
		$hooks        = $this->find_genesis_hooks();

		if ( in_array( $current_hook, array_keys( $hooks ), true ) ) {
			foreach ( $hooks[ $current_hook ] as $id ) {
				the_ad_placement( $id );
			}
		}
	}

	/**
	 * Get genesis hooks from placements.
	 *
	 * @return array
	 */
	public function find_genesis_hooks() {
		// Early bail!!
		if ( null !== $this->genesis_hooks ) {
			return $this->genesis_hooks;
		}

		$this->genesis_hooks = [];
		$placements          = wp_advads_get_placements_by_types( 'genesis' );

		foreach ( $placements as $id => $placement ) {
			$hook = $placement->get_prop( 'genesis_hook' );
			if ( ! $hook ) {
				continue;
			}

			$hook = "genesis_$hook";

			if ( ! isset( $this->genesis_hooks[ $hook ] ) ) {
				$this->genesis_hooks[ $hook ] = [];
			}

			$this->genesis_hooks[ $hook ] [] = $id;

			if ( 2 > count( $this->genesis_hooks[ $hook ] ) ) {
				add_action( $hook, [ $this, 'execute_hook' ] );
			}
		}

		return $this->genesis_hooks;
	}
}
