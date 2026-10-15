<?php
/**
 * Pure helper functions (no WordPress calls), so they can be unit-tested with plain PHP.
 *
 * @package Sinag_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The Business Details fields, in display order.
 *
 * Keys double as the `key` argument of the `sinag-theme/business` binding source.
 *
 * @return array<string, string> key => field type.
 */
function sinag_theme_business_fields() {
	return array(
		'phone'     => 'phone',
		'email'     => 'email',
		'address'   => 'text',
		'hours'     => 'text',
		'messenger' => 'url',
	);
}

/**
 * Keep only characters that belong in a phone number a person typed.
 *
 * "0917 123 4567", "(088) 828-1234" and "+63 917 123 4567" survive; letters and symbols do not.
 *
 * @param string $phone Raw input.
 * @return string
 */
function sinag_theme_clean_phone( $phone ) {
	$phone = preg_replace( '/[^0-9+()\-\s]/', '', (string) $phone );
	$phone = preg_replace( '/\s+/', ' ', $phone );
	return trim( $phone );
}

/**
 * Turn a Philippine phone number into an international tel: link.
 *
 * Rules:
 * - "+63…" is kept as is (digits only after the plus).
 * - "63…" with 12 digits gets a plus.
 * - "09XXXXXXXXX" (11-digit mobile) and "0XX…" landlines drop the leading 0 and gain +63.
 * - Anything else falls back to the bare digits, so the link still works locally.
 *
 * @param string $phone Phone number as typed.
 * @return string tel: URI, or '' if there are no digits.
 */
function sinag_theme_phone_to_tel( $phone ) {
	$phone  = trim( (string) $phone );
	$digits = preg_replace( '/\D/', '', $phone );

	if ( '' === $digits ) {
		return '';
	}

	if ( 0 === strpos( $phone, '+' ) ) {
		return 'tel:+' . $digits;
	}

	if ( 0 === strpos( $digits, '63' ) && 12 === strlen( $digits ) ) {
		return 'tel:+' . $digits;
	}

	if ( 0 === strpos( $digits, '0' ) && strlen( $digits ) >= 9 && strlen( $digits ) <= 11 ) {
		return 'tel:+63' . substr( $digits, 1 );
	}

	return 'tel:' . $digits;
}

/**
 * Accept only http(s) links for the Messenger / chat button.
 *
 * @param string $url Raw URL.
 * @return string The URL, or '' when the scheme is not http or https.
 */
function sinag_theme_is_web_url( $url ) {
	$url    = trim( (string) $url );
	$scheme = strtolower( (string) parse_url( $url, PHP_URL_SCHEME ) );
	return in_array( $scheme, array( 'http', 'https' ), true ) ? $url : '';
}
