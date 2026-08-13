import { chromium } from 'playwright';
const b = await chromium.launch();
for (const w of [320, 360, 390]) {
  for (const [label, url, restore] of [
      ['staging(no guard)', 'http://neu.waldorfkindergarten-idstein.de/datenschutz/', true],
      ['local  (guard)   ', 'http://localhost:8080/datenschutz/', true]]) {
    const page = await b.newPage({ viewport: { width: w, height: 844 } });
    await page.goto(url, { waitUntil: 'networkidle' });
    const r = await page.evaluate((restore) => {
      if (restore) {
        const h = document.querySelector('main h1');
        if (h) h.textContent = 'Datenschutzerklärung';
      }
      const de = document.documentElement;
      let worst = null, max = 0;
      for (const el of document.querySelectorAll('body *')) {
        const rect = el.getBoundingClientRect();
        if (rect.right > max) { max = rect.right; worst = `${el.tagName}.${(el.className||'').toString().trim().split(/\s+/)[0]||''}`; }
      }
      return { ov: de.scrollWidth - de.clientWidth, worst, max: Math.round(max) };
    }, restore);
    console.log(`w=${w}  ${label}  overflow=${String(r.ov).padStart(3)}px  widest=${r.worst} right=${r.max}`);
    await page.close();
  }
}
await b.close();
