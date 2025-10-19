<!-- Astra Rise - Development Quick Reference -->

# 🚀 Astra Rise - Development Quick Reference

## Installation (Choose One)

### Option 1: Quick Setup (JavaScript only - Recommended for beginners)
```bash
bun install          # Install JS build tools (CSS/JS minification)
git config core.hooksPath .githooks
chmod +x .githooks/pre-commit
```

### Option 2: Full Setup (JavaScript + PHP linting)
```bash
bun install          # Install JS build tools
composer install     # Install PHP linting tools
git config core.hooksPath .githooks
chmod +x .githooks/pre-commit
```

**Note:** Need Composer? See [COMPOSER_SETUP.md](./COMPOSER_SETUP.md)

### Option 3: Using npm instead of bun
```bash
npm install
npm run build        # Build CSS/JS
npm run watch        # Watch for changes
```

---

## Common Commands

| Task | Command |
|------|---------|
| Build CSS/JS | `bun run build` |
| Watch files | `bun run watch` |
| Check code | `composer run-script lint` |
| Fix code | `composer run-script lint:fix` |

---

## Files to Know

| File | Purpose |
|------|---------|
| `functions.php` | Theme bootstrap |
| `inc/*.php` | Modular components |
| `assets/css/brand.css` | Brand styles |
| `assets/css/spectra.css` | Spectra block styles |
| `phpcs.xml` | Linting config |
| `package.json` | Build config (npm/bun) |
| `composer.json` | PHP config |
| `.githooks/pre-commit` | Auto-linting on commit |

---

## Documentation

- **SETUP.md** - Detailed setup guide
- **COMPOSER_SETUP.md** - How to install Composer
- **DEVELOPER.md** - Architecture & workflow
- **readme.txt** - Features & customization
- **AUDIT_REPORT.md** - Optimization details

---

## Troubleshooting

**"bun not found?"** → Use `npm install && npm run build` instead

**"composer not found?"** → See [COMPOSER_SETUP.md](./COMPOSER_SETUP.md) or skip it

**"Pre-commit hook not working?"** → Run `git config core.hooksPath .githooks`

**"CSS/JS not minifying?"** → Run `bun install` first

---

**Start here:** Read `SETUP.md` for complete instructions
