# Changelog

All notable changes to Sinag are documented here. This project follows [Semantic Versioning](https://semver.org/).

## [1.0.0] - 2026-10-15

### Added
- Block theme built on `theme.json` version 3 (WordPress 6.6+): 7-colour palette, system font stacks, fluid type and spacing scales.
- Style variations: Sinag (default), Kape, Dagat, Palay and Gabi (dark).
- Templates: front page, index, single, page, landing page (no title), archive, search, 404. Template parts: header, footer.
- Patterns: header with hours bar, footer, sunrise hero, services grid, peso price list, hours and location, FAQ (Details block), message call-to-action, plus hidden 404 and no-results patterns.
- Block styles: Card and Price row (Group), Check list (List).
- Appearance → Business Details screen (Settings API, nonce, sanitizing) and the `sinag-theme/business` Block Bindings source for phone, Call link (+63), email, address, hours and Messenger link.
- Test scripts: `tests/test-helpers.php` (12 cases) and `tests/validate.mjs` (block markup, references, text domain, WCAG contrast).
