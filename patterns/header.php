<?php
/**
 * Title: Header with hours bar
 * Slug: sinag-theme/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Top bar with today's hours and phone (from Business Details), then logo, site title and navigation.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:group {"align":"full","className":"sinag-topbar","backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sinag-topbar has-base-color has-contrast-background-color has-text-color has-background"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"hours"}}}}} -->
<p><?php esc_html_e( 'Mon–Sat 7:00 AM – 6:00 PM · Sun closed', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"phone"}}}}} -->
<p><?php esc_html_e( '0917 000 0000', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"sinag-header","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull sinag-header"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:site-logo {"width":40,"shouldSyncIcon":true} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"right"}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
