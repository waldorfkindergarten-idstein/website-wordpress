import { chromium } from 'playwright';
const b = await chromium.launch();
for (const w of [393, 1280]) {
  const page = await b.newPage({ viewport: { width: w, height: 900 } });
  await page.goto('http://neu.waldorfkindergarten-idstein.de/', { waitUntil: 'networkidle' });
  const r = await page.evaluate(() => {
    const credo = document.querySelector('.pb-credo');
    // the card directly above the credo, inside the same section
    const card = credo.parentElement.querySelector('.wp-block-group .wp-block-group');
    const pick = (el) => { if (!el) return null; const c = getComputedStyle(el); return {
      cls: (el.className||'').toString().slice(0,44),
      radius: c.borderRadius, border: c.borderTopWidth + ' ' + c.borderTopStyle + ' ' + c.borderTopColor,
      pad: c.padding, bg: c.backgroundColor, width: Math.round(el.getBoundingClientRect().width) }; };
    return { card: pick(card), credo: pick(credo) };
  });
  console.log(`--- ${w}px ---`);
  console.log('  card :', JSON.stringify(r.card));
  console.log('  credo:', JSON.stringify(r.credo));
  await page.close();
}
await b.close();
