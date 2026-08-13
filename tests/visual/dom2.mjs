import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/86a468c7-9df7-419b-b5f1-d2519ea6dfbc/scratchpad';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
const page = ctx.pages().find(p => p.url().includes('strato.de/apps'));
const links = await page.locator('a').evaluateAll(as => as.map(a => (a.innerText||'').trim()).filter(t => t && t.length < 40));
console.log('links:', JSON.stringify([...new Set(links)].slice(0, 40)));
await page.screenshot({ path: `${SP}/pkg.png` });
await b.close();
