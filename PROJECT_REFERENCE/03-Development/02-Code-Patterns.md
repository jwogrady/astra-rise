# Astra Rise - Code Patterns & Examples

Quick reference guide for common development tasks and code patterns used throughout the theme.

---

## Table of Contents
- [Asset Loading](#asset-loading)
- [Block Detection](#block-detection)
- [Custom Settings](#custom-settings)
- [Output & Escaping](#output--escaping)
- [Spectra Integration](#spectra-integration)
- [Theme Hooks](#theme-hooks)
- [Common Tasks](#common-tasks)

---

## Asset Loading

### Enqueueing Styles
```php
wp_enqueue_style(
    'astra-rise-custom',                           // Handle
    ASTRA_RISE_URI . '/assets/css/custom.css',    // URL
    array( 'astra-theme-css' ),                    // Dependencies
    astra_rise_get_version()                       // Version (for cache busting)
);
```

### Enqueueing Scripts
```php
wp_enqueue_script(
    'astra-rise-custom',                           // Handle
    ASTRA_RISE_URI . '/assets/js/custom.js',      // URL
    array( 'jquery' ),                             // Dependencies
    astra_rise_get_version(),                      // Version
    true                                           // In footer
);
```

### Inline Styles
```php
wp_add_inline_style( 'astra-rise-custom', '
    :root {
        --rise-primary: #3B82F6;
    }
' );
```

### Inline Scripts
```php
wp_add_inline_script( 'astra-rise-custom', '
    console.log( "Custom script loaded" );
' );
```

### Font Loading
```php
// Check local fonts exist
if ( astra_rise_has_local_fonts() ) {
    wp_enqueue_style( 'astra-rise-fonts-local', ... );
} else {
    // Fallback to Google Fonts
    $fonts_url = astra_rise_get_google_fonts_url();
    if ( $fonts_url ) {
        wp_enqueue_style( 'astra-rise-fonts-google', $fonts_url );
    }
}
```

---

## Block Detection

### Check Single Block
```php
if ( astra_rise_has_block( 'uagb/button' ) ) {
    // Button block detected, load button styles
    wp_enqueue_style( 'astra-rise-button-styles' );
}
```

### Check Multiple Blocks
```php
if ( astra_rise_has_blocks( array( 'uagb/button', 'uagb/container' ) ) ) {
    // At least one of these blocks detected
    wp_enqueue_style( 'astra-rise-spectra-styles' );
}
```

### Common Spectra Blocks
```
uagb/button              // Button block
uagb/container           // Container block
uagb/heading             // Heading block
uagb/separator           // Separator block
uagb/icon                // Icon block
uagb/progress-bar        // Progress bar block
uagb/pricing             // Pricing table block
uagb/testimonial         // Testimonial block
uagb/team-member         // Team member block
```

---

## Custom Settings

### Add Customizer Section
```php
add_action( 'customize_register', function( $wp_customize ) {
    // Add section
    $wp_customize->add_section( 'astra_rise_custom', array(
        'title'       => __( 'Custom Section', 'astra-rise' ),
        'panel'       => 'rise_local_brand',  // Use existing panel
        'priority'    => 100,
    ) );

    // Add setting
    $wp_customize->add_setting( 'astra_rise_custom_option', array(
        'default'              => 'default_value',
        'sanitize_callback'    => 'sanitize_text_field',
        'transport'            => 'refresh',
    ) );

    // Add control
    $wp_customize->add_control( 'astra_rise_custom_option', array(
        'label'       => __( 'Custom Option', 'astra-rise' ),
        'section'     => 'astra_rise_custom',
        'type'        => 'text',
    ) );
} );
```

### Retrieve Theme Mod
```php
$value = get_theme_mod( 'astra_rise_custom_option', 'fallback_value' );
```

### Set Theme Mod (Programmatically)
```php
set_theme_mod( 'astra_rise_custom_option', 'new_value' );
```

---

## Output & Escaping

### HTML Content
```php
// For text content
echo esc_html( $text );

// For allowed HTML (use sparingly)
echo wp_kses_post( $html );

// Safe option values
echo esc_attr( $attribute );
```

### URLs
```php
// Link URLs
echo esc_url( $url );

// URL with query params
$link = add_query_arg( 'param', 'value', $url );
echo esc_url( $link );
```

### JavaScript
```php
// JS inline output
wp_add_inline_script( 'handle', sprintf(
    'var customData = %s;',
    wp_json_encode( $data )
) );
```

### Admin Output
```php
// Settings page output
echo esc_html( $setting );

// Rich content
wp_kses( $content, array(
    'p'      => array(),
    'strong' => array(),
    'em'     => array(),
) );
```

---

## Spectra Integration

### Register Block Style
```php
register_block_style( 'uagb/button', array(
    'name'       => 'rise-gradient',
    'label'      => __( 'Rise Gradient', 'astra-rise' ),
    'inline_style' => '/* CSS here */',
) );
```

### Add Inline Styles for Block
```php
$inline_css = '
    .wp-block-uagb-button .wp-block-button__link.is-style-rise-gradient {
        background: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px rgba(59, 130, 246, 0.3);
    }
';

wp_add_inline_style( 'astra-rise-spectra', $inline_css );
```

### Check Spectra Active
```php
if ( astra_rise_is_spectra_active() ) {
    // Spectra plugin is active
    wp_enqueue_style( 'astra-rise-spectra-custom-styles' );
}
```

### Full Example: Custom Block Style
```php
add_action( 'enqueue_block_assets', function() {
    if ( ! astra_rise_is_spectra_active() ) {
        return;
    }

    register_block_style( 'uagb/button', array(
        'name'  => 'rise-custom',
        'label' => __( 'Rise Custom', 'astra-rise' ),
    ) );

    $css = '
        .wp-block-uagb-button .is-style-rise-custom {
            background: #3B82F6;
            border-radius: 8px;
            padding: 12px 24px;
        }
    ';

    wp_add_inline_style( 'wp-block-library', $css );
} );
```

---

## Theme Hooks

### Use Custom Theme Hook
```php
// In a plugin or functions.php
add_action( 'astra_rise_init', function() {
    // Custom theme initialization code
    // This hook is fired in functions.php after all modules loaded
} );
```

### Call Custom Hook
```php
// In theme code (e.g., template file)
do_action( 'astra_rise_init' );

// With parameters
do_action( 'astra_rise_register_block_styles', $blocks );

// Get return value
$result = apply_filters( 'astra_rise_custom_filter', $default_value );
```

### Integrate with Astra Parent Hooks
```php
add_action( 'astra_header_before', function() {
    // Code before Astra header
} );

add_action( 'astra_footer_after', function() {
    // Code after Astra footer
} );

add_filter( 'astra_entry_content_after', function( $content ) {
    // Modify post content
    return $content . '<!-- Custom content -->';
} );
```

---

## Common Tasks

### Create Helper Function
```php
/**
 * Get custom option with fallback
 *
 * @param string $option Option name.
 * @param mixed  $default Default value.
 * @return mixed Option value or default.
 */
function astra_rise_get_custom_option( $option, $default = '' ) {
    return get_theme_mod( 'astra_rise_' . $option, $default );
}
```

### Conditional Feature Loading
```php
// Load feature only if condition met
if ( is_page() && ! is_home() ) {
    wp_enqueue_script( 'astra-rise-page-feature' );
}

// Load only for specific post type
if ( is_singular( 'post' ) ) {
    wp_enqueue_style( 'astra-rise-post-styles' );
}

// Load only for admin users
if ( current_user_can( 'manage_options' ) ) {
    wp_enqueue_script( 'astra-rise-admin-feature' );
}
```

### Add Reusable CSS Variables
```php
// In brand.css or as inline style
:root {
    /* Primary Colors */
    --rise-blue: #3B82F6;
    --rise-blue-dark: #1E40AF;
    --rise-blue-light: #DBEAFE;
    
    /* Gradients */
    --rise-gradient-primary: linear-gradient(135deg, #3B82F6 0%, #1E40AF 100%);
    
    /* Spacing */
    --rise-spacing-xs: 0.5rem;
    --rise-spacing-sm: 1rem;
    --rise-spacing-md: 1.5rem;
    
    /* Fonts */
    --rise-font-family: 'Inter', sans-serif;
    --rise-font-size-base: 16px;
}
```

### Use CSS Variables in Styles
```css
.button {
    background: var(--rise-blue);
    padding: var(--rise-spacing-md);
    font-family: var(--rise-font-family);
    transition: background 0.3s ease;
}

.button:hover {
    background: var(--rise-blue-dark);
}
```

### Create Pattern
```php
// In inc/patterns.php
register_block_pattern(
    'astra-rise/custom-pattern',
    array(
        'title'       => __( 'Custom Pattern', 'astra-rise' ),
        'description' => __( 'Custom pattern description', 'astra-rise' ),
        'content'     => '<!-- wp:paragraph -->
<p>Pattern content here</p>
<!-- /wp:paragraph -->',
        'categories'  => array( 'rise-local' ),
        'keywords'    => array( 'custom', 'pattern' ),
    )
);
```

### Register Image Size
```php
add_image_size( 'rise-hero', 1920, 1080, true );
add_image_size( 'rise-service-card', 400, 300, true );
add_image_size( 'rise-testimonial', 150, 150, true );
```

### Add Body Class
```php
add_filter( 'body_class', function( $classes ) {
    if ( has_post_thumbnail() ) {
        $classes[] = 'has-featured-image';
    }
    
    if ( is_singular( 'page' ) ) {
        $classes[] = 'page-layout';
    }
    
    return $classes;
} );
```

### Minify Inline CSS
```php
// Before minification
$css = '
    .button {
        background: #3B82F6;
        padding: 12px 24px;
        border-radius: 4px;
    }
';

// After minification (remove newlines/spaces)
$css = '.button{background:#3B82F6;padding:12px 24px;border-radius:4px}';

wp_add_inline_style( 'astra-rise-theme', $css );
```

### Cache Busting with File Modification Time
```php
function astra_rise_get_version() {
    // Use file modification time for better cache busting
    static $version = null;
    
    if ( null === $version ) {
        $style_path = ASTRA_RISE_DIR . '/style.css';
        $version = filemtime( $style_path );
    }
    
    return $version;
}
```

### Debug: Output Debug Information
```php
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    error_log( 'Astra Rise: ' . print_r( $data, true ) );
}
```

### Check Parent Theme
```php
$parent_theme = wp_get_theme( get_template() );

if ( 'Astra' !== $parent_theme->get( 'Name' ) ) {
    wp_die( __( 'Astra Rise requires the Astra parent theme.', 'astra-rise' ) );
}
```

---

## Performance Patterns

### Lazy Load Heavy Assets
```php
if ( astra_rise_has_block( 'uagb/pricing' ) ) {
    // Only load pricing styles if pricing block is on page
    wp_enqueue_style( 'astra-rise-pricing-styles' );
}
```

### Preload Critical Resources
```php
add_action( 'wp_head', function() {
    echo '<link rel="preload" as="font" href="' . esc_url( ASTRA_RISE_URI . '/assets/fonts/Inter-Regular.woff2' ) . '" type="font/woff2" crossorigin>';
}, 5 );
```

### Reduce CSS Payload
```php
// Use CSS variables instead of duplicated values
:root {
    --primary-color: #3B82F6;
}

.button-primary { color: var(--primary-color); }
.text-primary { color: var(--primary-color); }
.border-primary { border-color: var(--primary-color); }
```

---

## Security Patterns

### Verify User Capability
```php
if ( ! current_user_can( 'edit_theme_options' ) ) {
    return;
}
```

### Verify Admin Page
```php
if ( ! is_admin() ) {
    return;
}
```

### Escape All Output
```php
// HTML content
echo esc_html( $content );

// HTML attributes
echo esc_attr( $attribute );

// URLs
echo esc_url( $url );

// Complete HTML
echo wp_kses_post( $html );
```

### Sanitize All Input
```php
// Text input
$text = sanitize_text_field( $_POST['text'] );

// Email input
$email = sanitize_email( $_POST['email'] );

// Integer input
$id = absint( $_POST['id'] );

// URL input
$url = esc_url_raw( $_POST['url'] );
```

### Use Nonces
```php
// Create nonce
$nonce = wp_create_nonce( 'astra_rise_action' );

// Verify nonce
if ( ! wp_verify_nonce( $_POST['nonce'], 'astra_rise_action' ) ) {
    wp_die( 'Nonce verification failed' );
}
```

---

**Code Patterns Version:** 1.0.0
**Last Updated:** October 19, 2025
**Status:** Production Ready ✅

*For architectural overview, see ARCHITECTURE.md*
*For project status, see PROJECT_OVERVIEW.md*
