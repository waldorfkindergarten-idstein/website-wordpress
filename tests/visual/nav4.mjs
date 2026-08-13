import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();

// enter the hosting package
await page.locator('a', { hasText: /^STRATO Hosting Plus$/ }).first().click();
await page.waitForLoadState('domcontentloaded');
await page.waitForTimeout(2500);
console.log('now at:', page.url());

const db = await page.evaluate(() =>
  [...document.querySelectorAll('a,button')]
    .map(a => ({ t: (a.innerText||'').trim().replace(/\s+/g,' '), h: a.getAttribute('href')||'' }))
    .filter(x => /[Dd]atenbank|MySQL|phpMyAdmin|Webspace/.test(x.t + x.h)));
console.log(JSON.stringify(db, null, 1));
await b.close();
