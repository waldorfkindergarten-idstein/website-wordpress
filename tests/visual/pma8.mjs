import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  const btn = page.locator('input[type=submit][value="Go"], button[type=submit]').first();
  console.log('submit control:', await btn.count() ? 'found' : 'NOT FOUND');
  await btn.click();
  console.log('submitted, waiting…');
  await page.waitForLoadState('load', { timeout: 180000 }).catch(e => console.log('load wait:', e.message.slice(0,60)));
  await page.waitForTimeout(6000);
  const t = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
  console.log('--- result ---');
  console.log(t.slice(0, 700));
  await page.screenshot({ path: `${SP}/pma-result.png` });
});
