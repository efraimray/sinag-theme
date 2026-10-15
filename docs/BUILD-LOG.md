# How Sinag Was Built

This is a plain-language record of how the Sinag WordPress block theme was planned, written, tested and packaged, in the order it actually happened.

| | |
|---|---|
| **Project** | Sinag — WordPress block theme for Philippine small businesses |
| **Type** | WordPress block (Full Site Editing) theme |
| **Version** | 1.0.0 |
| **Built** | 2026-10-15 by Claude (nightly showcase run) for Efraim Ray |
| **Difficulty** | Intermediate (block markup, theme.json, Settings API, Block Bindings API) |
| **Time to install** | About 2 minutes (upload zip, activate, fill in Business Details) |

---

## 1. Languages Used

Line counts are for the theme code and tests (the `docs/` and `demo/` folders are not included). They were counted with `find . -name "*.<ext>" | xargs cat | wc -l`.

| Language | Lines | Share | Files | What it does in this project |
|---|---:|---:|---|---|
| PHP | 901 | 55% | `functions.php`, `inc/*.php`, `patterns/*.php`, `tests/test-helpers.php` (14 files) | Registers the theme's features, the Business Details screen and the binding source; holds the patterns with translatable text; tests the helper functions |
| JSON | 346 | 21% | `theme.json`, `styles/*.json` (5 files) | The design system: colours, fonts, spacing, button and heading styles, and the four style variations |
| HTML (block markup) | 174 | 11% | `templates/*.html`, `parts/*.html` (10 files) | Says which blocks make up each kind of page (front page, blog, single post, 404 …) |
| CSS | 113 | 7% | `style.css` (1 file) | The theme header plus the few visual details theme.json can't express (hero sun, dotted price leaders, check marks, FAQ +/−) |
| JavaScript | 106 | 6% | `tests/validate.mjs` (1 file) | A Node.js test script that checks the block markup, references, text domain and colour contrast. No JavaScript is sent to visitors |

**In one sentence:** PHP wires the theme into WordPress and holds the translatable patterns, JSON defines the whole look, HTML block markup lays out each page type, CSS adds a handful of finishing touches, and JavaScript only runs the tests.

The interactive demo (`demo/index.html`, 413 lines of HTML, CSS and JavaScript in one file) is a separate showcase page and not part of the theme.

### Frameworks and APIs

- WordPress 6.6+ Full Site Editing (block templates, template parts, block patterns)
- `theme.json` version 3 and style variations
- WordPress Settings API (`register_setting`, `settings_fields`, `add_theme_page`)
- WordPress Block Bindings API (`register_block_bindings_source`, WordPress 6.5+)
- Block styles API (`register_block_style`)
- WordPress i18n functions (`esc_html_e`, `__`, `esc_attr_x`) with the `sinag-theme` text domain

### Tools used to build and test

| Tool | What it was used for |
|---|---|
| `php -l` (PHP 8.3 CLI) | Syntax check of all 14 PHP files |
| `php tests/test-helpers.php` | 12 unit cases for the phone and URL helpers |
| Node.js 22 (`node --check`, `node tests/validate.mjs`) | Script syntax checks; 323 static checks on the theme |
| Python 3 | Generating the four style-variation JSON files; assembling the Blogger post |
| WordPress 6.6-RC3 + SQLite Database Integration (from the npm package `@wp-playground/wordpress-builds`), run with `php -S` | A real WordPress install to activate the theme and render its pages |
| Playwright + Chromium | Screenshots, mobile-width checks, logging in and submitting the settings form, testing the showcase and Blogger demos, rendering the featured image |
| Pillow | Saving the featured image as JPEG |
| `gzip -c file \| wc -c` | Measuring the compressed stylesheet size |
| `zip` | Packaging the installable theme |
| GitHub Desktop (your side) | Publishing the repository (see section 4) |

**Build step needed?** No. There is no npm install, Composer or bundler. The folder is the theme.

---

## 2. How It Works (the 30-second version)

```
Appearance → Business Details form
        │  (Settings API: nonce + sanitize)
        ▼
  option "sinag_theme_business"  ──►  binding source "sinag-theme/business"
                                              │  (called while a page renders)
templates/*.html ─► patterns/*.php ─► blocks with metadata.bindings ─► final HTML
        ▲
theme.json + styles/*.json ─► CSS variables (--wp--preset--color--accent …)
```

All design decisions live in data: a palette of seven named colours that every pattern refers to by name. The owner's contact details also live in one place, and any paragraph or button can ask for them through the Block Bindings API, so changing the phone number once updates the header, hero, contact card and footer.

---

## 3. Step-by-Step: How We Built It

### Step 1: Checked GitHub access and earlier work
`gh api user` answered `efraimray`, but listing his repositories and reading issues on earlier showcase repos (bukas-hours, pilaboard, kahera-pos, tinta-color-studio) returned "403 — session bound to configured repositories". So there were no `claude-improve` issues to work on tonight. The artifact gallery showed four earlier showcases: Bukas Hours (WordPress plugin), PilaBoard (queue app), Tinta Color Studio (developer tool) and Kahera POS (web app).

### Step 2: Picked the idea and why
The series had a plugin, two web apps and a developer tool, but no theme. A **block theme** for small businesses fits Efraim's local clients, rotates the project type, and shows modern WordPress skills (theme.json, style variations, Block Bindings) that page-builder themes don't. Name: *Sinag* ("ray of light"), slug `sinag-theme`.

### Step 3: Planned the data
- Seven colour slugs used everywhere: `base`, `base-2`, `contrast`, `contrast-2`, `accent`, `on-accent`, `line`.
- Five fields in one option: phone, email, address, hours, messenger, plus two computed keys (`phone_link`, `email_link`).
- A fictional sample business (Kapehan sa Burol, a café in Valencia City) for realistic pattern content with peso prices.

### Step 4: Wrote the design system — `theme.json` (JSON)
Version 3 schema: palette, system font stacks (no font downloads), fluid type sizes, a spacing scale, link/heading/button styles, and per-block styles for the site title, navigation, separator, post date, details and quote. A Python script then generated `styles/kape.json`, `dagat.json`, `palay.json` and `gabi.json` with the same slugs and new colours.

### Step 5: Wrote `style.css` (CSS)
The required theme header (name, version, `Requires at least: 6.6`, text domain, tags) and about 100 lines for the hero sun gradient, eyebrow labels, the Card / Price row / Check list block styles and the FAQ plus/minus.

### Step 6: Wrote `functions.php` and `inc/helpers.php` (PHP)
`functions.php` enqueues only the stylesheet, registers the "Sinag: Small Business" pattern category and three block styles. `inc/helpers.php` holds pure functions with no WordPress calls: `sinag_theme_clean_phone()`, `sinag_theme_phone_to_tel()` (turns `0917 123 4567` into `tel:+639171234567`) and `sinag_theme_is_web_url()` (only http/https).

### Step 7: Wrote `inc/business-details.php` (PHP)
An Appearance → Business Details screen built on the Settings API (nonce via `settings_fields()`, capability check, per-type sanitizing, unknown keys dropped, late escaping in the form), and the `sinag-theme/business` binding source whose callback returns an escaped value, a `tel:`/`mailto:`/cleaned URL for button links, or `null` to keep the sample text.

### Step 8: Wrote the patterns (PHP + block markup)
Ten files in `patterns/`: header with an hours bar, footer, sunrise hero, services grid, price list, hours and location, FAQ (native Details block), message CTA, and two hidden helpers (404 text, no-results text). All visible text uses `esc_html_e( '…', 'sinag-theme' )`. Phone, hours, address, email and button links carry `metadata.bindings`.

### Step 9: Wrote templates and parts (HTML block markup)
`front-page`, `index`, `single`, `page`, `page-landing` (registered as a custom template), `archive`, `search`, `404`; `parts/header.html` and `parts/footer.html` each load their pattern so the text stays translatable.

### Step 10: Static tests
- `php -l` on 14 PHP files: 0 errors.
- `php tests/test-helpers.php`: 12 of 12 passed.
- `node tests/validate.mjs`: 320 checks passed on the first run. To prove the checker catches mistakes, a copy of the theme had one closing heading comment deleted; it reported 2 failures.

Colour contrast measured by the test script:

| Palette | Body text on base | Muted text on base | Button text on accent |
|---|---:|---:|---:|
| Sinag (theme.json) | 14.83 | 6.58 | 8.31 |
| Kape | 14.92 | 6.38 | 7.87 |
| Dagat | 14.80 | 6.22 | 4.57 |
| Palay | 14.42 | 6.26 | 5.81 |
| Gabi | 15.79 | 8.54 | 9.75 |

Targets: 7 (AAA) for body text, 4.5 (AA) for the others. All pass.

### Step 11: Tested on a real WordPress install
wordpress.org downloads were blocked from the build machine (HTTP 403). The npm package `@wp-playground/wordpress-builds` contains WordPress 6.6-RC3 and the SQLite Database Integration plugin, so WordPress was unpacked, pointed at SQLite, installed with `wp_install()` and served with `php -S`.

| Check | Result |
|---|---|
| `wp_get_theme('sinag-theme')` | No errors, recognised as a block theme |
| Activation | Active; 4 style variations listed |
| Registration | 10 Sinag patterns, the binding source and the block styles registered |
| Sanitizing (fresh request) | `0926 555 0142<b>x</b>` saved as `0926 555 0142`; `javascript:alert(1)` saved as empty; unknown key dropped |
| Front page | HTTP 200; saved phone printed 3×, `tel:+639265550142` 2×, Messenger link 2×, hours 2×, `mailto:` 1× |
| Scripts | The theme enqueues none (only core's navigation script appears) |
| Other pages | Post, search, page: 200; missing post: 404; each has exactly one `<h1>` |
| Phone width (390 px) | Page width 390 = viewport, no sideways scroll |
| Admin screen (real login) | Nonce field present; form submit saves values |
| Page errors / debug log | None (only "can't reach wordpress.org" update warnings) |

**Problems found and fixed during this step:**
1. The first sanitize test ran in the same request that switched themes, so the old theme's hooks were still active and nothing was cleaned. Re-running in a fresh request showed the sanitizer working.
2. No "Settings saved" notice appeared, because WordPress only prints it automatically on Settings-menu pages. Added `settings_errors()` to the screen; re-test showed the notice.
3. The first screenshot showed gaps between the header, main area and colour bands; section headings narrower than the card rows; a 100 px footer separator; a CTA heading that wasn't centred; and a footer paragraph using `"align":"wide"` (which means text alignment on paragraphs). Fixes: zero top margin for top-level regions and zero block gap on the front page; heading groups set to wide alignment; separator `is-style-wide`; a CSS fallback for `.has-text-align-center`; the copyright paragraph wrapped in a wide group. The validator re-ran with 323 checks passing and the re-render looked right.
4. `screenshot.png` (1200×900) was then captured from this real render.

**Not tested:** the block editor itself. The Playground build ships only 4 of WordPress's editor JavaScript files (the rest are fetched online), so the editor could not load offline and block validation in the editor was not run.

### Step 12: Documentation
README.md, docs/TUTORIAL.md (file-by-file walkthrough with 3 exercises), docs/DEPLOYMENT.md (LocalWP, wp-env, GitHub Desktop, git CLI, Pages, releases), readme.txt in WordPress.org format, CHANGELOG.md, LICENSE (GPL-2.0-or-later with the full GPLv2 text), `.gitignore`, `.gitattributes`.

### Step 13: Showcase artifact
One self-contained page: a live sample café site styled from the five real palettes, a Business Details form that updates every bound spot (using the same phone and URL rules as the PHP), pattern show/hide/reorder, a desktop/phone toggle, the active palette's JSON with live contrast ratios, and an About section. Checked with `node --check` and Playwright at 1280 px light and 390 px dark: no sideways scroll, no page errors, `+63 88 828 1234` → `tel:+63888281234`, `javascript:` links rejected. A first screenshot looked washed out because it was taken during the 0.3-second colour transition; a second one after a short wait was correct. Published as **Showcase · Sinag** and copied to `demo/index.html` as a full HTML document.

### Step 14: Blogger post
`2026-10-15-blogger-sinag-theme.html` follows the reference template: settings comment, `TechArticle` JSON-LD, the template's scoped `.devs-*` CSS copied verbatim, a working mini-demo in the browser frame (style chips and a phone field), measured vitals, stack and architecture cards, three tabs of real HTML-escaped code, roadmap, three HTML slider scenes, resource cards and the verdict card. Checks: JSON-LD parses, `node --check` passes, no inline `onclick`, no images, no external scripts; Playwright in light and dark pages at 900 px and 390 px showed no sideways scroll, no errors, and working demo, tabs and slider.

### Step 15: Featured image
A 1200×630 HTML scene (dark grid, gold glow, "FREE WORDPRESS BLOCK THEME" pill, "Sinag / Block Theme", a café-site card with the five style swatches, three chips, efraimray.com) rendered by Playwright at 2× and saved as `sinag-theme-featured.jpg` (2400×1260, quality 88, 219 KB). Fonts were confirmed loaded before the capture; no text was clipped.

### Step 16: GitHub publishing
Creating the public repository through the GitHub API was refused by this session's permissions (cloud sessions are tied to pre-connected repositories). It was not retried. The repository is ready to publish with GitHub Desktop; the steps are in section 4 and docs/DEPLOYMENT.md.

### Step 17: Packaging
The folder was zipped as `sinag-theme.zip` with `sinag-theme/` at the top level, so it installs directly from Appearance → Themes → Upload Theme.

---

## 4. What You Received

| Deliverable | Where it lives |
|---|---|
| Installable theme + full repository | `sinag-theme.zip` (top-level `sinag-theme/` folder) |
| Live showcase | Claude artifact "Showcase · Sinag"; also `demo/index.html` |
| Blogger post | `2026-10-15-blogger-sinag-theme.html` (paste in HTML view) |
| Featured image | `sinag-theme-featured.jpg` (2400×1260) |
| Theme screenshot | `screenshot.png` (1200×900, real render) |
| Build log | `docs/BUILD-LOG.md` (this file) |
| Tutorial | `docs/TUTORIAL.md` |
| Deployment guide | `docs/DEPLOYMENT.md` |
| Project readme / WordPress readme | `README.md` / `readme.txt` |
| Tests | `tests/test-helpers.php`, `tests/validate.mjs` |

**To publish on GitHub with GitHub Desktop:** File → Add local repository → choose the unzipped `sinag-theme` folder → create a repository → commit "Sinag v1.0.0" → Publish repository (name `sinag-theme`, untick "Keep this code private"). Then add topics, create release `v1.0.0` with the zip, enable Pages from `main` / root, and upload the featured image as the social preview.

---

## 5. Known Limits and What's Next

**Limits**
- Tested on WordPress **6.6-RC3** only (the build machine could not download newer releases). The header says "Tested up to: 6.9"; confirm on a current install before relying on that.
- The block editor was not loaded, so editor-side block validation is unchecked. If the editor offers "Attempt recovery" on a pattern, accept it; the front end renders correctly either way.
- In the editor, bound blocks show the pattern's sample text; real values appear on the live site.
- No translation `.pot` file is included yet (generate one with `wp i18n make-pot . languages/sinag-theme.pot`).
- No Lighthouse audit was run.

**Roadmap**
- Register the binding source in JavaScript so the editor shows live values.
- Optional self-hosted font pairing.
- Variations and patterns for schools, LGUs and clinics; a printable menu.
- WooCommerce templates.

**Want a change?** Open an issue on the repository with the label **`claude-improve`**. The nightly run picks it up, implements it, bumps the version and adds a new dated section to this log.
