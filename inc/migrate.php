<?php
/**
 * One-time migrations and safe cache clears on version change
 * @package astra-rise
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Run migrations from one version to another.
 * Keep this idempotent and non-destructive.
 */
function astra_rise_run_migrations( $from, $to ) {
    // 1) Remove deprecated theme_mod keys (explicit list only)
    $deprecated_mods = array(
        // 'rise_old_option_1',
        // 'rise_old_option_2',
    );
    foreach ( $deprecated_mods as $key ) {
        if ( get_theme_mod( $key, null ) !== null ) {
            remove_theme_mod( $key );
        }
    }

    // 2) Clear Astra dynamic CSS/cache if available
    if ( function_exists( 'astra_clear_cache' ) ) {
        // Clears Astra-generated CSS caches
        astra_clear_cache();
    }

    // 3) Any additional version-specific tasks can go here
    // if ( version_compare( $from, '1.1.0', '<' ) ) { /* ... */ }
}

/**
 * Record version and trigger migrations after switching theme.
 */
function astra_rise_maybe_migrate_after_switch() {
    $current = defined( 'CHILD_THEME_ASTRA_RISE_VERSION' ) ? CHILD_THEME_ASTRA_RISE_VERSION : '0';
    $last    = get_option( 'astra_rise_last_version', '0' );

    if ( version_compare( $current, $last, '>' ) ) {
        astra_rise_run_migrations( $last, $current );
        update_option( 'astra_rise_last_version', $current );
    }
}
add_action( 'after_switch_theme', 'astra_rise_maybe_migrate_after_switch' );

/**
 * Fallback check during admin load (covers updates without theme switch).
 */
function astra_rise_maybe_migrate_admin() {
    if ( ! is_admin() ) {
        return;
    }
    $current = defined( 'CHILD_THEME_ASTRA_RISE_VERSION' ) ? CHILD_THEME_ASTRA_RISE_VERSION : '0';
    $last    = get_option( 'astra_rise_last_version', '0' );

    if ( version_compare( $current, $last, '>' ) ) {
        astra_rise_run_migrations( $last, $current );
        update_option( 'astra_rise_last_version', $current );
    }
}
add_action( 'admin_init', 'astra_rise_maybe_migrate_admin' );
