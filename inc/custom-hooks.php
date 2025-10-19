<?php
/**
 * Custom WordPress & Astra Hooks
 *
 * Integrates with Astra parent theme hooks and adds custom action/filter points
 * for safe extensibility without modifying core files.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Astra Theme Hook Integration
 *
 * This section documents available Astra hooks for child theme customization.
 * Uncomment and adapt examples as needed.
 *
 * Available Astra Hooks:
 * - astra_header_before / astra_header_after
 * - astra_footer_before / astra_footer_after
 * - astra_entry_content_before / astra_entry_content_after
 * - astra_masthead_primary_attr (filter)
 * - astra_page_layout (filter)
 * - astra_breadcrumb_before / astra_breadcrumb_after
 *
 * @link https://docs.astra.build/article/1235-astra-theme-hooks/
 */

/**
 * Example: Customize Astra Header
 *
 * Hook into Astra's header section to inject custom content or styling.
 * Uncomment to use.
 *
 * @return void
 */
/*
function astra_rise_custom_header_content() {
	// Add custom header content here
}
add_action( 'astra_header_before', 'astra_rise_custom_header_content', 5 );
*/

/**
 * Example: Customize Astra Footer
 *
 * Uncomment to extend footer functionality.
 *
 * @return void
 */
/*
function astra_rise_custom_footer_content() {
	// Add custom footer content here
}
add_action( 'astra_footer_after', 'astra_rise_custom_footer_content', 10 );
*/

/**
 * Custom Astra Rise Hooks
 *
 * New hooks specific to this child theme for better extensibility.
 */

/**
 * Fire custom theme initialization hook
 *
 * Allows plugins and extensions to hook into theme initialization.
 *
 * @since 1.0.0
 */
do_action( 'astra_rise_init' );

/**
 * Fire custom block styles registration hook
 *
 * Allows plugins to register custom Spectra or block styles.
 *
 * @since 1.0.0
 */
do_action( 'astra_rise_register_block_styles' );

/**
 * Example Hook Implementation
 *
 * Demonstrates how to use custom Astra Rise hooks in plugins or themes.
 *
 * Usage:
 *
 * add_action( 'astra_rise_init', function() {
 *     // Custom initialization code
 * });
 */
