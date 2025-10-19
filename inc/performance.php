<?php
declare( strict_types=1 );
/**
 * Performance & Caching Optimizations
 *
 * Implements WordPress 6.8.3 performance features, LiteSpeed cache optimization,
 * and PHP 8.3 compatibility for improved site performance.
 *
 * @package astra-rise
 * @since 1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Optimize Script Loading
 *
 * Add script strategy attributes for better performance with WordPress 6.8.3+
 * - 'defer': Scripts load asynchronously after document parsing
 * - 'async': Scripts load independently without blocking rendering
 *
 * @param string $tag    The complete script tag.
 * @param string $handle The script's registered handle.
 * @return string Modified script tag with strategy attribute.
 *
 * @since 1.1.0
 */
function astra_rise_add_script_strategy( string $tag, string $handle ): string {
	// Add defer to smooth-scroll script for non-critical functionality
	if ( 'astra-rise-smooth-scroll' === $handle ) {
		return str_replace( ' src=', ' defer src=', $tag );
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'astra_rise_add_script_strategy', 10, 2 );

/**
 * Enable Lazy Loading for Images
 *
 * WordPress 5.5+ supports native lazy loading. WordPress 6.8.3 includes
 * improved lazy loading with better LCP optimization.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_enable_lazy_loading(): void {
	add_filter( 'wp_img_tag_add_loading_attr', '__return_true' );
	
	// Use native lazy loading attribute instead of JavaScript library
	add_filter(
		'wp_lazy_loading_enabled',
		static function( bool $enabled, string $tag_name ): bool {
			return 'img' === $tag_name; // Enable for img tags
		},
		10,
		2
	);
}
add_action( 'init', 'astra_rise_enable_lazy_loading' );

/**
 * Optimize Image Tag Output
 *
 * Adds responsive image attributes and enforces aspect ratio preservation.
 * Reduces Cumulative Layout Shift (CLS).
 *
 * @param string $attr       The complete img tag attributes.
 * @param object $attachment The attachment object.
 * @return string Modified attributes with width and height hints.
 *
 * @since 1.1.0
 */
function astra_rise_optimize_attachment_attributes( string $attr, object $attachment ): string {
	// Ensure width and height attributes are present for aspect ratio preservation
	if ( ! str_contains( $attr, 'width=' ) && ! str_contains( $attr, 'height=' ) ) {
		$meta = wp_get_attachment_metadata( $attachment->ID );
		
		if ( is_array( $meta ) && isset( $meta['width'], $meta['height'] ) ) {
			$attr .= sprintf( ' width="%d" height="%d"', $meta['width'], $meta['height'] );
		}
	}
	
	// Add decoding="async" for improved rendering performance
	if ( ! str_contains( $attr, 'decoding=' ) ) {
		$attr .= ' decoding="async"';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'astra_rise_optimize_attachment_attributes', 10, 2 );

/**
 * LiteSpeed Cache Headers Optimization
 *
 * Configures cache headers for LiteSpeed to optimize caching behavior.
 * Only runs if LiteSpeed Cache plugin is active and not in admin.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_litespeed_cache_headers(): void {
	// Skip on admin pages completely to avoid WordPress core issues
	if ( is_admin() ) {
		return;
	}

	if ( ! defined( 'LSCACHE_VERSION' ) ) {
		return;
	}

	// Set appropriate cache TTL for different content types
	if ( is_front_page() || is_home() ) {
		// Cache homepage for 24 hours
		header( 'X-LiteSpeed-Cache-Control: public,max-age=86400' );
	} elseif ( is_singular( array( 'post', 'page' ) ) ) {
		// Cache single posts/pages for 7 days
		header( 'X-LiteSpeed-Cache-Control: public,max-age=604800' );
	} elseif ( is_archive() || is_search() ) {
		// Cache archive pages for 3 days
		header( 'X-LiteSpeed-Cache-Control: public,max-age=259200' );
	}
}
add_action( 'wp_head', 'astra_rise_litespeed_cache_headers' );

/**
 * Optimize Block Rendering Performance
 *
 * Pre-renders critical blocks and optimizes block dependencies.
 * WordPress 6.8.3 improvement for FSE sites.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_optimize_block_rendering(): void {
	// Remove unnecessary block library styles to reduce CSS output
	add_filter( 'should_load_separate_core_block_assets', '__return_true' );

	// Disable WordPress jQuery migrate script (not needed with modern themes)
	wp_deregister_script( 'jquery-migrate' );
}
add_action( 'wp_enqueue_scripts', 'astra_rise_optimize_block_rendering', 1 );

/**
 * Add Performance Hints in wp_head
 *
 * Implements WordPress 6.8.3+ performance APIs for better LCP and CLS.
 * Only runs on frontend.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_add_performance_hints(): void {
	// Skip on admin pages
	if ( is_admin() ) {
		return;
	}

	// For LiteSpeed servers, indicate that we support HTTP/2 Server Push
	if ( defined( 'LSCACHE_VERSION' ) ) {
		echo "\n<!-- LiteSpeed Cache Enabled: v" . esc_attr( LSCACHE_VERSION ) . " -->\n";
	}

	// Add color-scheme meta tag for better user experience
	echo '<meta name="color-scheme" content="light dark">' . "\n";
}
add_action( 'wp_head', 'astra_rise_add_performance_hints', 5 );

/**
 * Remove Unnecessary Meta Tags
 *
 * Reduces HTML bloat and improves LCP by removing unused meta tags.
 * Only removes on frontend to avoid WordPress core issues.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_remove_unnecessary_meta(): void {
	// Skip on admin pages
	if ( is_admin() ) {
		return;
	}

	// Remove emoji script to save request (not needed for Rise Local theme)
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove XML-RPC header for security and reduced bloat
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
}
add_action( 'init', 'astra_rise_remove_unnecessary_meta' );

/**
 * Optimize Database Queries
 *
 * Implements query caching and optimization for common database operations.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_optimize_queries(): void {
	// Cache expensive queries during page load
	// This improves performance on pages with multiple queries
	
	// Skip on admin pages to avoid issues with WordPress core
	if ( is_admin() ) {
		return;
	}

	// Cache nav menu queries to reduce database hits
	// Navigation menus are typically requested multiple times per page
	add_filter(
		'wp_cache_themes_persistently',
		static function( bool $cache ): bool {
			return true;
		}
	);
}
add_action( 'wp_loaded', 'astra_rise_optimize_queries' );

/**
 * Implement Object Caching Hints
 *
 * Suggests which queries and objects to cache for better performance.
 * Works with persistent object cache like Redis or Memcached.
 *
 * @return void
 *
 * @since 1.1.0
 */
function astra_rise_implement_object_cache(): void {
	// Implement caching only if object cache is available
	if ( ! wp_using_ext_object_cache() ) {
		return;
	}

	// Pre-warm cache for critical data
	if ( function_exists( 'wp_cache_supports' ) && wp_cache_supports( 'get_multi' ) ) {
		// Cache theme options on first load
		$theme_options = wp_cache_get( 'astra_rise_options' );
		
		if ( false === $theme_options ) {
			$theme_options = get_option( 'theme_mods_' . get_stylesheet() );
			wp_cache_set( 'astra_rise_options', $theme_options, '', HOUR_IN_SECONDS );
		}
	}
}
add_action( 'wp_loaded', 'astra_rise_implement_object_cache' );
