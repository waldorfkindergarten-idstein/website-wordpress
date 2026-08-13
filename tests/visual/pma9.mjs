import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  const t = await page.locator('body').innerText();
  const m = t.match(/Import[^\n]*finish[^\n]*|[^\n]*Error[^\n]*|[^\n]*queries executed[^\n]*/gi);
  console.log('status lines:', m ? m.slice(0,4).map(s=>s.trim().slice(0,120)) : '(none found)');
  await page.goto('https://phpmyadmin.strato.de/db_structure.php?db=dbs15579897', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(4000);
  const rows = await page.locator('#tablesForm tbody tr').evaluateAll(trs => trs.map(tr => {
    const c = [...tr.querySelectorAll('th,td')].map(x => x.innerText.trim());
    return c[1] && c.length > 5 ? `${c[1]}: ${c.find((v,i)=> i>5 && /^\d[\d,.]*$/.test(v)) ?? '?'}` : null;
  }).filter(Boolean));
  console.log('--- table row counts after import ---');
  rows.forEach(r => console.log('  ', r));
  await page.screenshot({ path: `${SP}/pma-after.png` });
});
