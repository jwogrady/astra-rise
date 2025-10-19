<?php
/**
 * astra-rise Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-rise
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_RISE_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

    wp_enqueue_style( 'astra-rise-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_RISE_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/**
 * Register Rise Local brand color palette for the block editor
 * and expose the same colors as CSS custom properties on the frontend.
 *
 * Replace the hex values below with your actual brand colors.
 */
function astra_rise_register_color_palette() {

    // Editor palette for Gutenberg / block editor
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name'  => 'Rise Blue',
                'slug'  => 'rise-blue',
                'color' => '#0055B8',
            ),
            array(
                'name'  => 'Rise Teal',
                'slug'  => 'rise-teal',
                'color' => '#00A79D',
            ),
            array(
                'name'  => 'Rise Orange',
                'slug'  => 'rise-orange',
                'color' => '#F26B38',
            ),
            array(
                'name'  => 'Rise Gray',
                'slug'  => 'rise-gray',
                'color' => '#6B7280',
            ),
            array(
                'name'  => 'Rise White',
                'slug'  => 'rise-white',
                'color' => '#FFFFFF',
            ),
        )
    );

    // Optional: disable custom colors in the editor to enforce the palette
    // add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'astra_rise_register_color_palette' );

/**
 * Output the same brand colors as CSS variables so themes/blocks can use them on the frontend.
 * Attaches inline style to the child theme stylesheet handle enqueued above.
 */
function astra_rise_color_variables() {
    $css = '
        :root{
            --rise-blue: #0055B8;
            --rise-teal: #00A79D;
            --rise-orange: #F26B38;
            --rise-gray: #6B7280;
            --rise-white: #FFFFFF;
        }
    ';
    wp_add_inline_style( 'astra-rise-theme-css', $css );
}
add_action( 'wp_enqueue_scripts', 'astra_rise_color_variables', 20 );