<?php
/**
 * The plugin bootstrap.
 *
 * @package AdvancedAds\Genesis
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.0.0
 */

namespace AdvancedAds\Genesis;

use AdvancedAds\Framework\Loader;

defined( 'ABSPATH' ) || exit;

/**
 * Load common and WordPress based resources
 *
 * @since 1.0.0
 */
class Plugin extends Loader {

	/**
	 * Main instance
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return Plugin
	 */
	public static function get(): Plugin {
		static $instance;

		if ( null === $instance ) {
			$instance = new Plugin();
			$instance->setup();
		}

		return $instance;
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version(): string {
		return AAG_VERSION;
	}

	/**
	 * Bootstrap plugin.
	 *
	 * @return void
	 */
	private function setup(): void {
		$this->define_constants();
		$this->includes();

		add_action( 'init', [ $this, 'load_textdomain' ] );
		$this->load();
	}

	/**
	 * Define Advanced Ads constant
	 *
	 * @return void
	 */
	private function define_constants(): void {
		$this->define( 'AA_GENESIS_ABSPATH', dirname( AAG_FILE ) . '/' );
		$this->define( 'AA_GENESIS_BASENAME', plugin_basename( AAG_FILE ) );
		$this->define( 'AA_GENESIS_BASE_URL', plugin_dir_url( AAG_FILE ) );
		$this->define( 'AA_GENESIS_SLUG', 'advanced-ads-genesis' );

		// Deprecated Constants.
		/**
		 * AAG_BASE_PATH
		 *
		 * @deprecated 1.1.0 use AA_GENESIS_ABSPATH now.
		 */
		define( 'AAG_BASE_PATH', AA_GENESIS_ABSPATH );

		/**
		 * AAG_BASE_URL
		 *
		 * @deprecated 1.1.0 use AA_GENESIS_BASE_URL now.
		 */
		define( 'AAG_BASE_URL', AA_GENESIS_BASE_URL );
	}

	/**
	 * Includes core files used in admin and on the frontend.
	 *
	 * @return void
	 */
	private function includes(): void {
		if ( is_admin() && ! wp_doing_ajax() ) {
			$this->register_integration( Admin::class );
		} else {
			$this->register_integration( Frontend::class );
		}
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_textdomain(): void {
		$locale = determine_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'advanced-ads-genesis' );

		unload_textdomain( 'advanced-ads-genesis' );
		if ( false === load_textdomain( 'advanced-ads-genesis', WP_LANG_DIR . '/plugins/advanced-ads-genesis-' . $locale . '.mo' ) ) {
			load_textdomain( 'advanced-ads-genesis', WP_LANG_DIR . '/advanced-ads-genesis/advanced-ads-genesis-' . $locale . '.mo' );
		}
		load_plugin_textdomain( 'advanced-ads-genesis', false, dirname( AA_GENESIS_BASENAME ) . '/languages' );
	}
}
