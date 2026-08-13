import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();

const row = page.locator('tr', { hasText: 'waldorfkindergarten-idstein.de' }).first();
console.log('row text:', (await row.innerText()).replace(/\s+/g,' ').slice(0,150));
const clickables = await row.evaluate(tr =>
  [...tr.querySelectorAll('a,button,input[type=submit]')].map(e => ({
    tag: e.tagName, txt: (e.innerText||e.value||'').trim().replace(/\s+/g,' '),
    href: e.getAttribute('href')||'', cls: e.className })));
console.log(JSON.stringify(clickables, null, 1));
await b.close();
