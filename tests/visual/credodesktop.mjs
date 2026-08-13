import { chromium } from 'playwright';
const b = await chromium.launch();
for (const [w, url] of [[1280,'http://localhost:8080'], [1280,'http://neu.waldorfkindergarten-idstein.de'], [393,'http://localhost:8080']]) {
  const page = await b.newPage({ viewport: { width: w, height: 900 } });
  await page.goto(url + '/', { waitUntil: 'networkidle' });
  const r = await page.evaluate(() => {
    const c = getComputedStyle(document.querySelector('.pb-credo'));
    return { radius: c.borderTopLeftRadius, left: c.borderLeftWidth, top: c.borderTopWidth, pad: c.padding };
  });
  console.log(`${String(w).padStart(4)}px ${url.includes('localhost') ? 'local  ' : 'staging'}  radius=${r.radius} borderLeft=${r.left} borderTop=${r.top} pad=${r.pad}`);
  await page.close();
}
await b.close();
