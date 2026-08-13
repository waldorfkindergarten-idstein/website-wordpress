import { chromium } from 'playwright';
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 393, height: 900 } });
await page.goto('http://neu.waldorfkindergarten-idstein.de/', { waitUntil: 'networkidle' });
const r = await page.evaluate(() => {
  const credo = document.querySelector('.pb-credo');
  const section = credo.closest('.wp-block-group').parentElement;
  const out = [];
  for (const el of section.querySelectorAll('*')) {
    const c = getComputedStyle(el);
    if (parseFloat(c.borderTopLeftRadius) > 4 && parseFloat(c.borderTopWidth) > 0) {
      out.push({ cls: (el.className||'').toString().slice(0,50), radius: c.borderTopLeftRadius,
                 border: c.borderTopWidth + ' ' + c.borderTopStyle + ' ' + c.borderTopColor,
                 pad: c.padding, bg: c.backgroundColor });
      if (out.length >= 2) break;
    }
  }
  return out;
});
console.log(JSON.stringify(r, null, 2));
await b.close();
