# Deploying Sinag

## 1. Test locally

**Option A — LocalWP (easiest):** create a site in [LocalWP](https://localwp.com/), open its folder, copy `sinag-theme/` into `app/public/wp-content/themes/`, then activate it in wp-admin → Appearance → Themes.

**Option B — wp-env (Docker):** in the theme folder run

```bash
npx @wordpress/env start --themes=.     # WordPress at http://localhost:8888 (admin / password)
npx @wordpress/env run cli wp theme activate sinag-theme
```

**Run the checks before every release:**

```bash
find . -name "*.php" -not -path "./node_modules/*" -exec php -l {} \;
php tests/test-helpers.php
node tests/validate.mjs
```

## 2. Install on a live site

1. Build the zip from the folder *above* the theme so the zip contains a top-level `sinag-theme/` folder:
   ```bash
   cd ..
   zip -r sinag-theme.zip sinag-theme -x "*.git*" "*/node_modules/*" "*.DS_Store"
   ```
2. wp-admin → Appearance → Themes → Add New → Upload Theme → choose `sinag-theme.zip` → Install Now → Activate.
3. Appearance → Business Details → fill in and save.

The `docs/`, `demo/` and `tests/` folders are harmless on a live site. To ship a slimmer zip, add `-x "sinag-theme/docs/*" "sinag-theme/demo/*" "sinag-theme/tests/*"`.

## 3. Publish to GitHub

### With GitHub Desktop

1. File → **Add local repository…** → choose the `sinag-theme` folder → when asked, click **create a repository** (Git ignore: None, License: None — both files already exist).
2. Commit summary: `Sinag v1.0.0` → **Commit to main**.
3. Click **Publish repository**. Name: `sinag-theme`. **Untick "Keep this code private"**. Publish.

### With the git CLI

```bash
cd sinag-theme
git init
git add .
git commit -m "Sinag v1.0.0"
git branch -M main
git remote add origin https://github.com/EfraimRay/sinag-theme.git   # create the empty repo on github.com first
git push -u origin main
```

### Topics

Repository page → ⚙ next to **About** → Topics: `efraimray-showcase`, `wordpress-theme`, `block-theme`, `full-site-editing`, `theme-json`, `block-bindings`, `philippines`, `small-business`.

## 4. GitHub Pages (live demo)

Settings → **Pages** → Source: **Deploy from a branch** → Branch: `main`, folder `/ (root)` → Save. After a minute the demo is at:

```
https://efraimray.github.io/sinag-theme/demo/
```

CLI alternative:

```bash
gh api -X POST repos/EfraimRay/sinag-theme/pages -f "source[branch]=main" -f "source[path]=/"
```

## 5. Bump the version and release

Semantic versioning: `1.0.1` for fixes, `1.1.0` for new features, `2.0.0` for breaking changes. Update the number in **all** of these:

| File | Field |
|---|---|
| `style.css` | `Version:` |
| `readme.txt` | `Stable tag:` and a new `= x.y.z =` changelog entry |
| `functions.php` | `SINAG_THEME_VERSION` |
| `CHANGELOG.md` | new dated section |
| `README.md` | version badge |

Then:

```bash
git commit -am "Sinag v1.1.0"
git tag v1.1.0
git push && git push --tags
cd .. && zip -r sinag-theme.zip sinag-theme -x "*.git*"
gh release create v1.1.0 sinag-theme.zip --title "Sinag v1.1.0" --notes-file sinag-theme/CHANGELOG.md
```

In GitHub Desktop: commit, then Repository → **Create Tag…** → `v1.1.0` → Push origin. Create the release on github.com → Releases → **Draft a new release** → choose the tag → attach the zip → Publish.
