# Release Workflow Guide

**Document Type:** Operations Guide  
**Audience:** Developers, Release Managers, Maintainers  
**Version:** 1.0.0  
**Last Updated:** October 19, 2025  
**Status:** ✅ Production Ready

---

## Overview

The **Build & Release Theme** workflow automates the process of creating and publishing WordPress theme distributions on GitHub Releases. This workflow is triggered whenever you push a semantic version tag (e.g., `v1.0.0`) to the repository.

### Workflow Location
```
.github/workflows/update.yaml
```

### Key Features
- ✅ Automatic version extraction from `style.css`
- ✅ Version consistency validation
- ✅ Optimized distribution package creation
- ✅ Professional GitHub Release generation
- ✅ Semantic versioning compliance
- ✅ Comprehensive logging and error handling

---

## How It Works

### Trigger Events

The workflow runs automatically when:

1. **Tag Push Event** (Primary)
   ```bash
   git push origin v1.0.0
   ```
   - Triggered by semantic version tags (v*.*.*)
   - Creates a GitHub Release automatically
   - Includes generated release notes

2. **Manual Workflow Dispatch**
   - Can be triggered manually via GitHub Actions UI
   - Useful for testing or releasing without tags
   - Access: Repository → Actions → Build & Release Theme

### Workflow Steps

#### Step 1: Checkout Repository
- Clones your repository with full history
- Required for generating accurate release notes

#### Step 2: Extract Version from style.css
- Reads the `Version:` field from `style.css`
- Validates semantic versioning format (X.Y.Z)
- Outputs version for subsequent steps
- **Validation:** Must match `\d+\.\d+\.\d+` pattern

Example extracted:
```
Version: 1.0.0
```

#### Step 3: Validate Version Consistency
- Checks `readme.txt` for matching `Stable Tag`
- Checks `functions.php` for `ASTRA_RISE_VERSION` constant
- Warns if versions don't match across files
- ⚠️ Warnings don't block the release (informational only)

#### Step 4: Create Distribution Package
- Stages files in temporary directory under `astra-rise/` folder
- Excludes development files (node_modules, .git, PROJECT_REFERENCE, etc.)
- Creates optimized zip file: `astra-rise-{VERSION}.zip`
- Reports package size and contents

**Excluded Files** (not included in distribution):
```
.git/                  # Version control
.github/               # CI/CD workflows
node_modules/          # npm dependencies
bun.lockb              # Bun lock file
*.zip                  # Previous packages
.vscode/               # Editor settings
.DS_Store              # macOS metadata
*.map                  # Source maps
PROJECT_REFERENCE/     # Development docs
phpcs.xml              # Code standards config
```

#### Step 5: Compute Release Metadata
- Determines tag name (from ref_name or derived from version)
- Ensures consistency between tag and version
- Outputs for release creation

#### Step 6: Publish GitHub Release
- Creates release on GitHub with version tag
- Generates professional release notes
- Uploads distribution zip as asset
- Marks as latest release

---

## Creating a Release

### Prerequisites

Before releasing, ensure:

1. ✅ **All Changes Committed**
   ```bash
   git status  # Must show "nothing to commit, working tree clean"
   ```

2. ✅ **Version Numbers Aligned**
   - `style.css` → `Version: X.Y.Z`
   - `readme.txt` → `Stable Tag: X.Y.Z`
   - `functions.php` → `ASTRA_RISE_VERSION` constant (optional but recommended)

3. ✅ **Tag Doesn't Already Exist**
   ```bash
   git tag -l v1.0.0  # Should be empty
   ```

### Step-by-Step Release Process

#### 1. Update Version Numbers

Edit `style.css`:
```css
/**
Theme Name: astra-rise
...
Version: 1.0.0
Stable Tag: 1.0.0
...
*/
```

Edit `readme.txt`:
```
Stable Tag: 1.0.0
```

Optional — Edit `functions.php`:
```php
const ASTRA_RISE_VERSION = '1.0.0';
```

#### 2. Commit Version Changes

```bash
git add style.css readme.txt functions.php
git commit -m "chore: bump version to 1.0.0 for release"
git push origin master
```

#### 3. Create Version Tag

```bash
git tag -a v1.0.0 -m "astra-rise v1.0.0 - Production Release

- Complete theme optimization
- 10 modular components
- 5 custom Spectra block styles
- Comprehensive documentation
- 100% PHPCS compliance"

git push origin v1.0.0
```

**Tag Naming Convention:**
- Format: `v{MAJOR}.{MINOR}.{PATCH}`
- Examples: `v1.0.0`, `v1.0.1`, `v2.1.0`
- Must match regex: `v*.*.*`

#### 4. Verify Release

The workflow typically completes in **2-3 minutes**.

1. Check GitHub Actions
   - Repository → Actions → Build & Release Theme
   - Look for your tag in the run list
   - Verify status shows ✅

2. Check GitHub Releases
   - Repository → Releases
   - Your version should appear as "Latest"
   - Download `astra-rise-{VERSION}.zip`

3. Test Distribution
   ```bash
   # Download and test the zip
   unzip astra-rise-1.0.0.zip
   ls astra-rise/  # Should contain all theme files
   ```

---

## Version Numbering (Semantic Versioning)

Astra Rise uses **Semantic Versioning 2.0.0**.

### Version Format: `MAJOR.MINOR.PATCH`

**MAJOR** (X.0.0)
- Breaking changes
- Major rewrites or architecture changes
- Increment: `1.0.0` → `2.0.0`

**MINOR** (X.Y.0)
- New features (backward compatible)
- New components or patterns added
- Increment: `1.0.0` → `1.1.0`

**PATCH** (X.Y.Z)
- Bug fixes
- Performance improvements
- Minor updates
- Increment: `1.0.0` → `1.0.1`

### Example Progression

```
v1.0.0  → Initial release
v1.0.1  → Bug fix in block rendering
v1.1.0  → New block pattern added
v1.1.1  → Minor CSS improvement
v2.0.0  → Complete architecture redesign
```

---

## Troubleshooting

### Issue: Workflow Failed - "No Version: found in style.css"

**Cause:** The `Version:` field is missing or malformed in `style.css`

**Solution:**
```bash
# Check current version in style.css
grep "^Version:" style.css

# Should output something like:
# Version: 1.0.0
```

**Fix:** Ensure `Version:` is on a separate line with proper spacing:
```css
/**
Theme Name: astra-rise
...
Version: 1.0.0
...
*/
```

### Issue: "Invalid version format" Error

**Cause:** Version doesn't match semantic versioning pattern

**Valid Formats:**
- ✅ `1.0.0`
- ✅ `1.0.0-beta`
- ✅ `1.0.0+build.123`

**Invalid Formats:**
- ❌ `1.0` (missing patch)
- ❌ `v1.0.0` (v prefix in style.css)
- ❌ `1.0.0-` (empty prerelease)

### Issue: Version Consistency Warning

**Cause:** Versions don't match across files

**Example Warning:**
```
⚠️ Warning: readme.txt Stable Tag does not match style.css Version
```

**Solution:**
```bash
# Check all version locations
grep "Version:" style.css
grep "Stable Tag:" readme.txt
grep "ASTRA_RISE_VERSION" functions.php

# Update mismatched files
# The release will still complete, but consistency is important
```

### Issue: Zip File Not Created

**Cause:** rsync or zip command failed (rare)

**Diagnostic:**
1. Check GitHub Actions logs for error details
2. Verify all required files exist in repository
3. Ensure no permission issues

**Recovery:**
```bash
# Manual workflow retry via GitHub UI:
# Actions → Build & Release Theme → Latest failed run
# → Re-run failed jobs
```

### Issue: Can't Find Release on GitHub

**Cause:** 
- Workflow hasn't completed yet
- Workflow failed silently
- Looking in wrong repository

**Verification:**
1. Go to: `https://github.com/jwogrady/astra-rise/releases`
2. Check Actions tab for workflow completion
3. Verify you're in correct repository

---

## Advanced: Manual Release (If Needed)

If the workflow fails or you need to create a release manually:

### 1. Create Zip Manually

```bash
#!/bin/bash
VERSION="1.0.0"
ZIPNAME="astra-rise-${VERSION}.zip"
STAGE_DIR="./astra-rise-dist"

# Create staging directory
mkdir -p "$STAGE_DIR/astra-rise"

# Copy files with exclusions
rsync -a ./ "$STAGE_DIR/astra-rise/" \
  --exclude='.git/' \
  --exclude='.github/' \
  --exclude='node_modules/' \
  --exclude='*.zip' \
  --exclude='.vscode/' \
  --exclude='.DS_Store'

# Create zip
cd "$STAGE_DIR"
zip -r "$ZIPNAME" "astra-rise"
cd ..

echo "Created: $STAGE_DIR/$ZIPNAME"
```

### 2. Create Release on GitHub

```bash
gh release create v1.0.0 \
  --title "astra-rise v1.0.0" \
  --notes "Release v1.0.0" \
  "astra-rise-dist/astra-rise-1.0.0.zip"
```

Or use GitHub UI:
1. Go to Releases → Create New Release
2. Choose tag: `v1.0.0`
3. Title: `astra-rise v1.0.0`
4. Upload zip manually

---

## Best Practices

### 1. Test Before Release
```bash
# Verify working tree is clean
git status

# Check all files present
ls -la inc/ assets/ patterns/

# Test locally with WordPress if possible
```

### 2. Use Descriptive Commit Messages
```bash
git commit -m "chore: bump version to 1.0.0 for release

This release includes:
- 10 modular PHP components
- Complete PHPCS compliance
- Comprehensive documentation"
```

### 3. Review Generated Release Notes
- GitHub auto-generates from commits
- Edit manually if needed
- Include system requirements
- Add upgrade instructions for existing users

### 4. Monitor First Release
- Check GitHub Actions logs
- Verify zip downloads correctly
- Test extraction on clean system
- Validate theme activates in WordPress

### 5. Keep Documentation Updated
- Update CHANGELOG if you maintain one
- Update version in PROJECT_REFERENCE files
- Update README if there are breaking changes

---

## GitHub Actions Permissions

The workflow requires these permissions:

```yaml
permissions:
  contents: write  # Can create releases and push tags
```

**Troubleshooting Permission Issues:**
1. Go to Repository Settings → Actions → General
2. Under "Workflow permissions", verify "Read and write permissions" is enabled
3. Check that "Allow GitHub Actions to create and approve pull requests" is set as needed

---

## Related Documentation

- 📖 [Deployment Guide](01-Deployment.md) — Server setup and production deployment
- 🔍 [Audit Report](03-Audit-Report.md) — Security and code quality audit
- ⚡ [Optimization Summary](04-Optimization-Summary.md) — Performance metrics
- 🏗️ [Architecture](../03-Development/01-Architecture.md) — System design and components

---

## Questions?

**For workflow issues:**
- Check GitHub Actions logs for detailed error messages
- Review this guide's Troubleshooting section
- Visit: Repository → Actions → Build & Release Theme

**For version management:**
- See Semantic Versioning section above
- Review existing releases: https://github.com/jwogrady/astra-rise/releases

**For general questions:**
- Check PROJECT_REFERENCE documentation hub
- Review README.md for quick navigation

---

**Document Info**

| Field | Value |
|-------|-------|
| Team | Astra Rise Maintainers |
| Repository | [jwogrady/astra-rise](https://github.com/jwogrady/astra-rise) |
| License | GNU General Public License v2 or later |
| Last Review | October 19, 2025 |

---

*This guide is maintained as part of the Astra Rise project. For updates or corrections, see the PROJECT_REFERENCE README.*
