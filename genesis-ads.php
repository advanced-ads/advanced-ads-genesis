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

define( 'AAG_FILE', __FILE__ );
define( 'AAG_VERSION', '1.0.9' );
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

/**
 * Halt code remove with new release.
 *
 * @return void
 */
function wp_advads_genesis_halt_code() {
	global $advads_halt_notices;

	// Early bail!!
	if ( ! defined( 'ADVADS_VERSION' ) ) {
		return;
	}

	if ( version_compare( ADVADS_VERSION, '2.0.0', '>=' ) ) {
		if ( ! isset( $advads_halt_notices ) ) {
			$advads_halt_notices = [];
		}
		$advads_halt_notices[] = __( 'Advanced Ads – Genesis', 'advanced-ads-genesis' );

		add_action(
			'all_admin_notices',
			static function () {
				global $advads_halt_notices;

				// Early bail!!
				if ( 'plugins' === get_current_screen()->base || empty( $advads_halt_notices ) ) {
					return;
				}
				?>
				<div class="notice notice-error">
					<h2><?php esc_html_e( 'Important Notice', 'advanced-ads-genesis' ); ?></h2>
					<p>
						<?php
						echo wp_kses_post(
							sprintf(
								/* translators: %s: Plugin name */
								__( 'Your versions of the Advanced Ads addons listed below are incompatible with <strong>Advanced Ads 2.0</strong> and have been deactivated. Please update them to their latest version. If you cannot update, e.g., due to an expired license, you can <a href="%1$s">roll back to a compatible version of the Advanced Ads plugin</a> at any time or <a href="%2$s">renew your license</a>.', 'advanced-ads-genesis' ),
								esc_url( admin_url( 'admin.php?page=advanced-ads-tools&sub_page=version' ) ),
								'https://wpadvancedads.com/account/#h-licenses'
							)
						)
						?>
					</p>
					<h3><?php esc_html_e( 'The following addons are affected:', 'advanced-ads-genesis' ); ?></h3>
					<ul>
						<?php foreach ( $advads_halt_notices as $notice ) : ?>
							<li><strong><?php echo esc_html( $notice ); ?></strong></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php
				$advads_halt_notices = [];
			}
		);

		add_action(
			'after_plugin_row_' . plugin_basename( __FILE__ ),
			static function () {
				echo '<tr class="active"><td colspan="5" class="plugin-update colspanchange">';
				wp_admin_notice(
					sprintf(
						/* translators: %s: Plugin name */
						__( 'Your version of <strong>Advanced Ads – Genesis</strong> is incompatible with <strong>Advanced Ads 2.0</strong> and has been deactivated. Please update the plugin to the latest version. If you cannot update the plugin, e.g., due to an expired license, you can <a href="%1$s">roll back to a compatible version of the Advanced Ads plugin</a> at any time or <a href="%2$s">renew your license</a>.', 'advanced-ads-pro' ),
						esc_url( admin_url( 'admin.php?page=advanced-ads-tools&sub_page=version' ) ),
						'https://wpadvancedads.com/account/#h-licenses'
					),
					[
						'type'               => 'error',
						'additional_classes' => array( 'notice-alt', 'inline', 'update-message' ),
					]
				);
				echo '</td></tr>';
			}
		);
		return;
	}

	// Autoload and activate.
	add_action( 'plugins_loaded', 'advanced_ads_genesis_init' );
}

add_action( 'plugins_loaded', 'wp_advads_genesis_halt_code', 5 );
