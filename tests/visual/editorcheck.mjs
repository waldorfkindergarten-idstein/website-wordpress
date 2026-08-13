import { chromium } from 'playwright';
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 1500, height: 1000 } });
const errors = [];
page.on('console', m => { if (m.type() === 'error') errors.push(m.text().slice(0, 200)); });
page.on('pageerror', e => errors.push('PAGEERROR: ' + e.message.slice(0, 200)));

await page.goto('http://localhost:8080/wp-login.php', { waitUntil: 'domcontentloaded' });
await page.fill('#user_login', 'claudedbg');
await page.fill('#user_pass', 'Dbg!2026#tmp');
await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('#wp-submit')]);
console.log('logged in ->', page.url().includes('wp-admin') ? 'ok' : page.url());

await page.goto('http://localhost:8080/wp-admin/post.php?post=12&action=edit', { waitUntil: 'domcontentloaded' });
await page.waitForSelector('iframe[name="editor-canvas"], .block-editor-block-list__layout', { timeout: 90000 });
await page.waitForTimeout(9000);

const frame = page.frames().find(f => f.name() === 'editor-canvas') || page.mainFrame();
const report = await frame.evaluate(() => {
  const out = [];
  for (const w of document.querySelectorAll('.block-editor-warning')) {
    const host = w.closest('[data-type]');
    out.push({ block: host?.getAttribute('data-type') || '?',
               msg: (w.innerText || '').replace(/\s+/g, ' ').trim().slice(0, 180) });
  }
  const missing = [...document.querySelectorAll('[data-type="core/missing"]')]
      .map(e => (e.innerText||'').replace(/\s+/g,' ').slice(0,100));
  return { warnings: out, missing, totalBlocks: document.querySelectorAll('[data-type]').length };
});
console.log('blocks in canvas:', report.totalBlocks);
console.log('warnings:', JSON.stringify(report.warnings, null, 1));
console.log('missing :', JSON.stringify(report.missing, null, 1));
console.log('console errors:', JSON.stringify([...new Set(errors)].slice(0, 8), null, 1));
await b.close();
