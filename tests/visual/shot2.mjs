import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('strato.de/apps/CustomerService'));
await page.bringToFront();
await page.setViewportSize({ width: 1400, height: 1000 }).catch(()=>{});
await page.screenshot({ path: '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/bfc0a772-e372-4cf1-b05b-cc958384b014/scratchpad/panel.png', fullPage: false });
console.log('url:', page.url());
await b.close();
