<?php
/**
 * Plugin functionality.
 *
 * @package AdvancedAds\Genesis
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.0.0
 */

namespace AdvancedAds\Genesis;

use AdvancedAds\Framework\Interfaces\WordPress_Integration;

defined( 'ABSPATH' ) || exit;

/**
 * Load common and WordPress based resources
 *
 * @since 1.0.0
 */
class Plugin implements WordPress_Integration {

	/**
	 * Main instance
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return Plugin
	 */
	public static function get() {
		static $instance;

		if ( null === $instance ) {
			$instance = new Plugin();
		}

		return $instance;
	}

	/**
	 * Hook into WordPress.
	 */
	public function hooks() {
		$this->init();
		$this->load_plugin_textdomain();
	}

	/**
	 * Initialize plugin.
	 *
	 * @return void
	 */
	public function init() {
		if ( is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			( new Admin() )->hooks();
		} else {
			( new Frontend() )->hooks();
		}
	}

	/**
	 * Load Localisation files
	 *
	 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
	 *
	 * Locales found in:
	 *      - WP_LANG_DIR/advanced-ads-genesis/advanced-ads-genesis-LOCALE.mo
	 *      - WP_LANG_DIR/plugins/advanced-ads-genesis-LOCALE.mo
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = determine_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'advanced-ads-genesis' );

		unload_textdomain( 'advanced-ads-genesis' );
		load_textdomain( 'advanced-ads-genesis', WP_LANG_DIR . '/advanced-ads-genesis/advanced-ads-genesis-' . $locale . '.mo' );
		load_plugin_textdomain( 'advanced-ads-genesis', false, AAG_BASE_DIR . '/i18n/languages' );
	}

	/**
	 * Show notice if Advanced Ads is not activated.
	 *
	 * @return void
	 */
	public function missing_plugin_notice() {
		$plugins = get_plugins();

		$link  = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=advanced-ads' ), 'install-plugin_advanced-ads' );
		$label = __( 'Install Now', 'advanced-ads-genesis' );

		// Installed but not active.
		if ( isset( $plugins['advanced-ads/advanced-ads.php'] ) ) {
			$link  = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=advanced-ads/advanced-ads.php&amp', 'activate-plugin_advanced-ads/advanced-ads.php' );
			$label = __( 'Activate Now', 'advanced-ads-genesis' );
		}
		?>
		<div class="error">
			<p>
				<?php echo wp_kses_post( '<strong>Genesis Ads</strong> requires the <strong><a href="https://wpadvancedads.com/#utm_source=advanced-ads&utm_medium=link&utm_campaign=activate-genesis" target="_blank">Advanced Ads</a></strong> plugin to be installed and activated on your site.', 'advanced-ads-genesis' ); ?>
				<a class="button button-primary" href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $label ); ?></a>
			</p>
		</div>
		<?php
	}
}

