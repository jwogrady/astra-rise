# Development Setup Guide - Astra Rise Theme

This guide walks you through setting up the Astra Rise theme development environment.

## Quick Start

### 1. Install Node.js Dependencies (for CSS/JS builds)

```bash
cd /home/john/astra-rise
bun install
# or: npm install
```

**What it installs:**
- `cssnano` - CSS minification
- `uglify-js` - JavaScript minification
- `watch` - File watching for builds

### 2. Install PHP Dependencies (for code linting)

```bash
composer install
```

**What it installs:**
- `squizlabs/php_codesniffer` - PHP linting tool
- `wp-coding-standards/wpcs` - WordPress coding standards

### 3. Configure Git Hooks

```bash
chmod +x .githooks/pre-commit
git config core.hooksPath .githooks
```

This enables automatic PHP linting before each commit.

---

## Available Commands

### Build Commands

```bash
# Minify CSS and JavaScript
bun run build

# Minify CSS only
bun run css:minify

# Minify JavaScript only
bun run js:minify

# Watch for changes and rebuild
bun run watch
```

### Linting Commands

```bash
# Check code quality
composer run-script lint

# Auto-fix code issues
composer run-script lint:fix

# Run tests (same as lint)
composer run-script test
```

---

## Detailed Setup Steps

### For npm Users (instead of bun)

If you prefer npm over bun:

```bash
npm install
npm run build      # Build CSS/JS
npm run watch      # Watch for changes
```

### For Composer Setup

If composer is not installed:

**On macOS (Homebrew):**
```bash
brew install composer
```

**On Linux:**
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**On Windows (or manual install):**
Visit https://getcomposer.org/download/

After installing, verify:
```bash
composer --version
```

### Verify Installation

```bash
# Check bun
bun --version

# Check npm (if using npm instead)
npm --version

# Check composer
composer --version

# Check PHP
php --version

# Check PHPCS
composer run-script lint
```

---

## Troubleshooting

### "bun: command not found"

Install bun from https://bun.sh or use npm instead:
```bash
npm install
npm run build
```

### "composer: command not found"

Install composer from https://getcomposer.org

### "PHPCS not found" when running lint

Make sure composer dependencies are installed:
```bash
composer install
```

### Pre-commit hook not working

1. Make sure it's executable:
   ```bash
   chmod +x .githooks/pre-commit
   ```

2. Configure Git to use the hooks directory:
   ```bash
   git config core.hooksPath .githooks
   ```

3. Verify configuration:
   ```bash
   git config core.hooksPath
   ```
   Should output: `.githooks`

### CSS not minifying

1. Check cssnano is installed:
   ```bash
   bun list cssnano
   ```

2. Verify CSS files exist:
   ```bash
   ls -la assets/css/
   ```

3. Try manual minification:
   ```bash
   bun run css:minify
   ```

---

## Development Workflow

### Making Changes

1. Create a feature branch:
   ```bash
   git checkout -b feature/my-feature
   ```

2. Make your code changes

3. Test your changes locally:
   - Edit WordPress posts/pages to test blocks
   - Customize theme in Appearance > Customize
   - Check browser console for JavaScript errors

### Before Committing

1. Minify assets:
   ```bash
   bun run build
   ```

2. Check code quality:
   ```bash
   composer run-script lint
   ```

3. Fix any issues:
   ```bash
   composer run-script lint:fix
   ```

4. Add and commit:
   ```bash
   git add .
   git commit -m "Descriptive message"
   ```

The pre-commit hook will automatically run PHPCS. If it fails, the commit is blocked.

### Pushing Changes

```bash
git push origin feature/my-feature
```

Then create a pull request on GitHub.

---

## File Locations

| Purpose | Location |
|---------|----------|
| Build configuration | `package.json` |
| PHP config | `composer.json` |
| PHPCS rules | `phpcs.xml` |
| Git hooks | `.githooks/` |
| Build output | `assets/css/*.min.css`, `assets/js/*.min.js` |
| Source CSS | `assets/css/brand.css`, `assets/css/spectra.css` |
| Source JS | `assets/js/smooth-scroll.js` |

---

## Further Reading

- [DEVELOPER.md](./DEVELOPER.md) - Architecture and development guide
- [readme.txt](./readme.txt) - Theme features and usage
- [AUDIT_REPORT.md](./AUDIT_REPORT.md) - Optimization audit details
- [phpcs.xml](./phpcs.xml) - Linting configuration

---

**Last Updated:** October 19, 2025
