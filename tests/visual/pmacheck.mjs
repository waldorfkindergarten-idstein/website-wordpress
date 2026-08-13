import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = await ctx.newPage();
await page.goto('https://phpmyadmin.strato.de/db_import.php?db=dbs15579897', { waitUntil: 'domcontentloaded' });
await page.waitForTimeout(2500);
console.log('URL:', page.url());
console.log('title:', await page.title());
const state = await page.evaluate(() => ({
  hasFileInput: !!document.querySelector('input[type=file][name=import_file]'),
  hasGo: !!document.querySelector('#buttonGo'),
  loginForm: !!document.querySelector('input[name=pma_password], #input_password'),
  bodyStart: document.body.innerText.trim().slice(0, 300),
}));
console.log(JSON.stringify(state, null, 2));
await b.close();
