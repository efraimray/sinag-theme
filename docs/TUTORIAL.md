# Sinag Tutorial: How a Block Theme Works, File by File

This guide is for people who know a little HTML and CSS and want to understand how a modern WordPress **block theme** is put together. You don't need to know PHP well; every PHP piece is explained.

## 1. The big picture

A classic WordPress theme is mostly PHP templates (`header.php`, `single.php`, …). A **block theme** is mostly *data*:

```
theme.json + styles/*.json   →  design tokens (colours, fonts, spacing) → CSS variables
templates/*.html             →  which blocks make up each kind of page
parts/*.html                 →  reusable regions (header, footer)
patterns/*.php               →  ready-made groups of blocks, with translatable text
functions.php + inc/         →  the small amount of PHP that data can't do
```

When a visitor opens a page, WordPress picks a template (for example `front-page.html`), reads its block markup, expands template parts and patterns, renders every block to HTML, and prints CSS generated from `theme.json`.

## 2. `style.css` — the theme's ID card

The comment at the top is required. WordPress reads `Theme Name`, `Version`, `Requires at least: 6.6`, `Text Domain: sinag-theme` and so on from it. Below the header is a small CSS layer for things `theme.json` can't express: the CSS "sun" behind the hero (`.sinag-hero::before`), the dotted price leaders, the check-mark list and the FAQ plus/minus sign.

## 3. `theme.json` — the design system

Key concepts:

- **`settings.color.palette`** — seven colours with *slugs*: `base`, `base-2`, `contrast`, `contrast-2`, `accent`, `on-accent`, `line`. WordPress turns each into a CSS variable such as `--wp--preset--color--accent` and a class such as `has-accent-background-color`.
- **Same slugs everywhere.** Patterns only ever say "accent" or "contrast", never a hex value. That is why a style variation can recolour the whole site by changing seven values.
- **`settings.typography.fontFamilies`** — system font stacks (Charter/Georgia for headings, the device's UI sans for text). No font files are downloaded.
- **`styles`** — global defaults: body colours, link underline, heading font, button colours (`accent` background with `on-accent` text) and hover/focus states.
- **`useRootPaddingAwareAlignments`** — lets full-width bands reach the screen edge while the text inside keeps the side padding.

## 4. `styles/*.json` — style variations

Each file (`kape.json`, `dagat.json`, `palay.json`, `gabi.json`) is a tiny `theme.json` with a `title` and a new palette. In Appearance → Editor → Styles, the user clicks one and WordPress merges it over `theme.json`.

## 5. Templates and parts

`templates/front-page.html` is plain block markup:

```html
<!-- wp:template-part {"slug":"header","tagName":"header"} /-->
<!-- wp:group {"tagName":"main", ...} -->
<main class="wp-block-group alignfull"><!-- wp:pattern {"slug":"sinag-theme/hero-sunrise"} /--> …</main>
<!-- /wp:group -->
<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->
```

Each `<!-- wp:name {json} -->` comment is a block. `/-->` means the block has no inner content. `parts/header.html` is a single line that loads the `sinag-theme/header` pattern. Doing it this way keeps the header text translatable, because only PHP patterns can call `esc_html_e()`.

Other templates: `index.html` (blog list with a Query Loop), `single.html` (post + comments), `page.html`, `page-landing.html` (no title, for pages built from patterns), `archive.html`, `search.html`, `404.html`.

## 6. Patterns

A pattern is a PHP file whose header comment registers it automatically (WordPress 6.0+):

```php
/**
 * Title: Sunrise hero
 * Slug: sinag-theme/hero-sunrise
 * Categories: sinag-business, banner, featured
 */
```

Below the header is block markup with PHP only for translatable text, for example `<?php esc_html_e( 'Prices', 'sinag-theme' ); ?>`. `Inserter: no` hides helper patterns (the 404 message and the "no results" text).

## 7. `functions.php`

Four small jobs:

1. Load `inc/helpers.php` and `inc/business-details.php`.
2. Enqueue `style.css` (`sinag_theme_enqueue_styles`). No scripts.
3. Register the **Sinag: Small Business** pattern category.
4. Register block styles: **Card** and **Price row** for Group, **Check list** for List. The CSS for each lives in `style.css` as `.is-style-…`.

## 8. `inc/helpers.php` — pure functions

These have no WordPress calls, so `tests/test-helpers.php` can test them with plain PHP:

- `sinag_theme_clean_phone()` keeps digits, `+`, brackets, dashes and spaces.
- `sinag_theme_phone_to_tel()` builds a `tel:` link: `+63…` stays, `63…` (12 digits) gets a plus, numbers starting with `0` lose the zero and gain `+63`, anything else stays as bare digits.
- `sinag_theme_is_web_url()` returns the URL only when its scheme is `http` or `https` (so `javascript:` links can't sneak in).

## 9. `inc/business-details.php` — the settings screen and the binding source

**Saving (input):** `register_setting()` registers the option `sinag_theme_business` with `sinag_theme_sanitize_business()` as its sanitize callback. The form uses `settings_fields()`, which prints the nonce, and posts to `options.php`. Unknown keys are dropped; each field is cleaned by type.

**Printing (output):** `register_block_bindings_source( 'sinag-theme/business', … )` tells WordPress that blocks may ask this source for values. A paragraph asks like this:

```html
<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"sinag-theme/business","args":{"key":"phone"}}}}} -->
```

At render time WordPress calls `sinag_theme_business_binding_value( $source_args, $block, 'content' )`. It returns the escaped value, or `null` when the field is empty, which tells WordPress to keep the block's sample text. For button `url` attributes it returns a `tel:`, `mailto:` or cleaned `https:` URL.

**Key ideas:** *sanitize on the way in, escape on the way out*, and *keep logic (helpers) separate from output (bindings, templates)*.

## 10. Tests

- `php tests/test-helpers.php` — 12 cases for the helper functions.
- `node tests/validate.mjs` — parses every JSON file, checks every block comment is opened and closed in the right order with valid JSON attributes, checks every referenced pattern and template part exists, checks every binding key and text domain, and computes WCAG contrast for each palette.

## 11. Extension exercises

1. **Add a "Tindahan" variation.** Copy `styles/palay.json` to `styles/tindahan.json`, set the title, pick seven colours for a sari-sari store, then run `node tests/validate.mjs`. If a contrast check fails, darken `contrast-2` or `accent` until it passes.
2. **Add a `facebook` field.** Add `'facebook' => 'url'` to `sinag_theme_business_fields()`, a label in `sinag_theme_business_labels()`, then bind a new button's `url` to `{"key":"facebook"}` in the footer pattern. Add `'facebook'` to the `KEYS` list in `tests/validate.mjs`.
3. **Make an "Announcement bar" pattern.** Create `patterns/announcement.php` with a full-width Group using `backgroundColor":"accent"` and `textColor":"on-accent"`, one paragraph of translatable text, and `Block Types: core/template-part/header` so it appears when editing the header.
