<?php
/**
 * Genesis placement type.
 *
 * @package AdvancedAds\Pro
 * @author  Advanced Ads <info@wpadvancedads.com>
 */

namespace AdvancedAds\Genesis;

use AdvancedAds\Interfaces\Placement_Type;
use AdvancedAds\Abstracts\Placement_Type as Base;

/**
 * Placement type
 */
class Genesis_Type extends Base implements Placement_Type {
	/**
	 * Get the unique identifier (ID) of the placement type.
	 *
	 * @return string The unique ID of the placement type.
	 */
	public function get_id(): string {
		return 'genesis';
	}

	/**
	 * Get the class name of the object as a string.
	 *
	 * @return string
	 */
	public function get_classname(): string {
		return Genesis_Placement::class;
	}

	/**
	 * Get the title or name of the placement type.
	 *
	 * @return string The title of the placement type.
	 */
	public function get_title(): string {
		return __( 'Genesis Positions', 'advanced-ads-genesis' );
	}

	/**
	 * Get a description of the placement type.
	 *
	 * @return string The description of the placement type.
	 */
	public function get_description(): string {
		return __( 'Various positions for the Genesis theme.', 'advanced-ads-genesis' );
	}

	/**
	 * Check if this placement type requires premium.
	 *
	 * @return bool True if premium is required; otherwise, false.
	 */
	public function is_premium(): bool {
		return false;
	}

	/**
	 * Get the URL for upgrading to this placement type.
	 *
	 * @return string The upgrade URL for the placement type.
	 */
	public function get_image(): string {
		return AA_GENESIS_BASE_URL . 'assets/img/genesis.png';
	}

	/**
	 * Get order number for this placement type.
	 *
	 * @return int The order number.
	 */
	public function get_order(): int {
		return 81;
	}

	/**
	 * Get options for this placement type.
	 *
	 * @return array The options array.
	 */
	public function get_options(): array {
		return $this->apply_filter_on_options( [] );
	}
}
