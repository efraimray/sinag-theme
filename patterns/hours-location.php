<?php
/**
 * Title: Hours and location
 * Slug: sinag-theme/hours-location
 * Categories: sinag-business, contact
 * Keywords: hours, address, map, directions, contact, schedule
 * Viewport Width: 1280
 * Description: Opening hours, address and contact buttons, all filled from Appearance → Business Details.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Hours', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Drop by', 'sinag-theme' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"large","metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"hours"}}}}} -->
<p class="has-large-font-size"><?php esc_html_e( 'Mon–Sat 7:00 AM – 6:00 PM · Sun closed', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-sinag-checks"} -->
<ul class="wp-block-list is-style-sinag-checks"><!-- wp:list-item -->
<li><?php esc_html_e( 'Free Wi-Fi and charging outlets', 'sinag-theme' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'GCash and Maya accepted', 'sinag-theme' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Parking for motorcycles in front', 'sinag-theme' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"is-style-sinag-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-card" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Address', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"address"}}}}} -->
<p><?php esc_html_e( 'Purok 3, Barangay Poblacion, Valencia City, Bukidnon', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Phone', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"phone"}}}}} -->
<p><?php esc_html_e( '0917 000 0000', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"sinag-theme/business","args":{"key":"phone_link"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="tel:+639170000000"><?php esc_html_e( 'Call', 'sinag-theme' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline","metadata":{"bindings":{"url":{"source":"sinag-theme/business","args":{"key":"email_link"}}}}} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="mailto:hello@example.com"><?php esc_html_e( 'Email', 'sinag-theme' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
