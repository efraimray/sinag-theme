<?php
/**
 * Title: FAQ
 * Slug: sinag-theme/faq
 * Categories: sinag-business, text
 * Keywords: faq, questions, answers, accordion
 * Viewport Width: 1280
 * Description: Frequently asked questions using the native Details block (no JavaScript).
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Questions we get a lot', 'sinag-theme' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Do you deliver?', 'sinag-theme' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Yes, within Valencia City through local riders. Message us your order and landmark.', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Can we reserve the upstairs room?', 'sinag-theme' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'Book at least two days ahead. There is no room fee when the group orders ₱1,500 or more.', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details -->
<details class="wp-block-details"><summary><?php esc_html_e( 'Do you sell beans wholesale?', 'sinag-theme' ); ?></summary><!-- wp:paragraph -->
<p><?php esc_html_e( 'We supply cafés and resellers from 5 kg per month. Ask for the current rate card.', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

</div>
<!-- /wp:group -->
