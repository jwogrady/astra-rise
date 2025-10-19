<?php
/**
 * Spectra Blocks Integration & Optimization
 *
 * Provides Spectra-specific block styles, conditional asset loading,
 * and customization hooks for better performance and maintainability.
 *
 * @package astra-rise
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Block Styles for Spectra Blocks
 *
 * Custom block styles enhance Spectra blocks without modifying their core output.
 * Uses register_block_style() to safely extend block functionality.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_register_spectra_block_styles() {
	// Only register if block style API is available.
	if ( ! function_exists( 'register_block_style' ) ) {
		return;
	}

	/**
	 * Spectra Button: Gradient Style
	 *
	 * Adds a brand gradient fill to Spectra buttons.
	 * Applies the "Rise Accent" gradient from theme.json.
	 */
	register_block_style( 'uagb/button', array(
		'name'  => 'rise-gradient',
		'label' => __( 'Rise Gradient', 'astra-rise' ),
	) );

	/**
	 * Spectra Button: Outline Style
	 *
	 * Creates a transparent button with border using brand colors.
	 * Provides hover state for better UX.
	 */
	register_block_style( 'uagb/button', array(
		'name'  => 'rise-outline',
		'label' => __( 'Rise Outline', 'astra-rise' ),
	) );

	/**
	 * Spectra Container: Elevated Card Style
	 *
	 * Adds shadow and padding for card-like presentation.
	 * Perfect for feature highlights or service cards.
	 */
	if ( function_exists( 'register_block_style' ) ) {
		register_block_style( 'uagb/container', array(
			'name'  => 'rise-elevated-card',
			'label' => __( 'Rise Elevated Card', 'astra-rise' ),
		) );
	}

	/**
	 * Spectra Heading: Accent Bottom Border
	 *
	 * Adds a decorative bottom border to headings using brand accent color.
	 */
	register_block_style( 'uagb/heading', array(
		'name'  => 'rise-accent-underline',
		'label' => __( 'Rise Accent Underline', 'astra-rise' ),
	) );

	/**
	 * Spectra Separator/Divider: Gradient Line
	 *
	 * Replaces standard separators with gradient lines.
	 */
	register_block_style( 'uagb/separator', array(
		'name'  => 'rise-gradient-line',
		'label' => __( 'Rise Gradient Line', 'astra-rise' ),
	) );

	/**
	 * Core Blocks: Rise Outline Button
	 *
	 * Consistent outline styling for core/button blocks.
	 * Ensures brand consistency across all button types.
	 */
	register_block_style( 'core/button', array(
		'name'  => 'rise-outline',
		'label' => __( 'Rise Outline', 'astra-rise' ),
	) );
}
add_action( 'enqueue_block_assets', 'astra_rise_register_spectra_block_styles' );

/**
 * Add Inline CSS for Spectra Block Styles
 *
 * Dynamically injects CSS for custom block styles.
 * These styles are added when the corresponding block is present on the page.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_add_spectra_inline_styles() {
	// Only proceed on frontend and block editor.
	if ( is_admin() && ! is_block_editor() ) {
		return;
	}

	// CSS for Rise Gradient button style
	$gradient_button_css = '
.is-style-rise-gradient .wp-block-uagb-button__link {
	background: var(--wp--preset--gradient--rise-accent);
	color: var(--wp--preset--color--rise-white);
	border: none;
	transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.is-style-rise-gradient .wp-block-uagb-button__link:hover {
	transform: translateY(-2px);
	box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
}
';

	// CSS for Rise Outline button style
	$outline_button_css = '
.is-style-rise-outline .wp-block-uagb-button__link,
.is-style-rise-outline .wp-block-button__link {
	background: transparent;
	border: 2px solid var(--wp--preset--color--rise-blue);
	color: var(--wp--preset--color--rise-blue);
	transition: all 0.2s ease;
}

.is-style-rise-outline .wp-block-uagb-button__link:hover,
.is-style-rise-outline .wp-block-button__link:hover {
	background: var(--wp--preset--color--rise-blue);
	color: var(--wp--preset--color--rise-white);
}
';

	// CSS for Rise Elevated Card style
	$elevated_card_css = '
.is-style-rise-elevated-card.wp-block-uagb-container {
	box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
	padding: var(--rise-space-lg, 2rem);
	border-radius: var(--rise-border-radius, 8px);
	transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.is-style-rise-elevated-card.wp-block-uagb-container:hover {
	box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
	transform: translateY(-4px);
}
';

	// CSS for Rise Accent Underline heading style
	$accent_underline_css = '
.is-style-rise-accent-underline.wp-block-uagb-heading::after {
	content: "";
	display: block;
	width: 60px;
	height: 4px;
	background: var(--wp--preset--gradient--rise-accent);
	margin-top: 0.5rem;
	border-radius: 2px;
}
';

	// CSS for Rise Gradient Line separator style
	$gradient_line_css = '
.is-style-rise-gradient-line.wp-block-uagb-separator {
	background: var(--wp--preset--gradient--rise-accent);
	height: 3px;
	margin: var(--rise-space-lg, 2rem) 0;
}

.is-style-rise-gradient-line.wp-block-separator {
	background: var(--wp--preset--gradient--rise-accent);
	opacity: 1;
	height: 2px;
	margin: var(--rise-space-md, 1.5rem) 0;
}
';

	// Combine all styles
	$all_spectra_styles = $gradient_button_css . $outline_button_css . $elevated_card_css . $accent_underline_css . $gradient_line_css;

	// Minify CSS (remove unnecessary whitespace)
	$all_spectra_styles = preg_replace( '/\s+/', ' ', $all_spectra_styles );
	$all_spectra_styles = trim( $all_spectra_styles );

	// Add inline styles to the brand CSS handle
	wp_add_inline_style( 'astra-rise-brand', $all_spectra_styles );
}
add_action( 'wp_enqueue_scripts', 'astra_rise_add_spectra_inline_styles', 20 );
add_action( 'enqueue_block_editor_assets', 'astra_rise_add_spectra_inline_styles', 20 );

/**
 * Conditionally Enqueue Spectra-Specific CSS
 *
 * Only loads Spectra CSS file if:
 * 1. Spectra plugin is active
 * 2. Spectra blocks are present on the current page
 *
 * This improves performance by avoiding unnecessary CSS downloads.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_enqueue_spectra_css() {
	// Only check on frontend
	if ( is_admin() ) {
		return;
	}

	// Array of Spectra block types to check for
	$spectra_blocks = array(
		'uagb/button',
		'uagb/container',
		'uagb/heading',
		'uagb/separator',
		'uagb/icon',
		'uagb/progress-bar',
		'uagb/pricing',
	);

	// Check if any Spectra blocks exist on the page
	if ( astra_rise_has_blocks( $spectra_blocks ) && astra_rise_is_spectra_active() ) {
		wp_enqueue_style(
			'astra-rise-spectra',
			ASTRA_RISE_URI . '/assets/css/spectra.css',
			array( 'astra-rise-brand' ),
			astra_rise_get_version( ASTRA_RISE_DIR . '/assets/css/spectra.css' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'astra_rise_enqueue_spectra_css', 25 );

/**
 * Add Block Style Support to theme.json
 *
 * Documents how to extend Spectra block styles via theme.json
 * when using WordPress 6.2+ FSE-compatible block definitions.
 *
 * @return void
 *
 * @since 1.0.0
 */
function astra_rise_document_block_styles_fse() {
	// This is a placeholder for FSE-based block style registration.
	// In WordPress 6.2+, consider using block.json "styles" property
	// for better Full Site Editing (FSE) compatibility.

	/*
	Example block.json usage for Spectra blocks:

	{
		"name": "uagb/button",
		"title": "Button",
		"styles": [
			{
				"name": "default",
				"label": "Default",
				"isDefault": true
			},
			{
				"name": "rise-gradient",
				"label": "Rise Gradient"
			},
			{
				"name": "rise-outline",
				"label": "Rise Outline"
			}
		]
	}

	Then define styles in separate CSS files:
	- assets/css/blocks/button-rise-gradient.css
	- assets/css/blocks/button-rise-outline.css

	See: https://developer.wordpress.org/block-editor/blocks/
	*/
}
