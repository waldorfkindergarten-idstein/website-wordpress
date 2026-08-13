import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  await page.goto('https://phpmyadmin.strato.de/db_import.php?db=dbs15579897', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(3500);
  console.log('url:', page.url().slice(0,120));
  console.log('file inputs:', await page.locator('input[type=file]').count());
  const t = await page.locator('body').innerText();
  const lim = t.match(/[^\n]*(maximum|Max\.|limit|MiB|MB)[^\n]*/i);
  console.log('limit:', lim ? lim[0].trim().slice(0,150) : '(none)');
  await page.screenshot({ path: `${SP}/pma-import3.png` });
});
