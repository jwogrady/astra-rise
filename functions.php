<?php
/**
 * Astra Rise Child Theme - Theme Bootstrap
 *
 * Initializes the theme and loads all modular components.
 * This file serves as the entry point for all theme functionality.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package astra-rise
 * @since 1.0.0
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define Theme Constants
 *
 * These constants are used throughout the theme for versioning,
 * path references, and URI construction.
 */
$astra_rise_theme = wp_get_theme( get_stylesheet() );

define( 'ASTRA_RISE_VERSION', $astra_rise_theme->get( 'Version' ) ?: '1.0.0' );
define( 'ASTRA_RISE_MIN_PHP', '7.4' );
define( 'ASTRA_RISE_MIN_WP', '6.2' );
define( 'ASTRA_RISE_DIR', get_stylesheet_directory() );
define( 'ASTRA_RISE_URI', get_stylesheet_directory_uri() );

/**
 * Theme Requirements Check
 *
 * Ensures WordPress version and PHP version meet minimum requirements.
 */
function astra_rise_requirements_check() {
	global $wp_version;

	if ( version_compare( $wp_version, ASTRA_RISE_MIN_WP, '<' ) || version_compare( PHP_VERSION, ASTRA_RISE_MIN_PHP, '<' ) ) {
		add_action(
			'admin_notices',
			static function() {
				printf(
					'<div class="notice notice-error"><p>%s</p></div>',
					esc_html(
						sprintf(
							__( 'Astra Rise requires WordPress %s+ and PHP %s+.', 'astra-rise' ),
							ASTRA_RISE_MIN_WP,
							ASTRA_RISE_MIN_PHP
						)
					)
				);
			}
		);
		return false;
	}

	return true;
}

if ( ! astra_rise_requirements_check() ) {
	return;
}

/**
 * Load Theme Modules
 *
 * Modular architecture allows for easier maintenance, testing, and feature toggling.
 * Each file handles a specific concern (assets, setup, Spectra, etc.).
 */
require_once ASTRA_RISE_DIR . '/inc/helpers.php';
require_once ASTRA_RISE_DIR . '/inc/setup.php';
require_once ASTRA_RISE_DIR . '/inc/enqueue-scripts.php';
require_once ASTRA_RISE_DIR . '/inc/custom-hooks.php';
require_once ASTRA_RISE_DIR . '/inc/palette.php';
require_once ASTRA_RISE_DIR . '/inc/spectra-styles.php';
require_once ASTRA_RISE_DIR . '/inc/patterns.php';
require_once ASTRA_RISE_DIR . '/inc/customizer.php';
require_once ASTRA_RISE_DIR . '/inc/migrate.php';
require_once ASTRA_RISE_DIR . '/inc/admin-tools.php';
