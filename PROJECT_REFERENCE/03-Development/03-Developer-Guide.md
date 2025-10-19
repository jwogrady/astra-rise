# Astra Rise Theme - Developer Guide

## Overview

This guide provides comprehensive documentation for developers working with the Astra Rise child theme. It covers the modular architecture, development workflow, and best practices.

## Table of Contents

1. [Architecture](#architecture)
2. [Development Workflow](#development-workflow)
3. [Code Quality](#code-quality)
4. [Performance Optimization](#performance-optimization)
5. [Extending the Theme](#extending-the-theme)
6. [Troubleshooting](#troubleshooting)

---

## Architecture

### File Organization

```
astra-rise/
├── functions.php                    # Main theme bootstrap
├── style.css                        # Theme metadata + minimal CSS
├── theme.json                       # FSE configuration (WP 6.2+)
├── inc/
│   ├── helpers.php                  # Utility functions
│   ├── setup.php                    # Theme setup & feature flags
│   ├── enqueue-scripts.php          # Asset loading
│   ├── custom-hooks.php             # Astra/custom hooks
│   ├── palette.php                  # Color palette & gradients
│   ├── spectra-styles.php           # Spectra block customization
│   ├── patterns.php                 # Block pattern registration
│   ├── customizer.php               # Customizer sections
│   ├── migrate.php                  # Version migrations
│   └── admin-tools.php              # Admin utilities
├── assets/
│   ├── css/
│   │   ├── brand.css                # Brand variables & styles
│   │   ├── fonts.css                # Font-face definitions
│   │   └── spectra.css              # Spectra block styles
│   ├── fonts/                       # WOFF2 font files
│   └── js/
│       └── smooth-scroll.js         # Utility script
├── patterns/
│   ├── hero-section.php
│   ├── service-cards.php
│   ├── cta-section.php
│   └── typography-showcase.php
├── phpcs.xml                        # PHP Code Sniffer config
├── package.json                     # npm scripts & dependencies
└── .githooks/
    └── pre-commit                   # Git pre-commit hook

```

### Key Concepts

#### Modular Loading

Each `/inc` file handles a specific concern:
- **helpers.php** - Reusable utility functions
- **setup.php** - WordPress feature support
- **enqueue-scripts.php** - Frontend assets
- **spectra-styles.php** - Block customization

This separation makes the codebase easier to maintain and test.

#### Constants

Theme constants defined in `functions.php`:

```php
ASTRA_RISE_VERSION      // Current theme version
ASTRA_RISE_MIN_PHP      // Minimum PHP version (7.4)
ASTRA_RISE_MIN_WP       // Minimum WordPress version (6.2)
ASTRA_RISE_DIR          // Absolute path to theme
ASTRA_RISE_URI          // Theme URL
```

#### Hook Points

- **WordPress Hooks:** `wp_enqueue_scripts`, `after_setup_theme`, `customize_register`
- **Astra Hooks:** `astra_header_before`, `astra_footer_after`, `astra_entry_content_before`
- **Custom Hooks:** `astra_rise_init`, `astra_rise_register_block_styles`

---

## Development Workflow

### Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/jwogrady/astra-rise.git
   cd astra-rise
   ```

2. **Install Dependencies**
   
   **For CSS/JS build tools:**
   ```bash
   bun install
   # or npm install
   ```
   
   **For PHP linting (PHPCS):**
   ```bash
   composer install
   ```
   
   **Both (recommended):**
   ```bash
   bun install && composer install
   ```

3. **Configure Git Hooks**
   ```bash
   chmod +x .githooks/pre-commit
   git config core.hooksPath .githooks
   ```

4. **Activate the Theme**
   - Ensure Astra parent theme is installed
   - Go to WordPress Admin > Appearance > Themes
   - Activate "Astra Rise"

### Local Development

**Edit Files:**
- All PHP files are in `/inc` and `functions.php`
- CSS files in `/assets/css/`
- JavaScript in `/assets/js/`

**Minify Assets** (before deployment):
```bash
npm run build
```

**Run Code Quality Checks:**
```bash
npm run lint          # Check for issues
npm run lint:fix      # Fix automatically
```

**Watch for Changes** (optional):
```bash
npm run watch
```

### Git Workflow

1. Create a feature branch:
   ```bash
   git checkout -b feature/my-feature
   ```

2. Make changes and commit:
   ```bash
   git add .
   git commit -m "Add my feature"
   ```
   The pre-commit hook will run PHPCS automatically.

3. If PHPCS fails, fix issues:
   ```bash
   composer run-script lint:fix
   git add .
   git commit -m "Add my feature"
   ```

4. Push and create a pull request:
   ```bash
   git push origin feature/my-feature
   ```

---

## Code Quality

### PHP Coding Standards

The theme follows [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/).

**Key Rules:**
- Function/class names use snake_case with `astra_rise_` prefix
- 1 space indentation (tabs)
- No trailing whitespace
- Always use single quotes for strings (unless interpolation needed)
- Always escape output, sanitize input

**Example Function:**
```php
/**
 * Example Helper Function
 *
 * This is what a properly formatted function looks like.
 *
 * @param string $text Input text.
 * @return string Escaped output.
 *
 * @since 1.0.0
 */
function astra_rise_example_helper( $text ) {
	$text = sanitize_text_field( $text );
	return esc_html( $text );
}
```

### Running PHPCS

Install composer first:
```bash
composer install
```

**Check specific files:**
```bash
composer run-script lint
```

**Check all files:**
```bash
composer run-script lint
```

**Auto-fix issues:**
```bash
composer run-script lint:fix
```

### Security Best Practices

1. **Always Escape Output:**
   ```php
   echo esc_html( $variable );           // HTML content
   echo esc_attr( $variable );           // HTML attributes
   echo esc_url( $variable );            // URLs
   echo wp_kses_post( $html );           // Allow safe HTML tags
   ```

2. **Always Sanitize Input:**
   ```php
   $text = sanitize_text_field( $_POST['text'] );
   $email = sanitize_email( $_POST['email'] );
   $id = absint( $_POST['id'] );
   ```

3. **Check Capabilities:**
   ```php
   if ( ! current_user_can( 'edit_theme_options' ) ) {
       wp_die( __( 'Insufficient permissions.', 'astra-rise' ) );
   }
   ```

4. **Verify Nonces:**
   ```php
   if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'astra_rise_action' ) ) {
       wp_die( __( 'Nonce verification failed.', 'astra-rise' ) );
   }
   ```

---

## Performance Optimization

### Asset Loading

**Conditional CSS Loading:**
Only load Spectra CSS when Spectra blocks are present:

```php
if ( astra_rise_has_block( 'uagb/button' ) ) {
    wp_enqueue_style( 'astra-rise-spectra', ... );
}
```

**Font Optimization:**
- Self-hosted fonts (WOFF2) preferred
- Google Fonts fallback
- Critical fonts preloaded in `<head>`

**Resource Hints:**
```php
// Preconnect to Google Fonts
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

// DNS prefetch
<link rel="dns-prefetch" href="//fonts.googleapis.com">
```

### CSS Variables

Use CSS variables instead of inline styles:

```css
/* Good: Single source of truth */
:root {
    --rise-blue: #3B82F6;
    --rise-space-lg: 2rem;
}

.button {
    background: var(--rise-blue);
    padding: var(--rise-space-lg);
}

/* Avoid: Inline styles */
<button style="background: #3B82F6; padding: 2rem;">Click</button>
```

### Minification

Minify CSS and JavaScript before deployment:

```bash
npm run build
```

This creates minified versions for production use.

---

## Extending the Theme

### Adding a Custom Block Style

1. **Register the Style** (in `inc/spectra-styles.php`):
   ```php
   register_block_style( 'uagb/button', array(
       'name'  => 'my-custom-button',
       'label' => __( 'My Custom Button', 'astra-rise' ),
   ) );
   ```

2. **Add CSS** (in `inc/spectra-styles.php` or `assets/css/spectra.css`):
   ```css
   .is-style-my-custom-button .wp-block-uagb-button__link {
       background: linear-gradient(135deg, #3b82f6 0%, #ffb457 100%);
       /* Add more styles */
   }
   ```

3. **Use in Editor:**
   - Open block in Gutenberg
   - Click "Styles" → Select "My Custom Button"

### Adding a Custom Customizer Section

1. **Create a new function** (in `inc/customizer.php`):
   ```php
   $wp_customize->add_section( 'rise_my_section', array(
       'title'    => __( 'My Custom Section', 'astra-rise' ),
       'panel'    => 'rise_local_brand',
       'priority' => 30,
   ) );

   $wp_customize->add_setting( 'rise_my_setting', array(
       'default'           => 'default_value',
       'sanitize_callback' => 'sanitize_text_field',
       'type'              => 'theme_mod',
   ) );

   $wp_customize->add_control( 'rise_my_setting', array(
       'label'   => __( 'My Setting', 'astra-rise' ),
       'section' => 'rise_my_section',
       'type'    => 'text',
   ) );
   ```

2. **Retrieve the value in templates:**
   ```php
   $value = get_theme_mod( 'rise_my_setting', 'default_value' );
   echo esc_html( $value );
   ```

### Adding a Block Pattern

1. **Create pattern file** (in `patterns/my-pattern.php`):
   ```php
   <?php
   return array(
       'title'      => __( 'My Pattern', 'astra-rise' ),
       'categories' => array( 'rise-local' ),
       'content'    => '<!-- wp:group {"layout":{"type":"default"}} -->
           <div class="wp-block-group">
               <!-- wp:heading -->
               <h2>My Pattern Content</h2>
               <!-- /wp:heading -->
           </div>
           <!-- /wp:group -->',
   );
   ```

2. **Register in `inc/patterns.php`:**
   ```php
   $patterns = array(
       'astra-rise/my-pattern' => 'my-pattern.php',
   );
   ```

### Adding a Custom Helper Function

1. **Create in `inc/helpers.php`:**
   ```php
   /**
    * My Custom Helper
    *
    * @param string $value Input value.
    * @return string Output.
    * @since 1.0.0
    */
   function astra_rise_my_helper( $value ) {
       return apply_filters( 'astra_rise_my_helper', $value );
   }
   ```

2. **Use throughout the theme:**
   ```php
   $result = astra_rise_my_helper( 'my_value' );
   ```

---

## Troubleshooting

### Parent Theme Not Found

**Error:** "Astra Rise child theme requires the Astra parent theme"

**Solution:**
1. Install Astra from wordpress.org/themes/astra
2. Activate Astra parent theme
3. Then activate Astra Rise child theme

### PHPCS Not Running

**Error:** "phpcs: command not found"

**Solution:**
```bash
npm install
npm run lint
```

### Assets Not Loading

**Issue:** CSS/JS not appearing on frontend

**Checklist:**
1. Verify handles in `wp_enqueue_style()` and `wp_enqueue_script()`
2. Check dependencies are correct (parent theme handle `astra-theme-css`)
3. Verify file paths use `ASTRA_RISE_URI` constant
4. Check browser console for 404 errors
5. Disable caching plugins temporarily

### Styles Not Applying to Spectra Blocks

**Issue:** Custom block styles not visible

**Checklist:**
1. Verify block style registered: `register_block_style()`
2. Check block style slug matches CSS class: `.is-style-{slug}`
3. Clear WordPress cache: Settings > Astra > Tools > Clear Cache
4. Regenerate Spectra CSS: Settings > Spectra > Tools
5. Test in Incognito mode (browser cache)

### Functions Not Available

**Error:** "Call to undefined function astra_rise_..."

**Checklist:**
1. Verify function defined in `/inc` file
2. Check file is included in `functions.php`
3. Verify function name spelled correctly
4. Check function not inside conditional that's false
5. Clear WordPress object cache if using caching plugin

---

## Resources

- [WordPress Theme Development](https://developer.wordpress.org/themes/)
- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Astra Documentation](https://docs.astra.build/)
- [Spectra Documentation](https://docs.brainstormforce.com/spectra/)

---

**Last Updated:** October 2025
**Theme Version:** 1.0.0
**Maintained By:** Rise Local
