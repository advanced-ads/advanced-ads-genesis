<?php
/**
 * Plugin Name:       Advanced Ads – Genesis
 * Plugin URI:        https://wpadvancedads.com/add-ons/genesis/
 * Description:       Place ads on various positions within Genesis themes
 * Version:           1.0.8
 * Author:            Advanced Ads
 * Author URI:        https://wpadvancedads.com
 * Text Domain:       advanced-ads-genesis
 * Domain Path:       /languages
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package AdvancedAds\Genesis
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.0.0
 */

use AdvancedAds\Genesis\Plugin;

defined( 'ABSPATH' ) || exit;

// Load basic path and url to the plugin.
define( 'AAG_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'AAG_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'AAG_BASE_DIR', dirname( plugin_basename( __FILE__ ) ) );

/**
 * Register autoloader
 */
function advanced_ads_genesis_locate_autoloader() {
	$packages = AAG_BASE_PATH . 'packages/autoload.php';
	$vendors  = AAG_BASE_PATH . 'vendor/autoload.php';

	if ( is_readable( $packages ) ) {
		return $packages;
	}

	return $vendors;
}
require_once advanced_ads_genesis_locate_autoloader();

/**
 * Plugin bootstrap.
 *
 * @return void
 */
function advanced_ads_genesis_init() {
	// Stop, if main plugin doesn’t exist.
	if ( ! class_exists( 'Advanced_Ads', false ) ) {
		Plugin::get()
			->load_plugin_textdomain();

		add_action( 'admin_notices', [ Plugin::get(), 'missing_plugin_notice' ] );
		return;
	}

	// Kick it!!
	Plugin::get()->hooks();
}
add_action( 'plugins_loaded', 'advanced_ads_genesis_init' );
