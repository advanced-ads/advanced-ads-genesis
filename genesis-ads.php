<?php
/**
 * Advanced Ads – Genesis
 *
 * @package   AdvancedAds
 * @author    Advanced Ads GmbH <support@wpadvancedads.com>
 * @license   GPL-2.0+
 * @link      https://wpadvancedads.com
 * @copyright since 2013 Advanced Ads GmbH
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Ads – Genesis
 * Plugin URI:        https://wpadvancedads.com/add-ons/genesis/
 * Description:       Place ads on various positions within Genesis themes
 * Version:           1.1.0
 * Author:            Advanced Ads GmbH
 * Author URI:        https://wpadvancedads.com
 * Text Domain:       advanced-ads-genesis
 * Domain Path:       /languages
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 */

use AdvancedAds\Genesis\Plugin;

// Early bail!!
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( defined( 'AAG_FILE' ) ) {
	return;
}

define( 'AAG_FILE', AAG_FILE );
define( 'AAG_VERSION', '2.6.0' );

// Load basic path and url to the plugin.
define( 'AAG_BASE_PATH', plugin_dir_path( AAG_FILE ) );
define( 'AAG_BASE_URL', plugin_dir_url( AAG_FILE ) );
define( 'AAG_BASE_DIR', dirname( plugin_basename( AAG_FILE ) ) );

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
