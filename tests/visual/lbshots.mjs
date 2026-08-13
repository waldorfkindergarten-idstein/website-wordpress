import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/bfc0a772-e372-4cf1-b05b-cc958384b014/scratchpad';
const b = await chromium.launch();
for (const n of [1, 2, 3, 4, 5]) {
  const page = await b.newPage({ viewport: { width: 1180, height: 1200 }, deviceScaleFactor: 1 });
  await page.goto(`http://localhost:8080/leitbild-${n}/`, { waitUntil: 'networkidle' });
  await page.addStyleTag({ content: '.pb-reveal{opacity:1!important;transform:none!important}' });
  await page.waitForTimeout(500);
  const h = await page.evaluate(() => Math.min(document.querySelector('main').scrollHeight + 60, 2400));
  await page.setViewportSize({ width: 1180, height: h });
  await page.waitForTimeout(300);
  await page.screenshot({ path: `${SP}/leitbild-${n}.png`, clip: { x: 0, y: 0, width: 1180, height: h } });
  console.log(`leitbild-${n}: ${h}px tall`);
  await page.close();
}
await b.close();
