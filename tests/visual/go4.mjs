import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  await page.waitForTimeout(8000);
  const txt = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
  console.log(txt.slice(0, 900));
  await page.screenshot({ path: `${SP}/strato-backups2.png` });
});
