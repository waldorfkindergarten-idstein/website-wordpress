import { chromium } from 'playwright';
const b = await chromium.launch();
const base = 'http://neu.waldorfkindergarten-idstein.de';
for (const w of [320, 393, 1280]) {
  const page = await b.newPage({ viewport: { width: w, height: 900 } });
  await page.goto(base + '/', { waitUntil: 'networkidle' });
  const home = await page.evaluate(() => {
    const de = document.documentElement, c = getComputedStyle(document.querySelector('.pb-credo'));
    return { ov: de.scrollWidth - de.clientWidth, radius: c.borderTopLeftRadius, bl: c.borderLeftWidth };
  });
  await page.goto(base + '/datenschutz/', { waitUntil: 'networkidle' });
  const dse = await page.evaluate(() => {
    const de = document.documentElement;
    return { ov: de.scrollWidth - de.clientWidth, h1: [...document.querySelectorAll('main h1')].map(h=>h.textContent.trim()) };
  });
  console.log(`${String(w).padStart(4)}px  home overflow=${home.ov}px credo(radius=${home.radius}, borderLeft=${home.bl})  |  datenschutz overflow=${dse.ov}px h1=${JSON.stringify(dse.h1)}`);
  await page.close();
}
await b.close();
