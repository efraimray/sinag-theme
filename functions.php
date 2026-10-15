<?php
/**
 * Sinag theme bootstrap.
 *
 * Almost everything visual lives in theme.json, templates/, parts/ and patterns/.
 * This file only enqueues the stylesheet, registers block styles and the pattern
 * category, and loads the Business Details feature.
 *
 * @package Sinag_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SINAG_THEME_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/business-details.php';

/**
 * Theme supports and editor styles.
 */
function sinag_theme_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'sinag_theme_setup' );

/**
 * Front-end stylesheet (about 1 KB gzipped). No scripts are enqueued.
 */
function sinag_theme_enqueue_styles() {
	wp_enqueue_style(
		'sinag-theme',
		get_stylesheet_uri(),
		array(),
		SINAG_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'sinag_theme_enqueue_styles' );

/**
 * Pattern category so the theme's patterns are grouped in the inserter.
 */
function sinag_theme_register_pattern_category() {
	register_block_pattern_category(
		'sinag-business',
		array(
			'label'       => __( 'Sinag: Small Business', 'sinag-theme' ),
			'description' => __( 'Sections for shops, cafés, clinics and cooperatives.', 'sinag-theme' ),
		)
	);
}
add_action( 'init', 'sinag_theme_register_pattern_category' );

/**
 * Block style variations. The CSS for each lives in style.css.
 */
function sinag_theme_register_block_styles() {
	register_block_style(
		'core/group',
		array(
			'name'  => 'sinag-card',
			'label' => __( 'Card', 'sinag-theme' ),
		)
	);
	register_block_style(
		'core/group',
		array(
			'name'  => 'sinag-price-row',
			'label' => __( 'Price row', 'sinag-theme' ),
		)
	);
	register_block_style(
		'core/list',
		array(
			'name'  => 'sinag-checks',
			'label' => __( 'Check list', 'sinag-theme' ),
		)
	);
}
add_action( 'init', 'sinag_theme_register_block_styles' );
