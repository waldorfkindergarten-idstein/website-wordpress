import { chromium } from 'playwright';
const b = await chromium.launch();
for (const [label, url] of [['local  (with CSS guard)', 'http://localhost:8080/datenschutz/'],
                            ['staging(no CSS guard)  ', 'http://neu.waldorfkindergarten-idstein.de/datenschutz/']]) {
  const page = await b.newPage({ viewport: { width: 390, height: 844 } });
  await page.goto(url, { waitUntil: 'networkidle' });
  const r = await page.evaluate(() => {
    const h = document.querySelector('main h1');
    h.textContent = 'Datenschutzerklärung';           // restore the long heading
    const de = document.documentElement;
    return { overflow: de.scrollWidth - de.clientWidth,
             headingRight: Math.round(h.getBoundingClientRect().right),
             wrap: getComputedStyle(h).overflowWrap };
  });
  console.log(`${label}  overflow=${String(r.overflow).padStart(3)}px  h1.right=${r.headingRight}  overflow-wrap=${r.wrap}`);
  await page.close();
}
await b.close();
