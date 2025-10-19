# 🎯 Workspace Optimization Setup Guide

**Version:** 1.0.0  
**Last Updated:** October 19, 2025  
**Estimated Setup Time:** 15-30 minutes

---

## ✅ What Was Optimized

### Files Added
- ✅ `.gitignore` - Comprehensive git exclusions (30+ rules)
- ✅ `.npmignore` - NPM package distribution rules
- ✅ `.editorconfig` - Code style consistency across editors
- ✅ `.github/hooks/pre-commit` - Asset integrity checks
- ✅ `inc/helpers.php` - Added performance metrics functions

### Files Updated
- ✅ `inc/helpers.php` - Added performance monitoring

---

## 🚀 Quick Setup (5 minutes)

### Step 1: Make Pre-Commit Hook Executable

```bash
chmod +x /workspaces/astra-rise/.github/hooks/pre-commit
```

### Step 2: Configure Git to Use Hooks

```bash
cd /workspaces/astra-rise
git config core.hooksPath .github/hooks
```

### Step 3: Verify Setup

```bash
git config core.hooksPath
# Output should be: .github/hooks
```

**✅ Complete!** Your pre-commit hook is now active.

---

## 📋 What Each File Does

### `.gitignore` (Repository Cleanup)

**Purpose:** Prevents unnecessary files from being committed

**What's Excluded:**
- `node_modules/` - 50MB+ of dependencies (users run `npm install`)
- `vendor/` - PHP dependencies (users run `composer install`)
- `composer.lock` - Package locks (each user regenerates)
- `.env` files - Configuration secrets
- IDE settings - Personal editor configurations
- Build artifacts - Generated files

**Result:** Repository stays lean, faster clones

### `.npmignore` (NPM Distribution)

**Purpose:** Controls what gets published to NPM

**What's Included (Minimal):**
- `*.min.css` / `*.min.js` - Minified assets only
- `theme.json` - FSE configuration

**What's Excluded:**
- Documentation folders
- PHP code (theme-specific)
- Development configs

**Result:** Published package is 100KB instead of 5MB

### `.editorconfig` (Code Consistency)

**Purpose:** Ensures all developers use same formatting rules

**Defines:**
- Tab vs space indentation per language
- Line endings (Unix LF)
- Charset (UTF-8)
- Trailing whitespace removal

**Editors That Support It:**
- VS Code (via plugin)
- WebStorm / JetBrains IDEs
- Sublime Text
- Atom
- Vim / Neovim

**Result:** No formatting conflicts in pull requests

### `.github/hooks/pre-commit` (Quality Gate)

**Purpose:** Prevents committing with out-of-sync assets

**Checks:**
- Minified CSS files exist
- Minified JS files exist
- Source changes include minified updates

**What Happens:**
✅ If everything is in sync → Commit proceeds  
❌ If files missing → Commit blocked with instructions

**Usage:**
```bash
# If hook blocks your commit, run:
npm run build
git add assets/
git commit -m "..."
```

---

## 🔍 Usage Examples

### Example 1: Commit New Feature
```bash
# Edit some PHP
vim inc/setup.php

# Add + commit
git add inc/setup.php
git commit -m "feat: add new feature"

# ✅ Pre-commit hook verifies PHP quality
# ✅ Commit succeeds
```

### Example 2: Update CSS (Requires Minification)
```bash
# Edit source CSS
vim assets/css/brand.css

# Try to add + commit
git add assets/css/brand.css
git commit -m "style: update brand colors"

# ❌ Hook detects missing minified file
# Error message:
# ⚠️  Source changed: assets/css/brand.css but assets/css/brand.min.css not updated
# 💡 Run the following to rebuild assets:
#    npm run build
#    git add assets/

# Fix it:
npm run build
git add assets/css/brand.min.css
git commit -m "style: update brand colors"

# ✅ Now both source and minified are in sync
# ✅ Commit succeeds
```

### Example 3: New Team Member Setup
```bash
# Clone repository
git clone https://github.com/jwogrady/astra-rise.git
cd astra-rise

# Install dependencies
npm install
composer install

# Pre-commit hooks automatically configured (via git config)
# ✅ Ready to work!
```

---

## 📊 Performance Debug Info

When developing locally with `WP_DEBUG` enabled, you'll see performance metrics in WordPress admin footer:

```
🚀 Astra Rise Performance Metrics:
Version: 1.0.0
Php Version: 8.3.0
Wp Version: 6.8.3
Memory Usage: 12 MB
Queries: 42
Cache Enabled: enabled
Litespeed Cache: enabled
Minified Assets Used: true
Lazy Loading Enabled: true
Performance Hints: enabled
```

### How to Enable

Add to `wp-config.php`:
```php
define( 'WP_DEBUG', true );
```

Then visit any WordPress admin page to see metrics in the footer.

---

## 🎓 Best Practices

### Committing CSS/JS Changes
```bash
# Rule: Never commit only the source file
# Always commit both source + minified together

# ❌ Wrong:
git add assets/css/brand.css
git commit -m "update styles"

# ✅ Right:
npm run build              # Creates minified versions
git add assets/css/*       # Add both source and minified
git commit -m "style: update brand colors"
```

### Committing PHP Changes
```bash
# Before committing PHP, run linting
npm run lint              # Check for issues
npm run lint:fix          # Auto-fix fixable issues

# Then commit
git add inc/
git commit -m "feat: add new functionality"
```

### Pull Request Checklist
- [ ] All assets minified (`npm run build`)
- [ ] Linting passes (`npm run lint`)
- [ ] No console errors in browser
- [ ] Lighthouse score maintained (90+)

---

## 🐛 Troubleshooting

### Pre-Commit Hook Not Running
**Problem:** Hook isn't being executed

**Solution:**
```bash
# Check if hooks path is configured
git config core.hooksPath

# If empty, reconfigure
git config core.hooksPath .github/hooks

# Verify hook has execute permissions
ls -l .github/hooks/pre-commit
# Should show: -rwxr-xr-x (x = executable)

# If not, fix permissions
chmod +x .github/hooks/pre-commit
```

### "Missing minified file" Error
**Problem:** Pre-commit hook blocking commit

**Solution:**
```bash
# Rebuild all assets
npm run build

# Add the minified files
git add assets/css/*.min.css assets/js/*.min.js

# Try commit again
git commit -m "..."
```

### EditorConfig Not Working
**Problem:** Editor not respecting `.editorconfig`

**Solutions by Editor:**

**VS Code:**
- Install extension: "EditorConfig for VS Code"
- Reload window (Cmd+Shift+P → Reload Window)

**WebStorm/JetBrains:**
- Ensure EditorConfig plugin is enabled (usually default)
- Go to Preferences > Editor > EditorConfig

**Sublime Text:**
- Install "EditorConfig" via Package Control

---

## 📚 Related Documentation

- **[Workspace Optimization Guide](./09-Workspace-Optimization-Guide.md)** - Full optimization recommendations
- **[Deployment Guide](./01-Deployment.md)** - Pre-deployment checks
- **[Developer Guide](../03-Development/03-Developer-Guide.md)** - Development workflow
- **[Audit Report](./03-Audit-Report.md)** - Code quality findings

---

## ✨ Summary

Your workspace is now optimized with:

| Item | Benefit | Time |
|------|---------|------|
| `.gitignore` | Cleaner repo (faster clones) | ✅ |
| `.npmignore` | Smaller npm package | ✅ |
| `.editorconfig` | Consistent formatting | ✅ |
| Pre-commit hook | Quality gate protection | ✅ |
| Performance metrics | Debug information | ✅ |

**Status:** ✅ **Workspace optimization complete**

### Next Steps:
1. ✅ Run `git config core.hooksPath .github/hooks`
2. ✅ Commit changes: `git add . && git commit -m "optimization: setup files"`
3. 🚀 Start developing with confidence!

---

**Questions?** Check [Workspace Optimization Guide](./09-Workspace-Optimization-Guide.md) or the [Developer Guide](../03-Development/03-Developer-Guide.md)

