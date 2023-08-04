<?php
/**
 * Plugin Name:       Advanced Ads – Genesis
 * Plugin URI:        https://wpadvancedads.com/add-ons/genesis/
 * Description:       Place ads on various positions within Genesis themes
 * Version:           1.0.9
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

require_once 'vendor/autoload.php';

// Early bail!!
if ( class_exists( 'Advanced_Ads_Genesis_Plugin' ) ) {
	return;
}

// Load basic path and url to the plugin.
define( 'AAG_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'AAG_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'AAG_BASE_DIR', dirname( plugin_basename( __FILE__ ) ) ); // Directory of the plugin without any paths.

// Plugin slug and textdomain.
define( 'AAG_SLUG', 'advanced-ads-genesis' );
define( 'AAG_VERSION', '1.0.9' );
define( 'AAG_PLUGIN_URL', 'https://wpadvancedads.com' );
define( 'AAG_PLUGIN_NAME', 'Genesis Ads' );

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
