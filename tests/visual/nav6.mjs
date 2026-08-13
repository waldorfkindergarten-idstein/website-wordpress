import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();

const links = page.locator('a[href*="node=kds_Vertragsbetreuung_2"]');
const n = await links.count();
let clicked = false;
for (let i = 0; i < n; i++) {
  const l = links.nth(i);
  if (await l.isVisible()) { console.log('clicking visible link', i, JSON.stringify((await l.innerText()).trim())); await l.click(); clicked = true; break; }
}
if (!clicked) throw new Error('no visible package link among ' + n);
await page.waitForLoadState('domcontentloaded');
await page.waitForTimeout(3000);
console.log('now at:', page.url());
const hits = await page.evaluate(() =>
  [...document.querySelectorAll('a,button')]
    .map(a => ({ t: (a.innerText||'').trim().replace(/\s+/g,' '), h: a.getAttribute('href')||'' }))
    .filter(x => /[Dd]atenbank|MySQL|phpMyAdmin/i.test(x.t + ' ' + x.h)));
console.log(JSON.stringify(hits, null, 1));
await b.close();
