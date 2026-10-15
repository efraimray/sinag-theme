<?php
/**
 * Plain-PHP tests for inc/helpers.php. Run: php tests/test-helpers.php
 *
 * @package Sinag_Theme
 */

define( 'ABSPATH', __DIR__ . '/' );
require __DIR__ . '/../inc/helpers.php';

$cases = array(
	array( 'sinag_theme_phone_to_tel', '0917 123 4567', 'tel:+639171234567' ),
	array( 'sinag_theme_phone_to_tel', '+63 917 123 4567', 'tel:+639171234567' ),
	array( 'sinag_theme_phone_to_tel', '639171234567', 'tel:+639171234567' ),
	array( 'sinag_theme_phone_to_tel', '(088) 828-1234', 'tel:+63888281234' ),
	array( 'sinag_theme_phone_to_tel', '8828-1234', 'tel:88281234' ),
	array( 'sinag_theme_phone_to_tel', 'call us!', '' ),
	array( 'sinag_theme_clean_phone', "0917<script>123</script>  4567", '0917123 4567' ),
	array( 'sinag_theme_clean_phone', '  +63 (88)  828-1234 ', '+63 (88) 828-1234' ),
	array( 'sinag_theme_is_web_url', 'https://m.me/kapehansaburol', 'https://m.me/kapehansaburol' ),
	array( 'sinag_theme_is_web_url', 'javascript:alert(1)', '' ),
	array( 'sinag_theme_is_web_url', 'HTTP://example.com/book', 'HTTP://example.com/book' ),
	array( 'sinag_theme_is_web_url', 'm.me/page', '' ),
);

$failed = 0;
foreach ( $cases as $c ) {
	list( $fn, $in, $want ) = $c;
	$got  = $fn( $in );
	$pass = $got === $want;
	$failed += $pass ? 0 : 1;
	printf( "%s  %-26s %-34s => %s\n", $pass ? 'PASS' : 'FAIL', $fn, var_export( $in, true ), var_export( $got, true ) );
}
printf( "%d cases, %d failed\n", count( $cases ), $failed );
exit( $failed ? 1 : 0 );
