import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();
const info = await page.evaluate(() => ({
  text: document.body.innerText.replace(/\n{2,}/g,'\n').trim().slice(0, 1200),
  linkCount: document.querySelectorAll('a').length,
  sampleLinks: [...document.querySelectorAll('a')].slice(0, 30)
     .map(a => a.innerText.trim().replace(/\s+/g,' ')).filter(Boolean),
}));
console.log('link count:', info.linkCount);
console.log('links:', JSON.stringify(info.sampleLinks));
console.log('---- page text ----');
console.log(info.text);
await b.close();
