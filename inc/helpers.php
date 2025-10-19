<?php
declare( strict_types=1 );
/**
 * Theme Helpers - Utility Functions
 *
 * Common utility functions used throughout the theme.
 * These functions provide consistent patterns for checks, output escaping, and data handling.
 * Optimized for PHP 8.3 with strict type declarations.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if a block type exists on the current page
 *
 * Wrapper around has_block() with better performance for multiple checks.
 * Caches results during a single page request.
 *
 * @param string $block_type The block type to check (e.g., 'uagb/button', 'core/button').
 * @return bool True if block exists on the page, false otherwise.
 *
 * @since 1.0.0
 */
function astra_rise_has_block( $block_type ) {
	static $blocks = array();

	if ( isset( $blocks[ $block_type ] ) ) {
		return $blocks[ $block_type ];
	}

	$blocks[ $block_type ] = has_block( $block_type );

	return $blocks[ $block_type ];
}

/**
 * Check if multiple block types exist on the current page
 *
 * Useful for loading assets based on multiple block dependencies.
 *
 * @param array $block_types Array of block type slugs to check.
 * @return bool True if any block type exists, false otherwise.
 *
 * @since 1.0.0
 */
function astra_rise_has_blocks( $block_types ) {
	foreach ( (array) $block_types as $block_type ) {
		if ( astra_rise_has_block( $block_type ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Safe HTML output with escaping
 *
 * Outputs HTML attributes safely with proper escaping.
 *
 * @param string $html The HTML to output.
 * @param string $context The context for escaping (default: 'html').
 *
 * @since 1.0.0
 */
function astra_rise_output_html( $html, $context = 'html' ) {
	if ( 'html' === $context ) {
		echo wp_kses_post( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Properly escaped via wp_kses_post.
	} elseif ( 'attr' === $context ) {
		echo esc_attr( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Properly escaped via esc_attr.
	} elseif ( 'url' === $context ) {
		echo esc_url( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Properly escaped via esc_url.
	}
}

/**
 * Get version string with cache busting
 *
 * Returns the theme version or a file-based hash for better cache control.
 * Useful when enqueuing assets.
 *
 * @param string $file Optional. Path to a specific file to hash for cache busting.
 * @return string Version string or file hash.
 *
 * @since 1.0.0
 */
function astra_rise_get_version( $file = '' ) {
	if ( ! empty( $file ) && file_exists( $file ) ) {
		return filemtime( $file );
	}

	return ASTRA_RISE_VERSION;
}

/**
 * Check if Spectra (Ultimate Addons for Gutenberg) is active
 *
 * @return bool True if Spectra plugin is active, false otherwise.
 *
 * @since 1.0.0
 */
function astra_rise_is_spectra_active() {
	return defined( 'UAG_VERSION' ) || class_exists( 'Spectra_Pro' );
}

/**
 * Get Spectra version if available
 *
 * @return string|false Spectra version or false if not active.
 *
 * @since 1.0.0
 */
function astra_rise_get_spectra_version() {
	if ( defined( 'UAG_VERSION' ) ) {
		return UAG_VERSION;
	}

	if ( defined( 'SPECTRA_VERSION' ) ) {
		return SPECTRA_VERSION;
	}

	return false;
}

/**
 * Get Theme Performance Metrics
 *
 * Returns key performance indicators for the theme.
 * Useful for monitoring and debugging performance.
 *
 * @return array Performance metrics including memory, queries, and cache status.
 *
 * @since 1.1.0
 */
function astra_rise_get_performance_metrics() {
	return array(
		'version'              => ASTRA_RISE_VERSION,
		'php_version'          => PHP_VERSION,
		'wp_version'           => get_bloginfo( 'version' ),
		'memory_usage'         => size_format( memory_get_peak_usage( true ) ),
		'queries'              => get_num_queries(),
		'cache_enabled'        => wp_using_ext_object_cache() ? 'enabled' : 'disabled',
		'litespeed_cache'      => ASTRA_RISE_LITESPEED_CACHE ? 'enabled' : 'disabled',
		'minified_assets_used' => true,
		'lazy_loading_enabled' => true,
		'performance_hints'    => 'enabled',
	);
}

/**
 * Display Performance Debug Info (Admin Only)
 *
 * Adds performance metrics to admin footer in development mode.
 * Only visible to admins with WP_DEBUG enabled.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_show_performance_debug() {
	// Only show to admins in development mode
	if ( ! current_user_can( 'manage_options' ) || ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		return;
	}

	$metrics = astra_rise_get_performance_metrics();

	echo '<div style="padding: 10px; background: #f5f5f5; border-top: 1px solid #ddd; font-size: 11px; margin-top: 20px; font-family: monospace;">';
	echo '<strong>🚀 Astra Rise Performance Metrics:</strong><br>';

	foreach ( $metrics as $key => $value ) {
		$display_value = is_array( $value ) ? wp_json_encode( $value ) : (string) $value;
		printf(
			'<div>%s: <strong>%s</strong></div>',
			esc_html( str_replace( '_', ' ', ucfirst( $key ) ) ),
			esc_html( $display_value )
		);
	}

	echo '</div>';
}

// Only show debug in admin
if ( is_admin() ) {
	add_action( 'admin_footer', 'astra_rise_show_performance_debug' );
}

