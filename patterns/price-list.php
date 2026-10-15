<?php
/**
 * Title: Price list (pesos)
 * Slug: sinag-theme/price-list
 * Categories: sinag-business, text
 * Keywords: menu, prices, rates, peso, list
 * Viewport Width: 1280
 * Description: Two-column menu or rate card with dotted leaders and peso prices.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"base-2","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-2-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"className":"sinag-eyebrow"} -->
<p class="sinag-eyebrow"><?php esc_html_e( 'Menu', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Prices', 'sinag-theme' ); ?></h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php esc_html_e( 'Coffee', 'sinag-theme' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Brewed Bukidnon Robusta', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '85' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Spanish latte', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '140' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Tablea hot chocolate', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '120' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

</div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php esc_html_e( 'Bakery', 'sinag-theme' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Pandesal (6 pcs)', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '45' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Ube cheese ensaymada', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '65' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-sinag-price-row","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-sinag-price-row"><!-- wp:paragraph -->
<p><?php esc_html_e( 'Beans, 250 g bag', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<span class="sinag-leader" aria-hidden="true"></span>
<!-- /wp:html -->

<!-- wp:paragraph -->
<p><?php echo esc_html( sprintf( /* translators: %s: price in Philippine pesos. */ __( '₱%s', 'sinag-theme' ), '320' ) ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

</div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
