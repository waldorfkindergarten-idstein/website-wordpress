import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  await page.waitForTimeout(1500);
  console.log('url:', page.url().slice(0,120));
  const txt = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n').slice(0,900);
  console.log('--- text ---'); console.log(txt);
  await page.screenshot({ path: `${SP}/pma-1.png`, fullPage: false });
});
