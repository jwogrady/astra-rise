<?php
/**
 * Register block patterns shipped with the theme
 * @package astra-rise
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function astra_rise_register_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category( 'rise-local', array( 'label' => __( 'Rise Local', 'astra-rise' ) ) );
    }

    $patterns = array(
        'astra-rise/hero-section'          => 'hero-section.php',
        'astra-rise/service-cards'         => 'service-cards.php',
        'astra-rise/cta-section'           => 'cta-section.php',
        'astra-rise/typography-showcase'   => 'typography-showcase.php',
    );

    foreach ( $patterns as $name => $file ) {
        $path = ASTRA_RISE_DIR . '/patterns/' . $file;
        if ( file_exists( $path ) ) {
            $config = include $path;
            if ( is_array( $config ) ) {
                register_block_pattern( $name, $config );
            }
        }
    }
}
add_action( 'init', 'astra_rise_register_patterns' );
