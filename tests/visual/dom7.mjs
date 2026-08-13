import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/86a468c7-9df7-419b-b5f1-d2519ea6dfbc/scratchpad';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = ctx.pages().find(p => p.url().includes('strato.de/apps'));
await page.evaluate(() => {
  const a = [...document.querySelectorAll('a,button')].find(x => /Subdomains anzeigen/.test(x.innerText||''));
  if (a) a.click();
});
await page.waitForTimeout(6000);
const t = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
const i = t.indexOf('waldorfkindergarten-idstein.de');
console.log(t.slice(Math.max(0,i-80), i+700));
await page.screenshot({ path: `${SP}/subdomains.png` });
await b.close();
