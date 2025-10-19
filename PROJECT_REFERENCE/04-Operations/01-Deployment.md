# Deployment & Testing Checklist

Complete checklist for verifying the Astra Rise theme is production-ready and for deploying to live environments.

---

## Pre-Deployment Checklist

### Code Quality ✅
- [ ] Run `bun run lint` - All PHPCS checks pass
- [ ] Run `bun run build` - All assets minify without errors
- [ ] No PHP warnings in error logs
- [ ] No JavaScript console errors
- [ ] All functions properly documented with PHPDoc
- [ ] No hardcoded URLs (use ASTRA_RISE_URI constant)
- [ ] All database queries use proper escaping/sanitization

### Security ✅
- [ ] All text outputs use `esc_html()` or `esc_attr()`
- [ ] All URLs use `esc_url()`
- [ ] All HTML content uses `wp_kses_post()`
- [ ] All form inputs sanitized with `sanitize_text_field()`, etc.
- [ ] Nonce verification on form submissions: `wp_verify_nonce()`
- [ ] Capability checks on admin functions: `current_user_can()`
- [ ] No sensitive data logged to error logs
- [ ] No direct database access (use WP_Query, etc.)
- [ ] No inline JavaScript with user data

### Performance ✅
- [ ] CSS files minified (brand.min.css, spectra.min.css)
- [ ] JS files minified (smooth-scroll.min.js)
- [ ] Conditional asset loading implemented
- [ ] Google Fonts properly optimized
- [ ] Local fonts preloaded in `<head>`
- [ ] Resource hints added (preconnect, dns-prefetch)
- [ ] No unnecessary external requests
- [ ] Spectra CSS only loads when blocks present

### Browser Compatibility ✅
- [ ] Chrome (latest 2 versions)
- [ ] Firefox (latest 2 versions)
- [ ] Safari (latest 2 versions)
- [ ] Edge (latest 2 versions)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)
- [ ] All CSS vendor prefixes present where needed

### WordPress Compatibility ✅
- [ ] Tested on WordPress 6.2+
- [ ] Astra parent theme installed and up-to-date
- [ ] No conflicts with popular plugins
- [ ] Block editor works properly
- [ ] Full Site Editing (FSE) compatible
- [ ] Customizer settings work
- [ ] No deprecated WordPress functions used

### Spectra Integration ✅
- [ ] Spectra plugin optional (theme works without it)
- [ ] 5 custom block styles registered
- [ ] Block styles visible in block editor
- [ ] Conditional CSS loading works
- [ ] Custom styles render correctly on frontend
- [ ] No Spectra-specific CSS loads without plugin

### Content Verification ✅
- [ ] Sample pages render correctly
- [ ] Sample posts render correctly
- [ ] Images display properly
- [ ] Custom blocks render correctly
- [ ] Forms work (if used)
- [ ] Navigation menus display correctly
- [ ] Footer widgets display correctly

---

## Deployment Steps

### 1. Pre-Deployment
```bash
# Verify theme directory
cd /home/john/astra-rise

# Install dependencies
composer install
bun install

# Build assets
bun run build

# Run linter
bun run lint
```

### 2. Environment Preparation
```bash
# Create backup of live theme
cd /var/www/html/wp-content/themes
cp -r astra-rise astra-rise.backup

# Clear WordPress cache (if using caching plugin)
# - In WordPress admin: Go to cache settings and clear
# - Or run: wp cache flush
```

### 3. Upload Theme
```bash
# Option A: Direct file transfer
scp -r /home/john/astra-rise user@example.com:/var/www/html/wp-content/themes/

# Option B: Via WordPress admin
# - Upload ZIP file through Appearance > Themes > Upload Theme
```

### 4. Verification After Upload
- [ ] Theme appears in WordPress admin (Appearance > Themes)
- [ ] Theme can be activated without errors
- [ ] No fatal errors in debug log
- [ ] Frontend loads without PHP errors
- [ ] Customizer loads without errors
- [ ] Block editor loads without errors
- [ ] Admin pages load without errors

### 5. Post-Deployment
```bash
# Clear all caches
wp cache flush                    # WordPress cache
wp transient delete-all           # Transients
wp wp-super-cache flush           # WP Super Cache (if installed)

# Verify database consistency
wp db check                       # Check database integrity
wp plugin list                    # Check plugin compatibility
```

---

## Testing Procedures

### Frontend Testing

#### Visual Testing
- [ ] Page layout renders correctly
- [ ] Colors display correctly (verify brand palette)
- [ ] Typography looks good
- [ ] Images display at correct sizes
- [ ] Custom block styles render correctly
- [ ] Hover effects work
- [ ] Responsive design works on mobile (375px)
- [ ] Responsive design works on tablet (768px)
- [ ] Responsive design works on desktop (1200px+)

#### Functional Testing
- [ ] Links navigate correctly
- [ ] Forms submit without errors
- [ ] Search functionality works
- [ ] Navigation menus are clickable
- [ ] Mobile menu expands/collapses
- [ ] Smooth scroll works (if enabled)
- [ ] Contact forms work (if present)
- [ ] Buttons are clickable

#### Performance Testing
```bash
# Measure page load time
curl -o /dev/null -s -w "%{time_total}\n" https://example.com

# Check CSS file sizes
ls -lh /wp-content/themes/astra-rise/assets/css/

# Check JS file sizes
ls -lh /wp-content/themes/astra-rise/assets/js/
```

Expected sizes:
- brand.min.css: < 10KB
- spectra.min.css: < 5KB
- smooth-scroll.min.js: < 3KB

#### Browser Testing Checklist
```
Chrome (Desktop)
  [ ] Render test
  [ ] Console errors: 0
  [ ] Performance: Good

Firefox (Desktop)
  [ ] Render test
  [ ] Console errors: 0
  [ ] Performance: Good

Safari (Desktop)
  [ ] Render test
  [ ] CSS issues: None
  [ ] Performance: Good

iOS Safari (Mobile)
  [ ] Render test
  [ ] Touch interactions: Working
  [ ] Responsive: Correct

Chrome Mobile (Android)
  [ ] Render test
  [ ] Touch interactions: Working
  [ ] Responsive: Correct
```

### Block Editor Testing

#### Spectra Blocks
- [ ] Spectra button block renders
- [ ] Spectra container block renders
- [ ] Spectra heading block renders
- [ ] Spectra separator block renders
- [ ] Custom block styles appear in style dropdown
- [ ] Custom block styles apply correctly

#### Editor Functionality
- [ ] Colors appear in color palette
- [ ] Typography options work
- [ ] Custom image sizes appear in media
- [ ] Block patterns appear and insert correctly
- [ ] No JavaScript errors in console

### Admin Testing

#### Customizer
- [ ] Customizer loads without errors
- [ ] Business info section works
- [ ] Email setting accepts valid emails
- [ ] Phone setting accepts valid numbers
- [ ] Editor options checkboxes work
- [ ] Changes save correctly

#### Theme Settings
- [ ] Theme options appear
- [ ] Settings can be modified
- [ ] Settings persist on page reload
- [ ] Reset functionality works

---

## Security Testing

### PHPCS Verification
```bash
# Run WordPress coding standards check
composer exec phpcs -- inc/ --standard=WordPress

# Expected result: No errors, only warnings (if any)
```

### Security Audit
```bash
# Check for common vulnerabilities
[ ] No SQL injection vulnerabilities
[ ] No XSS vulnerabilities
[ ] No CSRF vulnerabilities
[ ] Proper nonce verification
[ ] Proper capability checking
[ ] Proper input sanitization
[ ] Proper output escaping
```

### Manual Security Tests
- [ ] Test with SQL injection attempts: `'; DROP TABLE--`
- [ ] Test with XSS attempts: `<script>alert('xss')</script>`
- [ ] Verify escaping on all output
- [ ] Verify sanitization on all inputs

---

## Performance Validation

### Google PageSpeed Insights
- [ ] Performance score > 80
- [ ] Accessibility score > 90
- [ ] Best Practices score > 90
- [ ] SEO score > 90

### Load Time Targets
- [ ] First Contentful Paint (FCP): < 1.8s
- [ ] Largest Contentful Paint (LCP): < 2.5s
- [ ] Cumulative Layout Shift (CLS): < 0.1
- [ ] Time to Interactive (TTI): < 3.8s

### File Size Targets
- [ ] CSS total < 50KB (minified)
- [ ] JS total < 30KB (minified)
- [ ] Fonts optimized (WOFF2 format)
- [ ] Images optimized and served at correct sizes

---

## Rollback Plan

### If Critical Errors Occur

```bash
# Stop using the new theme
# 1. In WordPress admin: Switch to default theme or backup

# 2. Restore from backup
cd /var/www/html/wp-content/themes
rm -rf astra-rise
mv astra-rise.backup astra-rise

# 3. Clear caches
wp cache flush

# 4. Verify old theme works
# - Check frontend loads correctly
# - Check admin area functions
# - Check no errors in debug log

# 5. Investigate issue
# - Check error logs for specific error message
# - Check PHPCS report for code issues
# - Check browser console for JS errors
```

---

## Post-Deployment Monitoring (24 Hours)

### Error Monitoring
- [ ] Check WordPress error log for new errors
- [ ] Check server error log for PHP errors
- [ ] Check browser console (frontend & backend)
- [ ] No increase in 404 errors
- [ ] No increase in 500 errors

### User Reports
- [ ] Check for user-reported issues
- [ ] Test reported issues locally
- [ ] Fix and deploy hot-fix if needed

### Analytics Monitoring
- [ ] Bounce rate unchanged
- [ ] Page load time improved
- [ ] Conversion rates maintained
- [ ] User engagement metrics stable

---

## Sign-Off Checklist

**Developer:**
- [ ] Code quality verified (PHPCS)
- [ ] All tests pass
- [ ] Documentation updated
- [ ] No known issues

**QA/Tester:**
- [ ] Functional testing complete
- [ ] Browser testing complete
- [ ] Performance acceptable
- [ ] Security verified

**Product Owner:**
- [ ] Feature requirements met
- [ ] Design matches specification
- [ ] Performance acceptable
- [ ] Ready for production

**DevOps/System Admin:**
- [ ] Infrastructure ready
- [ ] Monitoring configured
- [ ] Rollback plan ready
- [ ] Deployment scheduled

---

## Deployment Checklist Summary

### Before Deployment
```
CODE QUALITY
[ ] bun run lint passes
[ ] bun run build succeeds
[ ] No hardcoded paths/URLs
[ ] All functions documented

SECURITY
[ ] Output escaping: 100% ✅
[ ] Input sanitization: 100% ✅
[ ] Capability checks: ✅
[ ] Nonce verification: ✅

TESTING
[ ] Chrome desktop: ✅
[ ] Firefox desktop: ✅
[ ] Safari desktop: ✅
[ ] Mobile browsers: ✅
[ ] Block editor: ✅
[ ] Customizer: ✅

PERFORMANCE
[ ] Minified assets present
[ ] Conditional loading active
[ ] PageSpeed > 80
[ ] File sizes within limits
```

### During Deployment
```
[ ] Backup created
[ ] Files uploaded
[ ] Permissions verified
[ ] Theme activated
[ ] No fatal errors
[ ] Cache cleared
```

### After Deployment
```
[ ] Frontend loads
[ ] Admin loads
[ ] No PHP errors
[ ] Block editor works
[ ] Customizer works
[ ] 24-hour monitoring active
```

---

## Quick Command Reference

```bash
# Development
cd /home/john/astra-rise
bun install              # Install npm packages
composer install         # Install PHP tools
bun run watch            # Watch for changes

# Build
bun run build            # Minify all assets
bun run css:minify       # Minify CSS only
bun run js:minify        # Minify JS only

# Quality
bun run lint             # Check code standards
bun run lint:fix         # Auto-fix issues

# Deployment
git status               # Check changes
git add .                # Stage changes
git commit -m "msg"      # Commit
git push                 # Push to remote
```

---

## Version & Support

**Deployment Checklist Version:** 1.0.0
**Last Updated:** October 19, 2025
**Status:** Production Ready ✅

**For Questions:**
- Review ARCHITECTURE.md for technical details
- Check CODE_PATTERNS.md for code examples
- See DEVELOPER.md in parent directory for development guidelines
