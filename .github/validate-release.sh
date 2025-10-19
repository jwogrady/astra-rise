#!/usr/bin/env zsh
#
# GitHub Actions Release Workflow - Pre-Release Validation Script
# 
# This script validates your repository before creating a release.
# It checks all the common issues that cause workflow failures.
#
# Usage: chmod +x validate-release.sh && ./validate-release.sh [VERSION]
# Example: ./validate-release.sh 1.0.0
#

set -euo pipefail

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Configuration
VERSION="${1:-}"
ERRORS=0
WARNINGS=0

# Helper functions
print_header() {
  echo ""
  echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
  echo -e "${BLUE}$1${NC}"
  echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
}

print_check() {
  echo -e "${GREEN}✓${NC} $1"
}

print_error() {
  echo -e "${RED}✗${NC} $1"
  ((ERRORS++))
}

print_warning() {
  echo -e "${YELLOW}⚠${NC} $1"
  ((WARNINGS++))
}

print_info() {
  echo -e "${BLUE}ℹ${NC} $1"
}

# Main validation

print_header "Astra Rise Release Validation"

# Check if we're in the correct directory
if [ ! -f "style.css" ]; then
  print_error "Not in repository root (style.css not found)"
  exit 1
fi

print_check "Found repository root"

# 1. Check for VERSION argument
print_header "1️⃣ Version Number Check"

if [ -z "$VERSION" ]; then
  print_warning "No version provided as argument"
  
  # Try to extract from style.css
  EXTRACTED_VERSION=$(grep -m1 '^Version:' style.css | sed -E 's/Version:[[:space:]]*//;s/[[:space:]]*$//')
  
  if [ -z "$EXTRACTED_VERSION" ]; then
    print_error "Could not extract version from style.css"
    exit 1
  fi
  
  VERSION="$EXTRACTED_VERSION"
  print_info "Using version from style.css: $VERSION"
else
  print_info "Validating requested version: $VERSION"
fi

# Validate semantic versioning format (X.Y.Z with optional prerelease/build)
if ! [[ "$VERSION" =~ ^[0-9]+\.[0-9]+\.[0-9]+([-+].*)?$ ]]; then
  print_error "Invalid version format: $VERSION"
  print_info "Expected format: X.Y.Z (semantic versioning)"
  exit 1
fi

print_check "Version format valid: $VERSION"

# 2. Check Git Status
print_header "2️⃣ Git Repository Status"

if ! git rev-parse --git-dir > /dev/null 2>&1; then
  print_error "Not a git repository"
  exit 1
fi

print_check "Git repository detected"

# Check working tree
if ! git diff-index --quiet HEAD --; then
  print_error "Working tree has uncommitted changes"
  print_info "Run: git status"
  ((ERRORS++))
else
  print_check "Working tree is clean"
fi

# Check if branch is up-to-date
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
print_info "Current branch: $CURRENT_BRANCH"

if git rev-parse @{u} > /dev/null 2>&1; then
  if git diff HEAD @{u} --quiet; then
    print_check "Branch is up-to-date with remote"
  else
    print_warning "Branch has unpushed commits"
  fi
fi

# 3. Check for existing tag
print_header "3️⃣ Git Tag Check"

TAG_NAME="v${VERSION}"

if git rev-parse "$TAG_NAME" > /dev/null 2>&1; then
  print_error "Tag already exists: $TAG_NAME"
  print_info "Run: git tag -d $TAG_NAME (to delete locally)"
  print_info "Run: git push origin --delete $TAG_NAME (to delete remote)"
  ((ERRORS++))
else
  print_check "Tag does not exist: $TAG_NAME"
fi

# 4. Check version consistency across files
print_header "4️⃣ Version Consistency Check"

# Check style.css
STYLE_VERSION=$(grep -m1 '^Version:' style.css | sed -E 's/Version:[[:space:]]*//;s/[[:space:]]*$//')
if [ "$STYLE_VERSION" = "$VERSION" ]; then
  print_check "style.css version matches: $STYLE_VERSION"
else
  print_error "style.css version mismatch: $STYLE_VERSION (expected $VERSION)"
  ((ERRORS++))
fi

# Check readme.txt
if grep -q "^Stable Tag: $VERSION" readme.txt; then
  print_check "readme.txt Stable Tag matches: $VERSION"
elif grep -q "^Stable Tag:" readme.txt; then
  README_VERSION=$(grep "^Stable Tag:" readme.txt | sed -E 's/Stable Tag:[[:space:]]*//;s/[[:space:]]*$//')
  print_warning "readme.txt Stable Tag mismatch: $README_VERSION (expected $VERSION)"
else
  print_warning "readme.txt Stable Tag not found"
fi

# Check functions.php for ASTRA_RISE_VERSION (optional)
if grep -q "ASTRA_RISE_VERSION" functions.php; then
  if grep -q "ASTRA_RISE_VERSION.*$VERSION" functions.php; then
    print_check "functions.php ASTRA_RISE_VERSION matches: $VERSION"
  else
    FN_VERSION=$(grep "ASTRA_RISE_VERSION" functions.php | head -1 | sed -E "s/.*['\"]([^'\"]+)['\"].*/\1/")
    print_warning "functions.php version mismatch: $FN_VERSION (expected $VERSION)"
  fi
fi

# 5. Check required files exist
print_header "5️⃣ Required Files Check"

REQUIRED_FILES=(
  "style.css"
  "functions.php"
  "readme.txt"
  "theme.json"
  "README.md"
)

for FILE in "${REQUIRED_FILES[@]}"; do
  if [ -f "$FILE" ]; then
    SIZE=$(du -h "$FILE" | cut -f1)
    print_check "$FILE exists ($SIZE)"
  else
    print_error "$FILE not found"
    ((ERRORS++))
  fi
done

# 6. Check directory structure
print_header "6️⃣ Directory Structure Check"

REQUIRED_DIRS=(
  "inc"
  "assets"
  "patterns"
)

for DIR in "${REQUIRED_DIRS[@]}"; do
  if [ -d "$DIR" ]; then
    FILE_COUNT=$(find "$DIR" -type f | wc -l)
    print_check "$DIR/ exists ($FILE_COUNT files)"
  else
    print_warning "$DIR/ not found (optional)"
  fi
done

# 7. Check for common issues
print_header "7️⃣ Common Issues Check"

# Check for node_modules (should be excluded)
if [ -d "node_modules" ]; then
  print_warning "node_modules/ found (will be excluded from distribution)"
fi

# Check for .vscode (should be excluded)
if [ -d ".vscode" ]; then
  print_warning ".vscode/ found (will be excluded from distribution)"
fi

# Check file permissions
if [ -x "functions.php" ] || [ -x "style.css" ]; then
  print_warning "Some source files have executable permissions (unusual but not critical)"
fi

# 8. Summary
print_header "📊 Validation Summary"

if [ $ERRORS -eq 0 ]; then
  echo -e "${GREEN}✓ All checks passed!${NC}"
  
  if [ $WARNINGS -eq 0 ]; then
    echo ""
    print_info "You're ready to create release: $TAG_NAME"
    echo ""
    echo -e "${BLUE}Next steps:${NC}"
    echo "1. Create tag:"
    echo "   git tag -a $TAG_NAME -m 'Release $VERSION'"
    echo ""
    echo "2. Push tag:"
    echo "   git push origin $TAG_NAME"
    echo ""
    echo "3. Monitor workflow:"
    echo "   https://github.com/jwogrady/astra-rise/actions"
    echo ""
  else
    echo ""
    print_info "Ready to release, but review $WARNINGS warning(s) above"
    echo ""
  fi
  
  exit 0
else
  echo ""
  echo -e "${RED}✗ Validation failed with $ERRORS error(s)${NC}"
  echo ""
  echo -e "${BLUE}Please fix the errors above before releasing.${NC}"
  echo ""
  exit 1
fi
