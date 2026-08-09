/**
 * Visual regression compare.
 *
 *   node visual/compare.mjs <baselineLabel> <candidateLabel>
 *
 * Reports, per screenshot, the share of pixels that changed and writes a diff
 * image highlighting them. Then reports the geometry fingerprint delta, which
 * says *what* moved rather than merely that something did.
 *
 * Exit code 1 if anything exceeds threshold, so it can gate a commit.
 */
import { readFileSync, writeFileSync, existsSync, mkdirSync, readdirSync } from 'fs';
import { join, dirname } from 'path';
import { fileURLToPath } from 'url';
import { PNG } from 'pngjs';
import pixelmatch from 'pixelmatch';

// Resolve against this file, not the shell's cwd.
const HERE = dirname(fileURLToPath(import.meta.url));

const [, , baseLabel, candLabel] = process.argv;
if (!baseLabel || !candLabel) {
	console.error('usage: node compare.mjs <baseline> <candidate>');
	process.exit(1);
}

const baseDir = join(HERE, baseLabel);
const candDir = join(HERE, candLabel);
const diffDir = join(HERE, `diff-${baseLabel}-vs-${candLabel}`);
mkdirSync(diffDir, { recursive: true });

// Fraction of differing pixels tolerated before a shot is called changed.
const PIXEL_THRESHOLD = 0.001; // 0.1%

const shots = readdirSync(baseDir).filter(f => f.endsWith('.png')).sort();
const rows = [];
let failed = false;

for (const shot of shots) {
	const aPath = join(baseDir, shot);
	const bPath = join(candDir, shot);
	if (!existsSync(bPath)) {
		rows.push({ shot, status: 'MISSING in candidate' });
		failed = true;
		continue;
	}
	const a = PNG.sync.read(readFileSync(aPath));
	const b = PNG.sync.read(readFileSync(bPath));

	if (a.width !== b.width || a.height !== b.height) {
		rows.push({ shot, status: `SIZE ${a.width}x${a.height} -> ${b.width}x${b.height}` });
		failed = true;
		continue;
	}
	const diff = new PNG({ width: a.width, height: a.height });
	const changed = pixelmatch(a.data, b.data, diff.data, a.width, a.height, {
		threshold: 0.12,          // per-pixel colour tolerance (antialiasing)
		includeAA: false
	});
	const share = changed / (a.width * a.height);
	if (share > PIXEL_THRESHOLD) {
		writeFileSync(join(diffDir, shot), PNG.sync.write(diff));
		failed = true;
	}
	rows.push({ shot, changedPx: changed, share: (share * 100).toFixed(3) + '%', status: share > PIXEL_THRESHOLD ? 'CHANGED' : 'ok' });
}

console.log('Pixel comparison');
if (!shots.length) {
	// Screenshots are gitignored (~55 MB), so a fresh clone has none. Say so
	// loudly — silence here would read as "passed" when nothing was compared.
	console.log(`  no baseline screenshots in ${baseDir}`);
	console.log('  geometry only. To get pixel coverage, capture a baseline from a');
	console.log('  known-good checkout first:  npm run capture -- baseline');
} else {
	for (const r of rows) {
		console.log(`  ${r.shot.padEnd(18)} ${String(r.changedPx ?? '').padStart(9)}  ${String(r.share ?? '').padStart(8)}  ${r.status}`);
	}
}

// ---- geometry fingerprint ----
const ga = JSON.parse(readFileSync(join(baseDir, 'geometry.json'), 'utf8'));
const gb = JSON.parse(readFileSync(join(candDir, 'geometry.json'), 'utf8'));
const moves = [];

for (const key of Object.keys(ga)) {
	const A = ga[key], B = gb[key];
	if (!B) { moves.push(`${key}: missing in candidate`); continue; }
	for (const sel of Object.keys(A)) {
		const x = A[sel], y = B[sel];
		if (!y) { moves.push(`${key} ${sel}: element gone`); continue; }
		if (x.count !== y.count) moves.push(`${key} ${sel}: count ${x.count} -> ${y.count}`);
		for (const prop of ['x', 'y', 'w', 'h']) {
			const d = Math.round((y.first[prop] - x.first[prop]) * 10) / 10;
			if (Math.abs(d) > 1) moves.push(`${key} ${sel}: ${prop} ${x.first[prop]} -> ${y.first[prop]} (${d > 0 ? '+' : ''}${d})`);
		}
		for (const prop of ['color', 'bg', 'font', 'radius']) {
			if (x.first[prop] !== y.first[prop]) moves.push(`${key} ${sel}: ${prop} "${x.first[prop]}" -> "${y.first[prop]}"`);
		}
	}
	for (const sel of Object.keys(B)) {
		if (!A[sel]) moves.push(`${key} ${sel}: new element`);
	}
}

console.log('\nGeometry fingerprint');
if (!moves.length) {
	console.log('  identical — no element moved, resized, or restyled');
} else {
	failed = true;
	for (const m of moves.slice(0, 60)) console.log('  ' + m);
	if (moves.length > 60) console.log(`  … and ${moves.length - 60} more`);
}

console.log(`\n${failed ? 'DIFFERENCES FOUND' : 'IDENTICAL'} — diffs in ${diffDir}`);
process.exit(failed ? 1 : 0);
