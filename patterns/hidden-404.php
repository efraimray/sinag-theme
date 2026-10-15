<?php
/**
 * Title: 404 content
 * Slug: sinag-theme/hidden-404
 * Inserter: no
 * Description: Message shown on the 404 template.
 *
 * @package Sinag_Theme
 */

?>
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php esc_html_e( 'Page not found', 'sinag-theme' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'The page may have moved. Try a search, or head back to the home page.', 'sinag-theme' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php echo esc_attr_x( 'Search', 'search form label', 'sinag-theme' ); ?>","showLabel":false,"buttonText":"<?php echo esc_attr_x( 'Search', 'search button text', 'sinag-theme' ); ?>"} /-->
