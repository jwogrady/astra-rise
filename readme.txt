=== Astra Rise ===
Contributors: jwogrady
Tags: astra, astra-child, spectra, local-business, blocks, gutenberg
Requires at least: 6.8
Tested up to: 6.8.3
Requires PHP: 8.0
Stable Tag: 1.1.3
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A modern, modular Astra child theme optimized for Spectra Blocks and local business websites.

== Description ==

Astra Rise is a production-ready Astra child theme designed for modern WordPress 6.2+ 
with Full Site Editing (FSE) support. It provides a professional foundation for building 
fast, accessible, and maintainable websites, with deep Spectra Blocks integration.

**Key Features:**
- 📦 Modular architecture for easy customization
- ⚡ Performance-optimized asset loading with conditional CSS/JS
- 🎨 Pre-built brand color palette and gradients
- 🧩 Spectra-specific block styles and optimizations
- 📱 Responsive design with modern CSS variables
- 🔒 Security-focused with proper escaping and sanitization
- 🌐 Internationalization-ready with translation support
- 📐 Gutenberg editor styles for visual parity
- ♿ WCAG-compliant HTML5 markup
- 🛠️ Developer-friendly with clean code and documentation

== Installation ==

1. Install the Astra parent theme from WordPress.org
2. Upload the astra-rise folder to `/wp-content/themes/`
3. Go to Appearance > Themes and activate "Astra Rise"
4. Customize via Appearance > Customize under "Rise Local Branding"

**Requirements:**
- WordPress 6.2 or later
- PHP 7.4 or later
- Astra theme (parent theme)
- Spectra Blocks (optional, but recommended)

== File Structure ==

```
astra-rise/
├── style.css                    # Theme header and minimal CSS
├── functions.php                # Theme bootstrap and module loader
├── theme.json                   # Block editor settings (WordPress 6.2+)
├── readme.txt                   # This file
├── screenshot.png               # Theme preview
├── assets/
│   ├── css/
│   │   ├── brand.css           # Brand colors, typography, UI variables
│   │   ├── fonts.css           # Local font definitions
│   │   └── spectra.css         # Spectra block customizations
│   ├── fonts/                   # Local font files (WOFF2)
│   └── js/
│       └── smooth-scroll.js    # Smooth scroll utility
└── inc/
    ├── helpers.php              # Utility functions
    ├── setup.php                # Theme setup & feature support
    ├── enqueue-scripts.php      # Asset loading & optimization
    ├── custom-hooks.php         # Custom WordPress/Astra hooks
    ├── palette.php              # Editor color palette
    ├── spectra-styles.php       # Spectra block styles & optimization
    ├── patterns.php             # Block pattern registration
    ├── customizer.php           # Customizer settings
    ├── migrate.php              # Version migrations
    └── admin-tools.php          # Admin utilities
```

== Customization ==

=== Brand Colors ===

All brand colors are defined in a single location for easy updates:

1. **theme.json** - Full Site Editing (FSE) settings
2. **assets/css/brand.css** - CSS variables used throughout the theme
3. **inc/palette.php** - Editor color palette configuration

To add a new color:
1. Update `theme.json` (settings.color.palette)
2. Update `assets/css/brand.css` (:root variables)
3. Update `inc/palette.php` ($colors array)

Example custom color:
```php
array(
    'name'  => __( 'Custom Red', 'astra-rise' ),
    'slug'  => 'rise-custom-red',
    'color' => '#E53E3E',
)
```

=== Adding Custom Fonts ===

**Using Google Fonts (default fallback):**
Fonts are defined in `inc/enqueue-scripts.php`. Update the `astra_rise_get_google_fonts_url()` 
function to add additional font families.

**Using Self-Hosted Local Fonts:**
1. Add .woff2 font files to `assets/fonts/`
2. Define font-face rules in `assets/css/fonts.css`
3. Update the `astra_rise_has_local_fonts()` function to check for new files

**Recommended Font Services:**
- Google Fonts (free, CDN-based)
- Font Squirrel (free, self-hosted)
- Bunny Fonts (privacy-focused alternative)

=== Spectra Customizations ===

**Custom Block Styles:**

The theme provides pre-built block styles for Spectra blocks:

1. **Rise Gradient** - Apply gradient fill to buttons
2. **Rise Outline** - Transparent button with brand border
3. **Rise Elevated Card** - Container with shadow and hover effect
4. **Rise Accent Underline** - Heading with decorative underline
5. **Rise Gradient Line** - Gradient separator/divider

To use custom block styles:
1. Open the block in Gutenberg
2. Click "Styles" in the block inspector
3. Select the desired style (e.g., "Rise Gradient")

**Registering New Spectra Styles:**

In `inc/spectra-styles.php`, add your custom style:

```php
register_block_style( 'uagb/button', array(
    'name'  => 'my-custom-button',
    'label' => __( 'My Custom Button', 'astra-rise' ),
) );
```

Then add corresponding CSS in `inc/spectra-styles.php` or `assets/css/spectra.css`:

```css
.is-style-my-custom-button .wp-block-uagb-button__link {
    /* Your custom styles */
}
```

**Conditional Asset Loading:**

Spectra CSS is only loaded when Spectra blocks are present on the page. 
This improves performance by avoiding unnecessary CSS downloads.

To customize which blocks trigger CSS loading, edit `inc/spectra-styles.php`:

```php
$spectra_blocks = array(
    'uagb/button',
    'uagb/container',
    // Add more block types as needed
);
```

=== Using Astra Hooks ===

The theme integrates with Astra parent theme hooks for deeper customization.

**Available Astra Hooks:**
- `astra_header_before` / `astra_header_after` - Hook into header section
- `astra_footer_before` / `astra_footer_after` - Hook into footer section
- `astra_entry_content_before` / `astra_entry_content_after` - Hook into post content
- `astra_masthead_primary_attr` - Modify header attributes

Example usage in a plugin or custom functions:

```php
add_action( 'astra_header_before', function() {
    echo '<div class="custom-banner">Announcement</div>';
});
```

See **custom-hooks.php** for commented examples.

=== Adding Custom Functions ===

For theme-specific PHP logic:

1. Create a new file in `/inc/` directory
2. Add documentation header and proper code structure
3. Include the file in `functions.php`

Example:

```php
// inc/my-custom-feature.php
<?php
/**
 * My Custom Feature
 * @package astra-rise
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function astra_rise_my_custom_feature() {
    // Your code here
}
add_action( 'init', 'astra_rise_my_custom_feature' );
```

Then in `functions.php`, add:
```php
require_once ASTRA_RISE_DIR . '/inc/my-custom-feature.php';
```

== Theme Functions & Utilities ==

=== Helper Functions ===

Located in `inc/helpers.php`:

**`astra_rise_has_block( $block_type )`**
Check if a specific block type exists on the current page.

```php
if ( astra_rise_has_block( 'uagb/button' ) ) {
    // Block is present
}
```

**`astra_rise_has_blocks( $block_types )`**
Check if any of multiple block types exist on the page.

```php
if ( astra_rise_has_blocks( array( 'uagb/button', 'core/button' ) ) ) {
    // At least one button type is present
}
```

**`astra_rise_is_spectra_active()`**
Check if Spectra plugin is active.

```php
if ( astra_rise_is_spectra_active() ) {
    // Spectra is installed and activated
}
```

**`astra_rise_get_version( $file = '' )`**
Get theme version with cache-busting support.

```php
$version = astra_rise_get_version();
$file_version = astra_rise_get_version( ASTRA_RISE_DIR . '/assets/css/brand.css' );
```

== Constants ==

**`ASTRA_RISE_VERSION`**
Current theme version (from style.css header)

**`ASTRA_RISE_MIN_PHP`**
Minimum required PHP version (7.4)

**`ASTRA_RISE_MIN_WP`**
Minimum required WordPress version (6.2)

**`ASTRA_RISE_DIR`**
Absolute path to theme directory

**`ASTRA_RISE_URI`**
URL to theme directory

== Performance Notes ==

**Asset Optimization:**

1. **Fonts** - Self-hosted fonts preferred, Google Fonts fallback
2. **Critical Fonts** - Preloaded in <head> for better LCP
3. **Resource Hints** - Preconnect/dns-prefetch for external resources
4. **Conditional CSS** - Spectra CSS only loaded when needed
5. **Cache Busting** - File modification time used for versioning

**Best Practices:**

- Use local fonts when possible (faster load times)
- Lazy-load non-critical JavaScript
- Use theme.json for CSS variables (no redundant CSS)
- Avoid inline CSS in templates; use asset files instead
- Test with Core Web Vitals (Lighthouse, PageSpeed Insights)

== Security ==

**Input Sanitization:**
All user inputs are sanitized using appropriate WordPress functions:
- `sanitize_text_field()` - Text inputs
- `sanitize_email()` - Email fields
- `absint()` - Integer values

**Output Escaping:**
All dynamic output is escaped:
- `esc_html()` - HTML text content
- `esc_attr()` - HTML attributes
- `esc_url()` - URLs
- `wp_kses_post()` - HTML with allowed tags

**Capability Checking:**
Admin functions check user capabilities:
- `current_user_can( 'edit_theme_options' )`
- `current_user_can( 'manage_options' )`

**Nonce Verification:**
Form submissions use WordPress nonces:
- `wp_verify_nonce()` - Verify form nonce
- `wp_create_nonce()` - Create new nonce

== Developer Workflow ==

=== Using PHPCodeSniffer (PHPCS) ===

Check code quality against WordPress standards:

```bash
phpcs --standard=WordPress inc/ functions.php
```

Fix automatically:
```bash
phpcbf --standard=WordPress inc/ functions.php
```

See `phpcs.xml` for configuration.

=== Using Git Pre-Commit Hooks ===

Automatically run PHPCS before committing:

```bash
cp .githooks/pre-commit .git/hooks/pre-commit
chmod +x .git/hooks/pre-commit
```

=== Version Bumping ===

When releasing a new version:

1. Update `Version:` in `style.css` header
2. Update version string in relevant `readme.txt` sections
3. Commit and tag:
   ```bash
   git tag -a v1.1.0 -m "Version 1.1.0"
   git push origin v1.1.0
   ```

== Credits ==

**Author:** jwogrady
**GitHub:** https://github.com/jwogrady/astra-rise
**License:** GPLv2+

**Dependencies:**
- Astra Theme (https://wordpress.org/themes/astra/)
- Spectra Blocks (https://wordpress.org/plugins/ultimate-addons-for-gutenberg/)

== Changelog ==

= 1.0.0 =
* Initial release
* Modular architecture with clean code organization
* Spectra block customizations with conditional loading
* Local font support with Google Fonts fallback
* Full Site Editing (FSE) compatibility
* Comprehensive documentation and inline comments

== Additional Resources ==

- **Astra Documentation:** https://docs.astra.build/
- **Spectra Documentation:** https://docs.brainstormforce.com/spectra/
- **WordPress Theme Development:** https://developer.wordpress.org/themes/
- **Block Editor Handbook:** https://developer.wordpress.org/block-editor/
- **WordPress Coding Standards:** https://developer.wordpress.org/coding-standards/wordpress-coding-standards/

== Support & Issues ==

For bugs, feature requests, or issues:
- GitHub Issues: https://github.com/jwogrady/astra-rise/issues
- WordPress Support Forum: https://wordpress.org/support/theme/astra-rise/

== License ==

Astra Rise is licensed under the GNU General Public License v2 or later.
A copy of the license is included in the repository.

---

**Version:** 1.0.0
**Last Updated:** October 2025
**Maintained By:** Rise Local
