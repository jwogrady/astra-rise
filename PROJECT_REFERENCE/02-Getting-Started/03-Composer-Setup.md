# How to Install Composer

Composer is a PHP dependency manager. You'll need it to install PHP-based tools like PHPCS (PHP Code Sniffer).

## Prerequisites

You need PHP installed first. Here's how to check and install it:

### Check if PHP is installed

```bash
php --version
```

If you see a version number, PHP is installed. Otherwise, continue to the next section.

---

## Installation by Operating System

### 🍎 macOS (Homebrew)

**1. Install PHP (if not already installed):**
```bash
brew install php
```

**2. Install Composer:**
```bash
brew install composer
```

**3. Verify:**
```bash
composer --version
```

---

### 🐧 Linux (Ubuntu/Debian)

**1. Install PHP:**
```bash
sudo apt update
sudo apt install php php-cli php-curl php-zip
```

**2. Install Composer:**
```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

**3. Verify:**
```bash
composer --version
```

---

### 🪟 Windows

**1. Install PHP:**
- Download from https://www.php.net/downloads
- Or use XAMPP/WAMP/LARAGON for easier setup

**2. Install Composer:**
- Download the Windows installer from https://getcomposer.org/download/
- Run the `.exe` file and follow the prompts
- Make sure to select your PHP installation when prompted

**3. Verify (in PowerShell or CMD):**
```bash
composer --version
```

---

### 🐳 Docker (Alternative)

If you don't want to install PHP/Composer locally, use Docker:

```bash
docker run --rm -v $(pwd):/app composer install
```

---

## After Installation

Once Composer is installed, go back to the project:

```bash
cd /home/john/astra-rise
composer install
```

This will:
1. Download PHP Code Sniffer (PHPCS)
2. Install WordPress Coding Standards
3. Create a `vendor/` directory with all dependencies

Then you can run linting:

```bash
composer run-script lint        # Check code
composer run-script lint:fix    # Auto-fix issues
```

---

## Troubleshooting

### "composer: command not found"

1. Make sure Composer is in your PATH:
   ```bash
   which composer
   ```

2. If not found, add to PATH:
   ```bash
   # Add to ~/.zshrc or ~/.bash_profile
   export PATH="$PATH:$HOME/.composer/vendor/bin"
   ```

3. Reload your shell:
   ```bash
   source ~/.zshrc   # or ~/.bash_profile
   ```

### "PHP not found"

1. Verify PHP is installed:
   ```bash
   php --version
   ```

2. If not installed, follow OS-specific instructions above

3. Add to PATH if needed:
   ```bash
   # Find PHP location
   which php
   # Add directory to PATH in ~/.zshrc
   ```

### "curl: permission denied"

Use `sudo` with the curl command:

```bash
sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```

---

## Note: Composer is Optional

**Important:** Composer is only needed if you want to use PHPCS (PHP linting).

If you're not interested in PHP linting, you can skip Composer entirely and just use:

```bash
bun install      # For CSS/JS builds (already working)
bun run build    # Minify CSS/JS
```

The theme will work perfectly fine without Composer. PHP linting is just a developer tool for code quality checking.

---

## Quick Reference

| Action | Command |
|--------|---------|
| Check Composer version | `composer --version` |
| Install dependencies | `composer install` |
| Check PHP code quality | `composer run-script lint` |
| Auto-fix PHP issues | `composer run-script lint:fix` |
| Update all packages | `composer update` |

---

**Next Step:** Once Composer is installed, run `composer install` in the project directory.
