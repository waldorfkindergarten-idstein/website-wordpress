import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  await page.goto('https://phpmyadmin.strato.de/index.php?route=/database/structure&db=dbs15579897', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(3500);
  const rows = await page.locator('table#tablesForm tbody tr').evaluateAll(trs =>
    trs.map(tr => {
      const c = [...tr.querySelectorAll('th,td')].map(td => td.innerText.trim());
      return c.slice(0, 6).join(' | ');
    }).filter(Boolean));
  console.log('existing tables:', rows.length);
  rows.slice(0, 25).forEach(r => console.log('  ', r.slice(0, 90)));
  await page.screenshot({ path: `${SP}/pma-tables.png` });
});
