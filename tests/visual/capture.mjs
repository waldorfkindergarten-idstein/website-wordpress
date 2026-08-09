/**
 * Visual regression capture.
 *
 *   node visual/capture.mjs <label> [baseUrl]
 *
 * Writes visual/<label>/<page>-<width>.png plus geometry.json, a structural
 * fingerprint used to turn pixel differences into readable statements like
 * ".pb-gcard moved 4px down".
 *
 * Rendering is forced deterministic so a diff means a real change:
 *   - animations and transitions disabled
 *   - scroll-reveal states forced on
 *   - lazy images made eager and decoded
 *   - webfonts awaited
 *   - scroll position pinned to top
 *   - state-dependent chrome (back-to-top button) hidden
 */
import { chromium } from 'playwright';
import { mkdirSync, writeFileSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';

// Resolve against this file, not the shell's cwd, so the harness behaves the
// same whether it is run from the repo root or from tests/visual.
const HERE = dirname(fileURLToPath(import.meta.url));

const label = process.argv[2];
const base = process.argv[3] || process.env.WALDORF_BASE_URL || 'http://localhost:8080';
if (!label) {
	console.error('usage: node capture.mjs <label> [baseUrl]');
	process.exit(1);
}

const PAGES = [
	{ name: 'home', path: '/' },
	{ name: 'post', path: '/wir-suchen-erzieherinnen/' },
	{ name: 'notfound', path: '/nope/' }
];
const WIDTHS = [390, 768, 1280, 1440];

// Selectors sampled for the structural fingerprint. Chosen to cover every
// section so a layout shift anywhere shows up as a named element, not a
// nameless block of differing pixels.
const PROBES = [
	'.pb-topbar', '.pb-header', '.pb-hero', '.pb-hero__bg', '.pb-seal', '.pb-date-pill',
	'.pb-chips', '.pb-facts', '.pb-season', '.pb-season__ring', '.pb-credo',
	'.pb-mosaic', '.pb-mosaic__1', '.pb-mosaic__4', '.pb-gcard', '.pb-gcard__photo',
	'.pb-timeline', '.pb-tl', '.pb-week', '.pb-day', '.pb-fest', '.pb-grain',
	'.pb-team', '.pb-person', '.pb-quote', '.pb-steps', '.pb-step', '.pb-faq',
	'.pb-ncard', '.pb-ncard--featured', '.pb-termine', '.pb-downloads', '.pb-dl',
	'.pb-cta', '.pb-kbox', '.pb-krow', '.pb-footer', '.pb-sec-head'
];

const FREEZE = `
  *, *::before, *::after {
    animation: none !important;
    transition: none !important;
    caret-color: transparent !important;
  }
  html { scroll-behavior: auto !important; }
  .pb-totop { display: none !important; }
`;

const outDir = join(HERE, label);
mkdirSync(outDir, { recursive: true });

const browser = await chromium.launch();
const geometry = {};
const problems = [];

for (const pg of PAGES) {
	for (const width of WIDTHS) {
		const page = await browser.newPage({ viewport: { width, height: 900 }, deviceScaleFactor: 1 });
		page.on('console', m => { if (m.type() === 'error') problems.push(`${pg.name}@${width} console: ${m.text()}`); });
		page.on('requestfailed', r => problems.push(`${pg.name}@${width} failed: ${r.url().split('/').pop()}`));

		await page.goto(base + pg.path, { waitUntil: 'networkidle', timeout: 60000 });
		await page.addStyleTag({ content: FREEZE });

		await page.evaluate(() => {
			document.querySelectorAll('img').forEach(i => { i.loading = 'eager'; i.decoding = 'sync'; });
			document.querySelectorAll('.pb-reveal').forEach(e => e.classList.add('is-in'));
		});
		// walk the page so every lazy image commits, then return to the top
		await page.evaluate(async () => {
			for (let y = 0; y < document.body.scrollHeight; y += window.innerHeight) {
				window.scrollTo(0, y);
				await new Promise(r => setTimeout(r, 40));
			}
			window.scrollTo(0, 0);
		});
		await page.evaluate(() => Promise.all(
			[...document.images].filter(i => !i.complete).map(i => i.decode().catch(() => {}))
		));
		await page.evaluate(() => document.fonts.ready);
		await page.waitForTimeout(400);

		const key = `${pg.name}-${width}`;
		await page.screenshot({ path: join(outDir, key + '.png'), fullPage: true });

		geometry[key] = await page.evaluate((probes) => {
			const round = n => Math.round(n * 10) / 10;
			const out = {};
			for (const sel of probes) {
				const nodes = [...document.querySelectorAll(sel)];
				if (!nodes.length) continue;
				out[sel] = {
					count: nodes.length,
					first: (() => {
						const r = nodes[0].getBoundingClientRect();
						const cs = getComputedStyle(nodes[0]);
						return {
							x: round(r.left + window.scrollX), y: round(r.top + window.scrollY),
							w: round(r.width), h: round(r.height),
							color: cs.color, bg: cs.backgroundColor,
							font: `${cs.fontFamily.split(',')[0]} ${cs.fontSize}/${cs.lineHeight} ${cs.fontWeight}`,
							radius: cs.borderRadius
						};
					})()
				};
			}
			out['#document'] = { count: 1, first: {
				x: 0, y: 0,
				w: round(document.documentElement.scrollWidth),
				h: round(document.documentElement.scrollHeight),
				color: '', bg: '', font: '', radius: ''
			} };
			return out;
		}, PROBES);

		await page.close();
	}
}

writeFileSync(join(outDir, 'geometry.json'), JSON.stringify(geometry, null, 1));
await browser.close();

console.log(JSON.stringify({
	label,
	shots: PAGES.length * WIDTHS.length,
	probes: Object.keys(geometry['home-1440'] || {}).length,
	problems
}, null, 1));
