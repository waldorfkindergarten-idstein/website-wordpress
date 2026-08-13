import { chromium } from 'playwright';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const ctx = b.contexts()[0];
for (const p of ctx.pages()) {
  let title = '(?)'; try { title = await p.title(); } catch {}
  console.log('-', title.slice(0,55), '|', p.url().slice(0,95));
}
const pma = ctx.pages().find(p => p.url().includes('phpmyadmin'));
if (pma) {
  try {
    await pma.goto('https://phpmyadmin.strato.de/db_structure.php?db=dbs15579897', { waitUntil: 'domcontentloaded', timeout: 30000 });
    await pma.waitForTimeout(3000);
    const t = await pma.locator('body').innerText();
    console.log('phpMyAdmin still authenticated:', t.includes('wp_posts') ? 'YES' : 'NO');
  } catch (e) { console.log('phpMyAdmin check failed:', e.message.slice(0,70)); }
}
await b.close();
