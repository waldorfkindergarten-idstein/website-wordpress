import { chromium } from 'playwright';
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 393, height: 852 }, deviceScaleFactor: 2 });
await page.goto((process.argv[2]) + '/', { waitUntil: 'networkidle' });
await page.addStyleTag({ content: '.pb-reveal{opacity:1!important;transform:none!important}' });
const el = await page.$('.pb-credo');
await el.scrollIntoViewIfNeeded();
await page.waitForTimeout(400);
// capture the credo plus the card above it, for context
const box = await page.evaluate(() => {
  const c = document.querySelector('.pb-credo').getBoundingClientRect();
  return { x: 0, y: Math.max(0, c.top - 170), width: 393, height: Math.min(520, c.height + 220) };
});
await page.screenshot({ path: process.argv[3], clip: box });
console.log('shot ->', process.argv[3]);
await b.close();
