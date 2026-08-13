import { chromium } from 'playwright';
const b = await chromium.launch();
for (const [label, url] of [['local  ', 'http://localhost:8080/'], ['staging', 'http://neu.waldorfkindergarten-idstein.de/']]) {
  const page = await b.newPage({ viewport: { width: 1280, height: 900 } });
  await page.goto(url, { waitUntil: 'networkidle' });
  const r = await page.evaluate(() => {
    const h = document.querySelector('.pb-hero h1');
    return { textWrap: getComputedStyle(h).textWrap || getComputedStyle(h).textWrapStyle,
             inline: h.getAttribute('style'), text: h.textContent.trim().slice(0, 40) };
  });
  console.log(`${label}  computed text-wrap=${r.textWrap}  inline="${r.inline}"`);
  await page.close();
}
await b.close();
