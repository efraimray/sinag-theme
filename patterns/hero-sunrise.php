<?php
/**
 * Title: Sunrise hero
 * Slug: sinag-theme/hero-sunrise
 * Categories: sinag-business, banner, featured
 * Keywords: hero, intro, welcome, banner
 * Viewport Width: 1280
 * Description: Big welcome headline, a short pitch, Call and Message buttons, and a soft CSS sun behind it.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","className":"sinag-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"base-2","layout":{"type":"constrained","contentSize":"760px"}} -->
<div class="wp-block-group alignfull sinag-hero has-base-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Kapehan sa Burol · Valencia City', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'Locally roasted Bukidnon coffee, brewed the way you like it.', 'sinag-theme' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Beans from farms around Mount Kitanglad, roasted every Tuesday. Dine in, take out, or message us to reserve the upstairs room.', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"sinag-theme/business","args":{"key":"phone_link"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="tel:+639170000000"><?php esc_html_e( 'Call us', 'sinag-theme' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","metadata":{"bindings":{"url":{"source":"sinag-theme/business","args":{"key":"messenger"}}}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Message us', 'sinag-theme' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
