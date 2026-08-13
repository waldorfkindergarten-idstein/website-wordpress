import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('phpmyadmin.strato.de'));
console.log('URL:', page.url());
const t = await page.evaluate(() => document.body.innerText.slice(0, 2500));
console.log(t);
await b.close();
