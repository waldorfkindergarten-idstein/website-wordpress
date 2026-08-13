import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = ctx.pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
if (!page) throw new Error('STRATO panel tab not found');
await page.bringToFront();
console.log('URL:', page.url());
const links = await page.evaluate(() =>
  [...document.querySelectorAll('a')]
    .map(a => ({ t: a.innerText.trim().replace(/\s+/g,' '), h: a.getAttribute('href') || '' }))
    .filter(x => x.t && /[Dd]atenbank|[Ww]ebspace|Verwaltung/.test(x.t))
    .slice(0, 25));
console.log(JSON.stringify(links, null, 1));
await b.close();
