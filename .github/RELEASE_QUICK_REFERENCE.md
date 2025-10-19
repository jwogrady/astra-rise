# Release Workflow Quick Reference

**Quick lookup for the most common release tasks**

---

## 🚀 Quick Release (30 seconds)

```bash
# 1. Update versions
# Edit: style.css (Version field)
#       readme.txt (Stable Tag field)
#       functions.php (ASTRA_RISE_VERSION constant)

# 2. Commit and push
git add style.css readme.txt functions.php
git commit -m "chore: bump version to 1.0.0"
git push origin master

# 3. Create and push tag
git tag -a v1.0.0 -m "Release v1.0.0"
git push origin v1.0.0

# Done! Workflow runs automatically ✅
```

---

## 📋 Pre-Release Checklist

- [ ] Working tree clean: `git status`
- [ ] All changes pushed: `git push origin master`
- [ ] Version numbers match across files
- [ ] Tag doesn't exist: `git tag -l v1.0.0`
- [ ] Semantic version format (X.Y.Z)

---

## 📖 Version Examples

| Event | Version | Tag |
|-------|---------|-----|
| Initial release | 1.0.0 | v1.0.0 |
| Bug fix | 1.0.1 | v1.0.1 |
| New feature | 1.1.0 | v1.1.0 |
| Major redesign | 2.0.0 | v2.0.0 |

---

## 🔍 Workflow Status

Check workflow progress:
```
Repository → Actions → Build & Release Theme
```

Expected time: 2-3 minutes

---

## 📦 What Gets Included

**Included in `astra-rise-{VERSION}.zip`:**
- ✅ All PHP files (functions.php, inc/*, patterns/*)
- ✅ CSS assets (style.css, assets/css/*)
- ✅ JavaScript files (assets/js/*)
- ✅ Fonts and media (assets/fonts/*)
- ✅ theme.json configuration
- ✅ readme.txt

**Excluded from zip:**
- ❌ .git/ (version control)
- ❌ node_modules/ (npm dependencies)
- ❌ PROJECT_REFERENCE/ (dev docs)
- ❌ .github/ (CI/CD config)
- ❌ .vscode/ (editor settings)

---

## ⚠️ Common Issues

| Issue | Solution |
|-------|----------|
| "No Version found" | Check `Version:` field in style.css |
| "Invalid format" | Use X.Y.Z format (e.g., 1.0.0) |
| Versions don't match | Update all files (style.css, readme.txt, functions.php) |
| Zip not created | Check GitHub Actions logs |

---

## 🔗 Key Locations

- **Workflow:** `.github/workflows/update.yaml`
- **Version source:** `style.css` (line 6)
- **Releases:** https://github.com/jwogrady/astra-rise/releases
- **Full guide:** [Release Workflow Guide](05-Release-Workflow-Guide.md)

---

## 💡 Tips

- Always test locally before releasing
- Use descriptive tag messages with `git tag -a`
- Keep version numbers in sync
- Review auto-generated release notes before publishing

---

**Need help?** See [Release Workflow Guide](05-Release-Workflow-Guide.md) for detailed instructions.
