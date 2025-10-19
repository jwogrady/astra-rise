<?php
/**
 * Admin Tools: Reset Rise Local theme mods (rise_*) with confirm + nonce
 * @package astra-rise
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register a Tools page under Appearance
 */
function astra_rise_register_tools_page() {
    add_theme_page(
        __( 'Rise Local Tools', 'astra-rise' ),
        __( 'Rise Local Tools', 'astra-rise' ),
        'edit_theme_options',
        'rise-local-tools',
        'astra_rise_tools_page_html'
    );
}
add_action( 'admin_menu', 'astra_rise_register_tools_page' );

/**
 * Handle POST to reset theme mods
 */
function astra_rise_handle_reset_theme_mods() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_die( __( 'Insufficient permissions.', 'astra-rise' ) );
    }

    check_admin_referer( 'astra_rise_reset_theme_mods' );

    if ( empty( $_POST['confirm'] ) ) {
        wp_die( __( 'Confirmation checkbox not checked.', 'astra-rise' ) );
    }

    $mods    = get_theme_mods();
    $removed = 0;

    if ( is_array( $mods ) ) {
        foreach ( $mods as $key => $value ) {
            if ( 0 === strpos( $key, 'rise_' ) ) { // only our namespaced mods
                remove_theme_mod( $key );
                $removed++;
            }
        }
    }

    // Clear Astra caches if available
    if ( function_exists( 'astra_clear_cache' ) ) {
        astra_clear_cache();
    }

    $redirect = add_query_arg(
        array(
            'page'       => 'rise-local-tools',
            'rise_reset' => 1,
            'removed'    => $removed,
        ),
        admin_url( 'themes.php' )
    );

    wp_safe_redirect( $redirect );
    exit;
}
add_action( 'admin_post_astra_rise_reset_theme_mods', 'astra_rise_handle_reset_theme_mods' );

/**
 * Tools page output
 */
function astra_rise_tools_page_html() {
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Rise Local Tools', 'astra-rise' ); ?></h1>

        <?php if ( isset( $_GET['rise_reset'] ) ) :
            $removed = isset( $_GET['removed'] ) ? intval( $_GET['removed'] ) : 0; ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( sprintf( __( 'Reset complete. Removed %d Rise settings.', 'astra-rise' ), $removed ) ); ?></p>
            </div>
        <?php endif; ?>

        <h2><?php esc_html_e( 'Reset Rise Local Settings', 'astra-rise' ); ?></h2>
        <p><?php esc_html_e( 'This will delete only theme settings that start with "rise_" for the current theme. Content, menus, widgets, and other theme settings remain untouched.', 'astra-rise' ); ?></p>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="astra_rise_reset_theme_mods" />
            <?php wp_nonce_field( 'astra_rise_reset_theme_mods' ); ?>

            <label>
                <input type="checkbox" name="confirm" value="1" required />
                <?php esc_html_e( 'I understand this will delete Rise Local settings (rise_*) and cannot be undone.', 'astra-rise' ); ?>
            </label>

            <?php submit_button( __( 'Reset Rise Settings', 'astra-rise' ), 'delete' ); ?>
        </form>
    </div>
    <?php
}
