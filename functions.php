<?php
/**
 * astra-rise Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-rise
 * @since 1.0.0
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Define Constants
 */
// Resolve version dynamically from style.css to ensure updates overwrite properly
$astra_rise_theme = wp_get_theme( get_stylesheet() );
define( 'CHILD_THEME_ASTRA_RISE_VERSION', $astra_rise_theme->get( 'Version' ) ?: '1.0.0' );
define( 'RISE_THEME_DIR', get_stylesheet_directory() );
define( 'RISE_THEME_URI', get_stylesheet_directory_uri() );

/**
 * Rise Local Brand Configuration
 */
class Rise_Local_Brand {
    
    /**
     * Brand color palette configuration
     */
    private static $brand_colors = array(
        // Primary Colors
        'rise-black'       => array( 'name' => 'Rise Black', 'color' => '#000000' ),
        'rise-white'       => array( 'name' => 'Rise White', 'color' => '#FFFFFF' ),
        'rise-gray'        => array( 'name' => 'Rise Gray', 'color' => '#696A6D' ),
        
        // Secondary Color
        'rise-blue'        => array( 'name' => 'Rise Blue', 'color' => '#3D86D5' ),
        
        // Enhanced UI Colors
        'rise-blue-dark'   => array( 'name' => 'Rise Blue Dark', 'color' => '#2C6BB4' ),
        'rise-blue-light'  => array( 'name' => 'Rise Blue Light', 'color' => '#5EA0EA' ),
        'rise-background'  => array( 'name' => 'Rise Background', 'color' => '#F6F7F9' ),
        'rise-orange-accent' => array( 'name' => 'Rise Orange Accent', 'color' => '#F2A74B' ),
    );
    
    /**
     * Brand gradients configuration
     */
    private static $brand_gradients = array(
        'rise-blue-gradient'    => array( 'name' => 'Rise Blue Gradient', 'gradient' => 'linear-gradient(135deg, #3D86D5 0%, #2C6BB4 100%)' ),
        'rise-professional'     => array( 'name' => 'Rise Professional', 'gradient' => 'linear-gradient(135deg, #000000 0%, #696A6D 100%)' ),
        'rise-accent'           => array( 'name' => 'Rise Accent', 'gradient' => 'linear-gradient(135deg, #3D86D5 0%, #F2A74B 100%)' ),
    );
    
    /**
     * Initialize the class
     */
    public static function init() {
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ), 15 );
        add_action( 'after_setup_theme', array( __CLASS__, 'setup_theme_support' ) );
        add_action( 'after_setup_theme', array( __CLASS__, 'setup_color_palette' ) );
        add_action( 'init', array( __CLASS__, 'register_block_patterns' ) );
        add_action( 'send_headers', array( __CLASS__, 'security_headers' ) );
        add_filter( 'body_class', array( __CLASS__, 'body_classes' ) );
        add_action( 'wp_footer', array( __CLASS__, 'footer_scripts' ) );
        
        // Admin-only features
        if ( is_admin() ) {
            add_action( 'customize_register', array( __CLASS__, 'customize_register' ) );
        }
        
        // Performance optimizations
        self::cleanup_wp_head();
    }
    
    /**
     * Enqueue optimized assets
     */
    public static function enqueue_assets() {
        // Google Fonts - optimized loading
        $google_fonts_url = add_query_arg( array(
            'family' => 'Montserrat:wght@100;200;400;600;800|Permanent+Marker:wght@400',
            'display' => 'swap',
        ), 'https://fonts.googleapis.com/css2' );
        
        wp_enqueue_style( 'rise-google-fonts', $google_fonts_url, array(), null );
        
        // Child theme CSS
        wp_enqueue_style( 'astra-rise-theme-css', 
            RISE_THEME_URI . '/style.css', 
            array( 'astra-theme-css' ), 
            CHILD_THEME_ASTRA_RISE_VERSION, 
            'all' 
        );
        
        // Brand CSS - separate file for better caching
        wp_enqueue_style( 'rise-brand-css', 
            RISE_THEME_URI . '/assets/css/brand.css', 
            array( 'astra-rise-theme-css' ), 
            CHILD_THEME_ASTRA_RISE_VERSION, 
            'all' 
        );
        
        // Smooth scroll JS - optimized loading
        wp_enqueue_script( 'rise-smooth-scroll', 
            RISE_THEME_URI . '/assets/js/smooth-scroll.js', 
            array(), 
            CHILD_THEME_ASTRA_RISE_VERSION, 
            true 
        );
    }
    
    /**
     * Setup theme support features
     */
    public static function setup_theme_support() {
        // Core theme supports
        $theme_supports = array(
            'custom-logo' => array(
                'height'      => 100,
                'width'       => 300,
                'flex-height' => true,
                'flex-width'  => true,
                'header-text' => array( 'site-title', 'site-description' ),
            ),
            'post-thumbnails' => true,
            'custom-header' => array(
                'default-image'      => '',
                'default-text-color' => '000000',
                'width'              => 1920,
                'height'             => 600,
                'flex-height'        => true,
                'flex-width'         => true,
                'uploads'            => true,
            ),
            'custom-background' => array(
                'default-color' => 'F6F7F9',
                'default-image' => '',
            ),
            'align-wide' => true,
            'responsive-embeds' => true,
            'editor-styles' => true,
            'html5' => array(
                'search-form', 'comment-form', 'comment-list', 
                'gallery', 'caption', 'script', 'style',
            ),
        );
        
        foreach ( $theme_supports as $feature => $args ) {
            if ( $args === true ) {
                add_theme_support( $feature );
            } else {
                add_theme_support( $feature, $args );
            }
        }
        
        // Add editor style
        add_editor_style( 'assets/css/brand.css' );
        
        // Add custom image sizes
        $image_sizes = array(
            'rise-hero' => array( 1920, 600, true ),
            'rise-service-card' => array( 400, 300, true ),
            'rise-testimonial' => array( 150, 150, true ),
            'rise-team-member' => array( 300, 300, true ),
        );
        
        foreach ( $image_sizes as $name => $args ) {
            add_image_size( $name, $args[0], $args[1], $args[2] );
        }
    }
    
    /**
     * Setup color palette from configuration
     */
    public static function setup_color_palette() {
        // Build color palette array
        $color_palette = array();
        foreach ( self::$brand_colors as $slug => $config ) {
            $color_palette[] = array(
                'name'  => $config['name'],
                'slug'  => $slug,
                'color' => $config['color'],
            );
        }
        
        add_theme_support( 'editor-color-palette', $color_palette );
        
        // Build gradients array
        $gradient_palette = array();
        foreach ( self::$brand_gradients as $slug => $config ) {
            $gradient_palette[] = array(
                'name'     => $config['name'],
                'gradient' => $config['gradient'],
                'slug'     => $slug,
            );
        }
        
        add_theme_support( 'editor-gradient-presets', $gradient_palette );
    }
    
    /**
     * Register block patterns from separate files
     */
    public static function register_block_patterns() {
        if ( ! function_exists( 'register_block_pattern' ) ) {
            return;
        }
        
        // Register pattern category
        if ( function_exists( 'register_block_pattern_category' ) ) {
            register_block_pattern_category( 'rise-local', array( 
                'label' => __( 'Rise Local', 'astra-rise' ) 
            ));
        }
        
        // Load patterns from separate files
        $patterns = array(
            'astra-rise/hero-section'      => 'hero-section.php',
            'astra-rise/service-cards'     => 'service-cards.php',
            'astra-rise/cta-section'       => 'cta-section.php',
            'astra-rise/typography-showcase' => 'typography-showcase.php',
        );
        
        foreach ( $patterns as $pattern_name => $file ) {
            $pattern_file = RISE_THEME_DIR . '/patterns/' . $file;
            if ( file_exists( $pattern_file ) ) {
                $pattern_config = include $pattern_file;
                if ( is_array( $pattern_config ) ) {
                    register_block_pattern( $pattern_name, $pattern_config );
                }
            }
        }
    }
    
    /**
     * Optimized security headers
     */
    public static function security_headers() {
        if ( is_admin() || wp_doing_ajax() ) {
            return;
        }
        
        // Modern security headers
        if ( ! headers_sent() ) {
            header( 'X-Content-Type-Options: nosniff', true );
            header( 'X-Frame-Options: SAMEORIGIN', true );
            header( 'Referrer-Policy: strict-origin-when-cross-origin', true );
        }
    }
    
    /**
     * Add custom body classes
     */
    public static function body_classes( $classes ) {
        $classes[] = 'rise-local-theme';
        
        if ( has_custom_logo() ) {
            $classes[] = 'has-custom-logo';
        }
        
        return $classes;
    }
    
    /**
     * Footer scripts - ensures proper loading order
     */
    public static function footer_scripts() {
        // Only load if smooth scroll script is enqueued
        if ( ! wp_script_is( 'rise-smooth-scroll', 'enqueued' ) ) {
            return;
        }
        
        // Additional initialization if needed
        echo '<script>/* Rise Local theme initialized */</script>';
    }
    
    /**
     * Cleanup WordPress head
     */
    private static function cleanup_wp_head() {
        remove_action( 'wp_head', 'wp_generator' );
        remove_action( 'wp_head', 'wp_shortlink_wp_head' );
        remove_action( 'wp_head', 'rsd_link' );
        remove_action( 'wp_head', 'wlwmanifest_link' );
    }
    
    /**
     * Customizer configuration (admin only)
     */
    public static function customize_register( $wp_customize ) {
        // Rise Local Brand Panel
        $wp_customize->add_panel( 'rise_local_brand', array(
            'title'       => __( 'Rise Local Branding', 'astra-rise' ),
            'description' => __( 'Customize Rise Local brand elements', 'astra-rise' ),
            'priority'    => 30,
        ));
        
        // Business Information Section
        $wp_customize->add_section( 'rise_business_info', array(
            'title'    => __( 'Business Information', 'astra-rise' ),
            'panel'    => 'rise_local_brand',
            'priority' => 10,
        ));
        
        // Business settings
        $business_settings = array(
            'rise_business_phone' => array( 'type' => 'tel', 'sanitize' => 'sanitize_text_field' ),
            'rise_business_email' => array( 'type' => 'email', 'sanitize' => 'sanitize_email' ),
        );
        
        foreach ( $business_settings as $setting_id => $config ) {
            $wp_customize->add_setting( $setting_id, array(
                'default'           => '',
                'sanitize_callback' => $config['sanitize'],
                'transport'         => 'refresh',
            ));
            
            $wp_customize->add_control( $setting_id, array(
                'label'   => ucwords( str_replace( array( 'rise_business_', '_' ), array( '', ' ' ), $setting_id ) ),
                'section' => 'rise_business_info',
                'type'    => $config['type'],
            ));
        }
    }
    
    /**
     * Helper function to get theme mods
     */
    public static function get_theme_mod( $setting, $default = '' ) {
        return get_theme_mod( $setting, $default );
    }
}

// Initialize the Rise Local Brand system
Rise_Local_Brand::init();