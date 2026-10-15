<?php
/**
 * Title: Message call-to-action
 * Slug: sinag-theme/cta-message
 * Categories: sinag-business, call-to-action
 * Keywords: cta, contact, messenger, order, book
 * Viewport Width: 1280
 * Description: Full-width accent band with one line and a Message button linked to your chat link.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"accent","textColor":"on-accent","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-on-accent-color has-accent-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center"><?php esc_html_e( 'Order ahead, skip the line.', 'sinag-theme' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"contrast","textColor":"base","metadata":{"bindings":{"url":{"source":"sinag-theme/business","args":{"key":"messenger"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-base-color has-contrast-background-color has-text-color has-background wp-element-button" href="#"><?php esc_html_e( 'Message us', 'sinag-theme' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
