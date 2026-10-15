<?php
/**
 * Business Details: one screen (Appearance → Business Details) that stores the
 * phone, email, address, hours line and Messenger link, plus a Block Bindings
 * source (`sinag-theme/business`) that prints them inside paragraphs, headings
 * and buttons. Change the phone once and every pattern updates.
 *
 * @package Sinag_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SINAG_THEME_OPTION = 'sinag_theme_business';

/**
 * Saved values merged over empty defaults.
 *
 * @return array<string, string>
 */
function sinag_theme_get_business() {
	$saved    = get_option( SINAG_THEME_OPTION, array() );
	$defaults = array_fill_keys( array_keys( sinag_theme_business_fields() ), '' );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Sanitize the whole option array. Unknown keys are dropped.
 *
 * @param mixed $input Raw $_POST data passed by the Settings API.
 * @return array<string, string>
 */
function sinag_theme_sanitize_business( $input ) {
	$input = is_array( $input ) ? $input : array();
	$clean = array();

	foreach ( sinag_theme_business_fields() as $key => $type ) {
		$value = isset( $input[ $key ] ) ? wp_unslash( $input[ $key ] ) : '';

		switch ( $type ) {
			case 'phone':
				$clean[ $key ] = sinag_theme_clean_phone( sanitize_text_field( $value ) );
				break;
			case 'email':
				$clean[ $key ] = sanitize_email( $value );
				break;
			case 'url':
				$clean[ $key ] = esc_url_raw( sinag_theme_is_web_url( $value ) );
				break;
			default:
				$clean[ $key ] = sanitize_text_field( $value );
		}
	}

	return $clean;
}

/**
 * Register the option with the Settings API (this also gives us the nonce).
 */
function sinag_theme_register_business_setting() {
	register_setting(
		'sinag_theme_business_group',
		SINAG_THEME_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'sinag_theme_sanitize_business',
			'default'           => array(),
			'show_in_rest'      => false,
		)
	);
}
add_action( 'admin_init', 'sinag_theme_register_business_setting' );

/**
 * Add Appearance → Business Details.
 */
function sinag_theme_add_business_page() {
	add_theme_page(
		__( 'Business Details', 'sinag-theme' ),
		__( 'Business Details', 'sinag-theme' ),
		'edit_theme_options',
		'sinag-business-details',
		'sinag_theme_render_business_page'
	);
}
add_action( 'admin_menu', 'sinag_theme_add_business_page' );

/**
 * Field labels and help text.
 *
 * @return array<string, array{0:string,1:string}>
 */
function sinag_theme_business_labels() {
	return array(
		'phone'     => array( __( 'Phone', 'sinag-theme' ), __( 'Shown as typed. The Call button converts it to +63 automatically.', 'sinag-theme' ) ),
		'email'     => array( __( 'Email', 'sinag-theme' ), __( 'Public contact email.', 'sinag-theme' ) ),
		'address'   => array( __( 'Address', 'sinag-theme' ), __( 'Street, barangay, city or municipality, province.', 'sinag-theme' ) ),
		'hours'     => array( __( 'Hours (one line)', 'sinag-theme' ), __( 'Example: Mon–Sat 7:00 AM – 6:00 PM · Sun closed', 'sinag-theme' ) ),
		'messenger' => array( __( 'Messenger or chat link', 'sinag-theme' ), __( 'Any https:// link, such as your page\'s m.me link or a booking form.', 'sinag-theme' ) ),
	);
}

/**
 * Render the settings screen.
 */
function sinag_theme_render_business_page() {
	if ( ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}

	$values = sinag_theme_get_business();
	$labels = sinag_theme_business_labels();
	$types  = sinag_theme_business_fields();
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'These details appear in the header, footer and every Sinag pattern that is connected to them. Leave a field empty to show the pattern\'s sample text instead.', 'sinag-theme' ); ?></p>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php settings_fields( 'sinag_theme_business_group' ); ?>
			<table class="form-table" role="presentation">
				<?php foreach ( $types as $key => $type ) : ?>
					<?php
					$id         = 'sinag-' . $key;
					$input_type = 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : ( 'phone' === $type ? 'tel' : 'text' ) );
					?>
					<tr>
						<th scope="row"><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $labels[ $key ][0] ); ?></label></th>
						<td>
							<input
								type="<?php echo esc_attr( $input_type ); ?>"
								id="<?php echo esc_attr( $id ); ?>"
								name="<?php echo esc_attr( SINAG_THEME_OPTION . '[' . $key . ']' ); ?>"
								value="<?php echo esc_attr( $values[ $key ] ); ?>"
								class="regular-text"
								aria-describedby="<?php echo esc_attr( $id . '-help' ); ?>"
							/>
							<p class="description" id="<?php echo esc_attr( $id . '-help' ); ?>"><?php echo esc_html( $labels[ $key ][1] ); ?></p>
						</td>
					</tr>
				<?php endforeach; ?>
			</table>
			<?php submit_button( __( 'Save details', 'sinag-theme' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Value for one binding.
 *
 * Supported keys: phone, phone_link, email, email_link, address, hours, messenger.
 * Returning null tells WordPress to keep the block's own (sample) content.
 *
 * @param array    $source_args    Arguments from the block's metadata.bindings (expects `key`).
 * @param WP_Block $block_instance The block being rendered (unused).
 * @param string   $attribute_name The bound attribute, e.g. `content`, `url`, `text`.
 * @return string|null
 */
function sinag_theme_business_binding_value( $source_args, $block_instance, $attribute_name ) {
	unset( $block_instance );

	$key  = isset( $source_args['key'] ) ? sanitize_key( $source_args['key'] ) : '';
	$data = sinag_theme_get_business();

	switch ( $key ) {
		case 'phone_link':
			$value = sinag_theme_phone_to_tel( $data['phone'] );
			break;
		case 'email_link':
			$value = $data['email'] ? 'mailto:' . $data['email'] : '';
			break;
		default:
			$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
	}

	if ( '' === $value ) {
		return null;
	}

	// URL attributes are encoded by the HTML API when written; rich-text content is inserted as HTML.
	if ( in_array( $attribute_name, array( 'url', 'href' ), true ) ) {
		return 0 === strpos( $value, 'tel:' ) || 0 === strpos( $value, 'mailto:' ) ? $value : esc_url_raw( $value );
	}

	return esc_html( $value );
}

/**
 * Register the binding source (WordPress 6.5+).
 */
function sinag_theme_register_binding_source() {
	if ( ! function_exists( 'register_block_bindings_source' ) ) {
		return;
	}

	register_block_bindings_source(
		'sinag-theme/business',
		array(
			'label'              => __( 'Business Details', 'sinag-theme' ),
			'get_value_callback' => 'sinag_theme_business_binding_value',
		)
	);
}
add_action( 'init', 'sinag_theme_register_binding_source' );
