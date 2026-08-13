import { chromium } from 'playwright';
const base = process.argv[2] || 'http://localhost:8080';
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 390, height: 844 } });
for (const slug of ['', 'impressum/', 'datenschutz/', 'intern/']) {
  await page.goto(base + '/' + slug, { waitUntil: 'networkidle' });
  const r = await page.evaluate(() => {
    const de = document.documentElement;
    let worst = null, max = 0;
    for (const el of document.querySelectorAll('main *')) {
      const w = el.getBoundingClientRect().right;
      if (w > max) { max = w; worst = el.tagName + '.' + (el.className || '').toString().slice(0, 40); }
    }
    return {
      scrollW: de.scrollWidth, clientW: de.clientWidth,
      overflow: de.scrollWidth - de.clientWidth,
      widest: worst, widestRight: Math.round(max),
      headings: [...document.querySelectorAll('main h1')].map(h => h.textContent.trim()),
    };
  });
  console.log(`${(slug || '/').padEnd(14)} scroll=${r.scrollW} client=${r.clientW} overflow=${r.overflow}px  h1=${JSON.stringify(r.headings)}`);
  if (r.overflow > 0) console.log(`    widest: ${r.widest} right=${r.widestRight}`);
}
await b.close();
