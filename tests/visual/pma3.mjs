import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  await page.goto('https://phpmyadmin.strato.de/index.php?route=/database/import&db=dbs15579897', { waitUntil: 'domcontentloaded' });
  await page.waitForTimeout(3000);
  const txt = (await page.locator('body').innerText());
  const m = txt.match(/max[^\n]*\n?/i) || txt.match(/[^\n]*limit[^\n]*/i);
  console.log('max-size hint:', (m ? m[0] : '(not found)').trim().slice(0,120));
  console.log('file inputs:', await page.locator('input[type=file]').count());
  console.log('has import form:', await page.locator('form#import_form, form[name=import]').count());
  await page.screenshot({ path: `${SP}/pma-import.png` });
});
