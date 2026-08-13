import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  await page.getByRole('link', { name: 'Import', exact: true }).first().click();
  await page.waitForTimeout(4000);
  console.log('url:', page.url().slice(0,140));
  console.log('file inputs:', await page.locator('input[type=file]').count());
  const t = await page.locator('body').innerText();
  const lim = t.match(/[^\n]*(maximum|Max\.|limit)[^\n]*/i);
  console.log('limit text:', lim ? lim[0].trim().slice(0,140) : '(none)');
  await page.screenshot({ path: `${SP}/pma-import2.png` });
});
