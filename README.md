# Sinag — WordPress Block Theme for Philippine Small Businesses

**A fast, script-free block theme with five style variations, ready-made business patterns, and a Business Details screen that fills your phone, hours and address into every section.**

![Version](https://img.shields.io/badge/version-1.0.0-f2b01e) ![WordPress](https://img.shields.io/badge/WordPress-6.6%2B-21759b) ![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4) ![theme.json](https://img.shields.io/badge/theme.json-v3-14261d) ![License](https://img.shields.io/badge/license-GPL--2.0--or--later-3f9d6b)

**Live demo:** https://efraimray.github.io/sinag-theme/demo/

> **Screenshot:** `screenshot.png` (1200×900) is a real capture of the theme's front page rendered by WordPress 6.6. Upload `sinag-theme-featured.jpg` (delivered with the release kit) as the repository's social preview image.

New here? Read [docs/BUILD-LOG.md](docs/BUILD-LOG.md) for the languages used and how this was built.

---

## Features

- **Five style variations** — Sinag (morning green and sun gold), Kape (coffee), Dagat (sea), Palay (rice field) and Gabi (dark).
- **Business patterns** — sunrise hero, services grid, price list in pesos with dotted leaders, hours and location, FAQ, message call-to-action, header with an hours bar, and a contact footer.
- **Business Details screen** (Appearance → Business Details) — phone, email, address, one-line hours and a Messenger/chat link, saved once and printed into blocks through the WordPress **Block Bindings API**.
- **Automatic +63 Call links** — `0917 123 4567` becomes `tel:+639171234567`; landlines like `(088) 828-1234` become `tel:+63888281234`.
- **Zero theme JavaScript, zero web fonts, zero external requests** — system font stacks keep pages light on mobile data.
- **Accessible colours** — every palette passes WCAG AA; body text passes AAA (checked by `tests/validate.mjs`).
- **Translation-ready** — all pattern text goes through `esc_html_e()` with the `sinag-theme` text domain.

## Tech Stack

| Layer | What |
|---|---|
| Platform | WordPress 6.6+ Full Site Editing (block theme) |
| Design tokens | `theme.json` version 3 + 4 style variations in `styles/` |
| Server code | PHP 7.4+ (Settings API, Block Bindings API, block patterns) |
| Markup | Block markup in HTML templates and PHP patterns |
| Styling | ~100 lines of CSS for things `theme.json` can't express |
| Tests | Plain PHP (`tests/test-helpers.php`) and Node.js (`tests/validate.mjs`) |

No build step, no npm install, no Composer.

## Folder Structure

```
sinag-theme/
├── style.css               Theme header + small CSS layer
├── theme.json              Palette, fonts, spacing, element and block styles
├── functions.php           Enqueue stylesheet, pattern category, block styles
├── inc/
│   ├── helpers.php         Pure PHP: phone cleanup, +63 tel: links, URL check
│   └── business-details.php Settings screen + Block Bindings source
├── templates/              front-page, index, single, page, page-landing, archive, search, 404
├── parts/                  header.html, footer.html (load the header/footer patterns)
├── patterns/               10 PHP patterns (8 in the inserter, 2 hidden)
├── styles/                 kape.json, dagat.json, palay.json, gabi.json
├── tests/                  test-helpers.php, validate.mjs
├── demo/index.html         Standalone interactive preview (GitHub Pages)
├── docs/                   BUILD-LOG.md, TUTORIAL.md, DEPLOYMENT.md
├── screenshot.png          1200×900 theme screenshot
├── readme.txt              WordPress.org-format readme
└── CHANGELOG.md, LICENSE
```

## Quick Start / Installation

1. Download `sinag-theme.zip` from [Releases](https://github.com/EfraimRay/sinag-theme/releases).
2. wp-admin → **Appearance → Themes → Add New → Upload Theme** → choose the zip → **Install Now** → **Activate**.
3. **Appearance → Business Details** → fill in phone, email, address, hours and chat link → **Save details**.
4. **Appearance → Editor → Styles** → pick Sinag, Kape, Dagat, Palay or Gabi.

From source: copy this folder into `wp-content/themes/sinag-theme/` and activate it.

## Usage

- The **front page** template already stacks the hero, services, price list, hours, FAQ and CTA patterns. Edit it in Appearance → Editor → Templates → Front Page.
- Add any section to any page from the inserter → **Patterns → Sinag: Small Business**.
- Use the **Landing (no title)** page template for campaign pages built entirely from patterns.
- Block styles: select a Group and choose **Card** or **Price row**; select a List and choose **Check list**.

### Binding your own blocks to Business Details

Paste into the Code editor (⋮ → Code editor):

```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"phone"}}}}} -->
<p>0917 000 0000</p>
<!-- /wp:paragraph -->
```

Keys: `phone`, `phone_link`, `email`, `email_link`, `address`, `hours`, `messenger`. Buttons can bind `url` (for example `phone_link` or `messenger`). Empty fields keep the block's own text.

## Configuration

| Setting | Where |
|---|---|
| Colours, fonts, spacing | `theme.json` or Appearance → Editor → Styles |
| Business details | Appearance → Business Details (option `sinag_theme_business`) |
| Menu | Appearance → Editor → Navigation |
| Logo | Site Logo block in the header (Appearance → Editor → Patterns → Header) |

## Deployment

See [docs/DEPLOYMENT.md](docs/DEPLOYMENT.md) for LocalWP / wp-env testing, publishing with GitHub Desktop or the git CLI, GitHub Pages for the demo, and tagging releases.

## Customization

- **New colour scheme:** copy `styles/kape.json`, rename it, change the seven hex values, keep the slugs, then run `node tests/validate.mjs` to check contrast.
- **New pattern:** add a PHP file to `patterns/` with a `Title` and `Slug: sinag-theme/...` header. Wrap visible text in `esc_html_e( '…', 'sinag-theme' )`.
- **Child theme:** create a folder with a `style.css` that has `Template: sinag-theme` and an optional `theme.json` with overrides.

## Roadmap

- Show bound Business Details inside the editor (register the binding source in JavaScript too).
- Bundled, self-hosted font pairing as an optional style.
- WooCommerce templates for small online stores.
- More variations for schools, LGUs and clinics, plus a printable menu pattern.

## Contributing

Issues and pull requests are welcome. Run before opening a PR:

```bash
find . -name "*.php" -exec php -l {} \;
php tests/test-helpers.php
node tests/validate.mjs
```

## Requesting improvements

Open an issue and add the label **`claude-improve`**. The nightly showcase run picks up open `claude-improve` issues, implements them, bumps the version and publishes a release.

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).

## Author

**Efraim Ray** — web developer and AI automation specialist, Valencia City, Bukidnon, Philippines — https://www.efraimray.com/ · [GitHub](https://github.com/EfraimRay)
