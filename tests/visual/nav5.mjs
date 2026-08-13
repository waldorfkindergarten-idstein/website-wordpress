import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();

await page.locator('a[href*="node=kds_Vertragsbetreuung_2"]').first().click();
await page.waitForLoadState('domcontentloaded');
await page.waitForTimeout(3000);
console.log('now at:', page.url());
console.log('title:', await page.title());

const hits = await page.evaluate(() =>
  [...document.querySelectorAll('a,button')]
    .map(a => ({ t: (a.innerText||'').trim().replace(/\s+/g,' '), h: a.getAttribute('href')||'' }))
    .filter(x => /[Dd]atenbank|MySQL|phpMyAdmin|Webspace/i.test(x.t + ' ' + x.h)));
console.log(JSON.stringify(hits, null, 1));
await b.close();
