import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/86a468c7-9df7-419b-b5f1-d2519ea6dfbc/scratchpad';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = ctx.pages().find(p => p.url().includes('strato.de/apps'));
console.log('current:', (await page.title()).slice(0,60));
await page.getByRole('link', { name: /^Domainverwaltung/ }).first().click().catch(async () => {
  await page.getByRole('link', { name: /Domains verwalten/ }).first().click();
});
await page.waitForTimeout(8000);
const t = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
console.log(t.slice(0, 1200));
await page.screenshot({ path: `${SP}/domains.png` }).catch(e=>console.log('shot failed'));
await b.close();
