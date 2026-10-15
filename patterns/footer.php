<?php
/**
 * Title: Footer with contact details
 * Slug: sinag-theme/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Site title, address, phone and email from Business Details, plus a copyright line.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"base-2","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-2-background-color has-background"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:site-title {"level":0} /-->

<!-- wp:site-tagline /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Visit', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"address"}}}}} -->
<p><?php esc_html_e( 'Purok 3, Barangay Poblacion, Valencia City, Bukidnon', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Contact', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"phone"}}}}} -->
<p><?php esc_html_e( '0917 000 0000', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"email"}}}}} -->
<p><?php esc_html_e( 'hello@example.com', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->

<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php
/* translators: %s: current year. */
printf( esc_html__( '© %s · Built with the Sinag theme', 'sinag-theme' ), esc_html( gmdate( 'Y' ) ) );
?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
