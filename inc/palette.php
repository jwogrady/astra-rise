<?php
/**
 * Editor Color Palette & Gradient Control
 *
 * Registers editor-specific color palettes and gradients.
 * Maintains parity with theme.json settings while allowing
 * WordPress < 6.x compatibility.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Editor Color Palette & Gradients
 *
 * Provides colors and gradients for Gutenberg editor, maintaining
 * consistency with theme.json definitions for WordPress 6.2+ Full Site Editing.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_register_editor_palette() {
	// Define brand colors (synced with theme.json)
	$colors = array(
		array(
			'name'  => __( 'Rise Black', 'astra-rise' ),
			'slug'  => 'rise-black',
			'color' => '#000000',
		),
		array(
			'name'  => __( 'Rise White', 'astra-rise' ),
			'slug'  => 'rise-white',
			'color' => '#FFFFFF',
		),
		array(
			'name'  => __( 'Rise Gray', 'astra-rise' ),
			'slug'  => 'rise-gray',
			'color' => '#6B7280',
		),
		array(
			'name'  => __( 'Rise Blue', 'astra-rise' ),
			'slug'  => 'rise-blue',
			'color' => '#3B82F6',
		),
		array(
			'name'  => __( 'Rise Blue Dark', 'astra-rise' ),
			'slug'  => 'rise-blue-dark',
			'color' => '#1E40AF',
		),
		array(
			'name'  => __( 'Rise Blue Light', 'astra-rise' ),
			'slug'  => 'rise-blue-light',
			'color' => '#93C5FD',
		),
		array(
			'name'  => __( 'Rise Background', 'astra-rise' ),
			'slug'  => 'rise-background',
			'color' => '#F8FAFC',
		),
		array(
			'name'  => __( 'Rise Orange Accent', 'astra-rise' ),
			'slug'  => 'rise-orange-accent',
			'color' => '#FFB457',
		),
	);

	// Define brand gradients (synced with theme.json)
	$gradients = array(
		array(
			'name'     => __( 'Rise Blue Gradient', 'astra-rise' ),
			'slug'     => 'rise-blue-gradient',
			'gradient' => 'linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%)',
		),
		array(
			'name'     => __( 'Rise Professional', 'astra-rise' ),
			'slug'     => 'rise-professional',
			'gradient' => 'linear-gradient(135deg, #000000 0%, #6B7280 100%)',
		),
		array(
			'name'     => __( 'Rise Accent', 'astra-rise' ),
			'slug'     => 'rise-accent',
			'gradient' => 'linear-gradient(135deg, #3B82F6 0%, #FFB457 100%)',
		),
	);

	// Register color palette for editor
	add_theme_support( 'editor-color-palette', $colors );

	// Register gradients for editor
	add_theme_support( 'editor-gradient-presets', $gradients );

	/**
	 * Enforce Brand Palette & Gradients
	 *
	 * By default, only brand colors/gradients are available.
	 * Site owners can opt-in to custom colors via Customizer.
	 * This maintains visual consistency and brand compliance.
	 */
	$allow_custom_colors    = (bool) get_theme_mod( 'rise_allow_custom_colors', false );
	$allow_custom_gradients = (bool) get_theme_mod( 'rise_allow_custom_gradients', false );

	// If custom colors are not allowed, disable the custom color picker
	if ( ! $allow_custom_colors ) {
		add_theme_support( 'disable-custom-colors' );
	}

	// If custom gradients are not allowed, disable the custom gradient picker
	if ( ! $allow_custom_gradients ) {
		add_theme_support( 'disable-custom-gradients' );
	}

	/**
	 * Allow custom font sizes by default
	 * This gives editors flexibility in typography while maintaining defaults
	 */
	// Note: Custom font sizes are enabled by default in Gutenberg
	// To disable: add_theme_support( 'disable-custom-font-sizes' );
}
add_action( 'after_setup_theme', 'astra_rise_register_editor_palette' );

/**
 * Document Color Palette Structure
 *
 * This palette is used across:
 * 1. Gutenberg block editor (via add_theme_support)
 * 2. theme.json (WordPress 6.2+ FSE)
 * 3. CSS variables in assets/css/brand.css
 *
 * To add new colors:
 * 1. Add to the $colors array above
 * 2. Update theme.json color palette
 * 3. Add CSS variable in assets/css/brand.css
 * 4. Update assets/css/spectra.css if needed for block styles
 *
 * Benefits:
 * - Single source of truth for theme colors
 * - Automatic availability in Gutenberg
 * - Full Site Editing (FSE) compatible
 * - Translatable labels via __()
 *
 * @since 1.0.0
 */

