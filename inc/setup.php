<?php
/**
 * Theme Setup & Feature Support
 *
 * Initializes WordPress and Astra features, adds theme support flags,
 * and defines custom image sizes.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Theme Setup Hook
 *
 * Runs during 'after_setup_theme' and initializes all theme features.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_theme_setup() {
	// Enable custom logo support with specific dimensions
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Enable featured images/post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Enable custom header with background image support
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'default-text-color' => '000000',
		'width'              => 1920,
		'height'             => 600,
		'flex-height'        => true,
		'flex-width'         => true,
		'uploads'            => true,
	) );

	// Enable custom background
	add_theme_support( 'custom-background', array(
		'default-color' => 'f6f7f9',
		'default-image' => '',
	) );

	// Enable content width alignment
	add_theme_support( 'align-wide' );

	// Make embeds responsive by default
	add_theme_support( 'responsive-embeds' );

	// Enable block editor styles
	add_theme_support( 'editor-styles' );

	// HTML5 markup support for better semantic HTML
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	) );

	// Register custom image sizes for consistent theme appearance
	// Usage: wp_get_attachment_image( $attachment_id, 'rise-hero' )
	add_image_size( 'rise-hero', 1920, 600, true );        // Full-width hero images
	add_image_size( 'rise-service-card', 400, 300, true );  // Service/feature cards
	add_image_size( 'rise-testimonial', 150, 150, true );   // Testimonial avatars
	add_image_size( 'rise-team-member', 300, 300, true );   // Team member photos

	/**
	 * Load text domain for internationalization
	 *
	 * Allows translations of this theme's strings.
	 * Language files should be placed in /languages directory.
	 *
	 * @since 1.0.0
	 */
	load_theme_textdomain( 'astra-rise', ASTRA_RISE_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'astra_rise_theme_setup' );

/**
 * Add Custom Body Classes
 *
 * Enhances the body element with semantic classes for better styling hooks.
 * Useful for CSS targeting and JavaScript selectors.
 *
 * @param array $classes Array of existing body classes.
 * @return array Modified array of body classes.
 *
 * @since 1.0.0
 */
function astra_rise_body_classes( $classes ) {
	$classes[] = 'astra-rise-theme';

	// Add class if custom logo is present
	if ( has_custom_logo() ) {
		$classes[] = 'has-custom-logo';
	}

	// Add class indicating Spectra support
	if ( astra_rise_is_spectra_active() ) {
		$classes[] = 'has-spectra-support';
	}

	return $classes;
}
add_filter( 'body_class', 'astra_rise_body_classes' );

/**
 * Clean Up Unnecessary Head Tags
 *
 * Removes metadata and feeds that may not be needed,
 * improving security and reducing header bloat.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_cleanup_head() {
	// Remove WordPress version meta
	remove_action( 'wp_head', 'wp_generator' );

	// Remove shortlink
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Remove RSD (Really Simple Discovery) link
	remove_action( 'wp_head', 'rsd_link' );

	// Remove Windows Live Writer manifest
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Remove adjacent post links (helps with performance on large sites)
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
}
add_action( 'init', 'astra_rise_cleanup_head' );

/**
 * Ensure Astra Parent Theme is Active
 *
 * Gracefully handles case where child theme is installed
 * without parent theme, preventing errors.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_verify_parent_theme() {
	$parent = wp_get_theme( 'astra' );

	if ( ! $parent->exists() ) {
		add_action(
			'admin_notices',
			static function() {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					esc_html__( 'Astra Rise child theme requires the Astra parent theme to be installed and activated.', 'astra-rise' )
				);
			}
		);
	}
}
add_action( 'admin_init', 'astra_rise_verify_parent_theme' );

