#!/usr/bin/env node
/**
 * Static checks for the Sinag block theme (no WordPress needed).
 * Run from the theme root:  node tests/validate.mjs
 *
 * 1. Every JSON file parses.
 * 2. Block comments in templates, parts and patterns are balanced and their attributes are valid JSON.
 * 3. Every referenced pattern and template part exists.
 * 4. Pattern headers have a Title and a sinag-theme/ Slug.
 * 5. Every Business Details binding uses a known key.
 * 6. Every translation call uses the sinag-theme text domain.
 * 7. Each colour palette (default + 4 variations) passes WCAG contrast targets.
 */
import fs from 'node:fs';
import path from 'node:path';

const root = process.cwd();
let failures = 0;
let checks = 0;
const ok = (cond, msg) => { checks++; if (!cond) { failures++; console.log('  FAIL ' + msg); } };
const read = (f) => fs.readFileSync(path.join(root, f), 'utf8');
const list = (dir, ext) => fs.existsSync(path.join(root, dir)) ? fs.readdirSync(path.join(root, dir)).filter((f) => f.endsWith(ext)).map((f) => dir + '/' + f) : [];

// 1. JSON
const jsonFiles = ['theme.json', ...list('styles', '.json')];
const palettes = {};
for (const f of jsonFiles) {
  let data = null;
  try { data = JSON.parse(read(f)); } catch (e) { ok(false, f + ' is not valid JSON: ' + e.message); continue; }
  ok(data.version === 3, f + ' uses theme.json version 3');
  const pal = data?.settings?.color?.palette;
  if (pal) palettes[f] = Object.fromEntries(pal.map((c) => [c.slug, c.color]));
}

// 2. Block markup
const markupFiles = [...list('templates', '.html'), ...list('parts', '.html'), ...list('patterns', '.php')];
const BLOCK = /<!--\s+(\/)?wp:([a-z0-9\-\/]+)(\s+(\{[\s\S]*?\}))?\s+(\/)?-->/g;
const refs = { patterns: new Set(), parts: new Set(), bindingKeys: new Set() };
for (const f of markupFiles) {
  const src = read(f).replace(/<\?php[\s\S]*?\?>/g, 'X');
  const stack = [];
  let m;
  while ((m = BLOCK.exec(src))) {
    const [, closing, name, , attrs, selfClosing] = m;
    if (attrs) {
      let a = null;
      try { a = JSON.parse(attrs); } catch (e) { ok(false, `${f}: bad JSON in wp:${name} → ${attrs.slice(0, 60)}`); }
      if (a) {
        if (name === 'pattern') refs.patterns.add(a.slug);
        if (name === 'template-part') refs.parts.add(a.slug);
        const b = a.metadata?.bindings;
        if (b) for (const k in b) { ok(b[k].source === 'sinag-theme/business', `${f}: binding source`); refs.bindingKeys.add(b[k].args?.key); }
      }
    }
    if (selfClosing) continue;
    if (closing) { const top = stack.pop(); ok(top === name, `${f}: closing wp:${name} but open was wp:${top}`); }
    else stack.push(name);
  }
  ok(stack.length === 0, `${f}: unclosed blocks ${stack.join(', ')}`);
}

// 3 + 4. References and headers
const patternSlugs = new Set();
for (const f of list('patterns', '.php')) {
  const head = read(f).slice(0, 800);
  const slug = (head.match(/^\s*\*\s*Slug:\s*(.+)$/m) || [])[1]?.trim();
  ok(/^\s*\*\s*Title:\s*\S/m.test(head), `${f}: has Title`);
  ok(slug && slug.startsWith('sinag-theme/'), `${f}: slug prefixed sinag-theme/`);
  if (slug) patternSlugs.add(slug);
}
for (const s of refs.patterns) ok(patternSlugs.has(s), `pattern "${s}" exists`);
for (const s of refs.parts) ok(fs.existsSync(path.join(root, 'parts', s + '.html')), `part "${s}" exists`);
const tj = JSON.parse(read('theme.json'));
for (const t of tj.customTemplates || []) ok(fs.existsSync(path.join(root, 'templates', t.name + '.html')), `custom template ${t.name} exists`);

// 5. Binding keys
const KEYS = ['phone', 'phone_link', 'email', 'email_link', 'address', 'hours', 'messenger'];
for (const k of refs.bindingKeys) ok(KEYS.includes(k), `binding key "${k}" is known`);

// 6. Text domain
const phpFiles = ['functions.php', ...list('inc', '.php'), ...list('patterns', '.php')];
const I18N = /\b(?:__|_e|_x|esc_html__|esc_html_e|esc_attr__|esc_attr_e|esc_attr_x|esc_html_x|_n)\(\s*([\s\S]*?)\)\s*[;),?]/g;
let i18nCalls = 0;
for (const f of phpFiles) {
  const src = read(f);
  let m;
  while ((m = I18N.exec(src))) { i18nCalls++; ok(/'sinag-theme'\s*$/.test(m[1].trim()), `${f}: text domain in ${m[0].slice(0, 50)}`); }
}

// 7. Contrast
const lum = (hex) => {
  const v = hex.replace('#', '').match(/../g).map((h) => parseInt(h, 16) / 255).map((c) => (c <= 0.03928 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4));
  return 0.2126 * v[0] + 0.7152 * v[1] + 0.0722 * v[2];
};
const ratio = (a, b) => { const [x, y] = [lum(a), lum(b)].sort((p, q) => q - p); return (x + 0.05) / (y + 0.05); };
const pairs = [['contrast', 'base', 7], ['contrast', 'base-2', 7], ['contrast-2', 'base', 4.5], ['on-accent', 'accent', 4.5], ['base', 'contrast', 7]];
const table = [];
for (const [f, p] of Object.entries(palettes)) {
  const row = { palette: f };
  for (const [fg, bg, min] of pairs) { const r = ratio(p[fg], p[bg]); row[`${fg}/${bg}`] = r.toFixed(2); ok(r >= min, `${f}: ${fg} on ${bg} = ${r.toFixed(2)} (needs ${min})`); }
  table.push(row);
}
console.table(table);
console.log(`Files: ${jsonFiles.length} JSON, ${markupFiles.length} markup. Patterns: ${patternSlugs.size}. i18n calls: ${i18nCalls}. Binding keys used: ${[...refs.bindingKeys].join(', ')}`);
console.log(`${checks} checks, ${failures} failed`);
process.exit(failures ? 1 : 0);
