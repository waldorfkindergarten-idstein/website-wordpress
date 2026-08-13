import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/86a468c7-9df7-419b-b5f1-d2519ea6dfbc/scratchpad';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = ctx.pages().find(p => p.url().includes('strato.de/apps'));
const ok = await page.evaluate(() => {
  const a = [...document.querySelectorAll('a')].find(x => (x.innerText||'').trim() === 'Domainverwaltung');
  if (!a) return false; a.click(); return true;
});
console.log('clicked:', ok);
await page.waitForTimeout(9000);
const t = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
console.log(t.slice(0, 1400));
await page.screenshot({ path: `${SP}/domains.png` });
await b.close();
