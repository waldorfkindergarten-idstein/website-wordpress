import { chromium } from 'playwright';
const ids = process.argv.slice(2);
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 1500, height: 1000 } });
await page.goto('http://localhost:8080/wp-login.php', { waitUntil: 'domcontentloaded' });
await page.fill('#user_login', 'claudedbg');
await page.fill('#user_pass', 'Dbg!2026#tmp');
await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('#wp-submit')]);
for (const id of ids) {
  const errs = [];
  const onErr = m => { if (m.type() === 'error' && m.text().includes('Block validation')) errs.push(1); };
  page.on('console', onErr);
  await page.goto(`http://localhost:8080/wp-admin/post.php?post=${id}&action=edit`, { waitUntil: 'domcontentloaded' });
  await page.waitForSelector('iframe[name="editor-canvas"], .block-editor-block-list__layout', { timeout: 90000 });
  await page.waitForTimeout(6000);
  const frame = page.frames().find(f => f.name() === 'editor-canvas') || page.mainFrame();
  const w = await frame.evaluate(() => document.querySelectorAll('.block-editor-warning').length);
  console.log(`  post ${id}: warnings=${w} validationErrors=${errs.length}`);
  page.off('console', onErr);
}
await b.close();
