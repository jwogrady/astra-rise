<?php
/**
 * Theme Assets Enqueuing - Scripts & Styles
 *
 * Handles all asset loading including fonts, stylesheets, and JavaScript.
 * Implements performance optimizations like conditional loading and resource hints.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if local font files exist
 *
 * Returns true only if ALL required local font files are present.
 * Falls back to Google Fonts if any file is missing.
 *
 * @return bool True if all local font files exist, false otherwise.
 *
 * @since 1.0.0
 */
function astra_rise_has_local_fonts() {
	$fonts = array(
		ASTRA_RISE_DIR . '/assets/fonts/Inter-400.woff2',
		ASTRA_RISE_DIR . '/assets/fonts/Montserrat-600.woff2',
		ASTRA_RISE_DIR . '/assets/fonts/PermanentMarker-400.woff2',
	);

	foreach ( $fonts as $path ) {
		if ( ! file_exists( $path ) ) {
			return false;
		}
	}

	return true;
}

/**
 * Build Google Fonts URL
 *
 * Constructs the Google Fonts API endpoint with specified families.
 * Used as fallback when local fonts are unavailable.
 *
 * @return string Full Google Fonts URL with query parameters.
 *
 * @since 1.0.0
 */
function astra_rise_get_google_fonts_url() {
	$families = array(
		'Montserrat:wght@100;200;400;600;800',
		'Inter:wght@300;400;500;600',
		'Permanent+Marker:wght@400',
	);

	$args = array(
		'family'  => implode( '|', $families ),
		'display' => 'swap',
	);

	return add_query_arg( $args, 'https://fonts.googleapis.com/css2' );
}

/**
 * Enqueue Frontend Styles and Scripts
 *
 * Loads fonts (local preferred, Google fallback), theme CSS, and JavaScript.
 * Properly declares dependencies for cascade and execution order.
 * Optimized for LiteSpeed caching and WordPress 6.8.3.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_enqueue_assets(): void {
	// Enqueue fonts: prefer self-hosted, fallback to Google Fonts.
	// LiteSpeed will cache these appropriately
	if ( astra_rise_has_local_fonts() ) {
		wp_enqueue_style(
			'astra-rise-local-fonts',
			ASTRA_RISE_URI . '/assets/css/fonts.css',
			array(),
			astra_rise_get_version( ASTRA_RISE_DIR . '/assets/css/fonts.css' )
		);
	} else {
		wp_enqueue_style(
			'astra-rise-google-fonts',
			astra_rise_get_google_fonts_url(),
			array(),
			null
		);
	}

	// Enqueue child theme main stylesheet (depends on parent Astra).
	wp_enqueue_style(
		'astra-rise-theme',
		ASTRA_RISE_URI . '/style.css',
		array( 'astra-theme-css' ),
		astra_rise_get_version( ASTRA_RISE_DIR . '/style.css' )
	);

	// Enqueue brand CSS (depends on main theme stylesheet).
	wp_enqueue_style(
		'astra-rise-brand',
		ASTRA_RISE_URI . '/assets/css/brand.css',
		array( 'astra-rise-theme' ),
		astra_rise_get_version( ASTRA_RISE_DIR . '/assets/css/brand.css' )
	);

	// Enqueue smooth scroll JavaScript (in footer with defer for performance).
	wp_enqueue_script(
		'astra-rise-smooth-scroll',
		ASTRA_RISE_URI . '/assets/js/smooth-scroll.js',
		array(),
		astra_rise_get_version( ASTRA_RISE_DIR . '/assets/js/smooth-scroll.js' ),
		true // Load in footer for better performance
	);
}
add_action( 'wp_enqueue_scripts', 'astra_rise_enqueue_assets', 15 );

/**
 * Enqueue Block Editor Assets
 *
 * Ensures fonts are available in the Gutenberg editor for visual parity.
 * Runs only in editor context with valid post object.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_enqueue_editor_assets() {
	// Only enqueue in editor context with a valid post
	if ( ! function_exists( 'get_current_screen' ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->base, array( 'post', 'site-editor' ), true ) ) {
		return;
	}

	if ( astra_rise_has_local_fonts() ) {
		wp_enqueue_style(
			'astra-rise-editor-fonts',
			ASTRA_RISE_URI . '/assets/css/fonts.css',
			array(),
			astra_rise_get_version( ASTRA_RISE_DIR . '/assets/css/fonts.css' )
		);
	} else {
		wp_enqueue_style(
			'astra-rise-editor-google-fonts',
			astra_rise_get_google_fonts_url(),
			array(),
			null
		);
	}
}
add_action( 'enqueue_block_editor_assets', 'astra_rise_enqueue_editor_assets' );

/**
 * Add Resource Hints for Performance
 *
 * Adds preconnect and dns-prefetch hints for external font sources.
 * Only applied when using Google Fonts fallback.
 *
 * @param array  $urls            List of URLs to preconnect/prefetch.
 * @param string $relation_type   Type of relation (preconnect, dns-prefetch, preload, etc.).
 * @return array Modified URLs array.
 *
 * @since 1.0.0
 */
function astra_rise_add_resource_hints( $urls, $relation_type ) {
	// Only add hints for Google Fonts if not using local fonts.
	if ( astra_rise_has_local_fonts() ) {
		return $urls;
	}

	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => true,
		);
	}

	if ( 'dns-prefetch' === $relation_type ) {
		$urls[] = '//fonts.googleapis.com';
		$urls[] = '//fonts.gstatic.com';
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'astra_rise_add_resource_hints', 10, 2 );

/**
 * Preload Critical Local Fonts
 *
 * Adds <link rel="preload"> tags for critical fonts in <head>.
 * Improves LCP (Largest Contentful Paint) and reduces layout shift.
 * Essential for LiteSpeed cache optimization.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_preload_local_fonts(): void {
	if ( ! astra_rise_has_local_fonts() ) {
		return;
	}

	$fonts = array(
		array(
			'file' => 'Inter-400.woff2',
			'type' => 'font/woff2',
		),
		array(
			'file' => 'Montserrat-600.woff2',
			'type' => 'font/woff2',
		),
		array(
			'file' => 'PermanentMarker-400.woff2',
			'type' => 'font/woff2',
		),
	);

	foreach ( $fonts as $font ) {
		$href = esc_url( ASTRA_RISE_URI . '/assets/fonts/' . $font['file'] );
		printf(
			'<link rel="preload" href="%s" as="font" type="%s" crossorigin>%s',
			$href,
			esc_attr( $font['type'] ),
			"\n"
		);
	}
}
add_action( 'wp_head', 'astra_rise_preload_local_fonts', 1 );
add_action( 'wp_head', 'astra_rise_preload_local_fonts', 1 );
