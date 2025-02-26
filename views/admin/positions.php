<?php
/**
 * Position setting.
 *
 * @package AdvancedAds\Pro
 * @author  Advanced Ads <info@wpadvancedads.com>
 *
 * @var array  $genesis_positions list of genesis hooks.
 * @var string $current           selected hook
 */

use AdvancedAds\Utilities\WordPress;

?>
<?php if ( ! defined( 'PARENT_THEME_NAME' ) || 'Genesis' !== PARENT_THEME_NAME ) : ?>
	<p class="advads-error-message">
		<?php echo esc_html__( 'No Genesis theme detected', 'advanced-ads-genesis' ); ?>
	</p>
<?php endif; ?>
<?php ob_start(); ?>
	<label>
		<select name="advads[placements][options][genesis_hook]">
			<option disabled selected><?php esc_attr_e( 'Select Position', 'advanced-ads-genesis' ); ?></option>
			<?php foreach ( $genesis_positions as $group => $positions ) : ?>
				<optgroup label="<?php echo esc_attr( $group ); ?>">
					<?php foreach ( $positions as $position ) : ?>
						<option <?php selected( $position, $current ); ?>><?php echo esc_html( $position ); ?></option>
					<?php endforeach; ?>
				</optgroup>
			<?php endforeach; ?>
		</select>
	</label>
<?php
$option_content = ob_get_clean();

WordPress::render_option(
	'placement-genesis-hook',
	__( 'Position', 'advanced-ads-genesis' ),
	$option_content,
	/* translators: URL to Genesis Hook Reference */
	sprintf( __( 'You can find an explanation of the hooks in the <a href="%s" target="_blank">Genesis Hook Reference</a>', 'advanced-ads-genesis' ), 'https://my.studiopress.com/docs/hook-reference/' )
);
