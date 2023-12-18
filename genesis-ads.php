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

// Early bail!!
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( defined( 'AAG_FILE' ) ) {
	return;
}

define( 'AAG_FILE', __FILE__ );
define( 'AAG_VERSION', '1.1.0' );

// Load the autoloader.
require_once __DIR__ . '/includes/class-autoloader.php';
\AdvancedAds\Genesis\Autoloader::get()->initialize();

/**
 * Returns the main instance of the plugin.
 *
 * @since 1.1.0
 *
 * @return \AdvancedAds\Genesis\Plugin
 */
function wp_advads_genesis() {
	return \AdvancedAds\Genesis\Plugin::get();
}

// Start it.
add_action( 'advanced-ads-loaded', 'wp_advads_genesis' );
