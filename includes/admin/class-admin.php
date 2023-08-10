<?php
/**
 * Admin functionality.
 *
 * @package AdvancedAds\Genesis
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.0.0
 */

namespace AdvancedAds\Genesis;

use Advanced_Ads_Admin_Options;
use AdvancedAds\Framework\Interfaces\Integration_Interface;

defined( 'ABSPATH' ) || exit;

/**
 * Admin Class.
 */
class Admin implements Integration_Interface {

	/**
	 * Hook into WordPress.
	 */
	public function hooks() {
		// Add sticky placement.
		add_action( 'advanced-ads-placement-types', [ $this, 'add_placement' ] );

		// Content of sticky placement.
		add_action( 'advanced-ads-placement-options-after', [ $this, 'placement_options' ], 10, 2 );
	}

	/**
	 * Add placement
	 *
	 * @since 1.0.0
	 *
	 * @param array $types Hold placements.
	 *
	 * @return array $types
	 */
	public function add_placement( $types ) {
		$types['genesis'] = [
			'title'       => esc_html__( 'Genesis Positions', 'advanced-ads-genesis' ),
			'description' => esc_html__( 'Various positions for the Genesis theme.', 'advanced-ads-genesis' ),
			'image'       => AAG_BASE_URL . 'assets/img/genesis.png',
			'order'       => 81,
		];

		return $types;
	}

	/**
	 * Options for the placement.
	 *
	 * @since 1.0.0
	 *
	 * @param string $placement_slug Slug of the placement.
	 * @param array  $placement      Current placement.
	 *
	 * @return void
	 */
	public function placement_options( $placement_slug = '', $placement = [] ) {
		// Early bail!!
		if ( 'genesis' !== $placement['type'] ) {
			return;
		}

		$genesis_positions = $this->get_genesis_hooks();
		$current           = $placement['options']['genesis_hook'] ?? '';

		// Warning if no Genesis theme installed.
		if ( ! defined( 'PARENT_THEME_NAME' ) || 'Genesis' !== PARENT_THEME_NAME ) :
			?>
		<p class="advads-error-message">
			<?php echo esc_html__( 'No Genesis theme detected', 'advanced-ads-genesis' ); ?>
		</p>
			<?php
		endif;

		ob_start();
		?>
		<select name="advads[placements][<?php echo esc_attr( $placement_slug ); ?>][options][genesis_hook]">
			<option disabled selected><?php esc_attr_e( 'Select Position', 'advanced-ads-genesis' ); ?></option>
			<?php foreach ( $genesis_positions as $_group => $_positions ) : ?>
				<optgroup label="<?php echo esc_attr( $_group ); ?>">
					<?php foreach ( $_positions as $_position ) : ?>
						<option <?php selected( $_position, $current ); ?>><?php echo esc_html( $_position ); ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
		<?php
		$option_content = ob_get_clean();

		Advanced_Ads_Admin_Options::render_option(
			'placement-genesis-hook',
			__( 'Position', 'advanced-ads-genesis' ),
			$option_content,
			/* translators: URL to Genesis Hook Reference */
			sprintf( __( 'You can find an explanation of the hooks in the <a href="%s" target="_blank">Genesis Hook Reference</a>', 'advanced-ads-genesis' ), 'https://my.studiopress.com/docs/hook-reference/' )
		);
	}

	/**
	 * Get list of genesis hooks.
	 *
	 * @since 1.0.0
	 * @link  https://my.studiopress.com/docs/hook-reference/#structural-action-hooks
	 *
	 * @return array $positions
	 */
	public function get_genesis_hooks() {
		return [
			esc_html__( 'Header', 'advanced-ads-genesis' ) => [
				'before_header',
				'header',
				'after_header',
				'site_title',
				'site_description',
			],
			esc_html__( 'Wrapper', 'advanced-ads-genesis' ) => [
				'before_content_sidebar_wrap',
				'after_content_sidebar_wrap',
				'before_content',
				'after_content',
			],
			esc_html__( 'Sidebar', 'advanced-ads-genesis' ) => [
				'sidebar',
				'before_sidebar_widget_area',
				'after_sidebar_widget_area',
				'sidebar_alt',
				'before_sidebar_alt_widget_area',
				'after_sidebar_alt_widget_area',
			],
			esc_html__( 'Loop', 'advanced-ads-genesis' )   => [
				'before_loop',
				'loop',
				'after_loop',
				'after_endwhile',
				'loop_else',
			],
			esc_html__( 'Content', 'advanced-ads-genesis' ) => [
				'before_entry',
				'after_entry',
				'entry_header',
				'before_entry_content',
				'entry_content',
				'after_entry_content',
				'entry_footer',
				'before_post',
				'after_post',
				'before_post_title',
				'post_title',
				'after_post_title',
				'before_post_content',
				'post_content',
				'after_post_content',
			],
			esc_html__( 'Comments & Pings', 'advanced-ads-genesis' ) => [
				'before_comments',
				'comments',
				'after_comments',
				'list_comments',
				'before_pings',
				'pings',
				'after_pings',
				'list_pings',
				'before_comment',
				'after_comment',
				'before_comment_form',
				'comment_form',
				'after_comment_form',
			],
			esc_html__( 'Footer', 'advanced-ads-genesis' ) => [
				'before_footer',
				'footer',
				'after_footer',
			],
		];
	}
}
