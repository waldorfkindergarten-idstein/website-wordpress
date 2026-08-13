import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  await page.getByRole('link', { name: /^Datenbanken/ }).first().click();
  await page.waitForLoadState('networkidle', { timeout: 30000 }).catch(()=>{});
  await page.waitForTimeout(1500);
  console.log('url:', page.url().slice(0,140));
  console.log('title:', await page.title());
  const txt = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n').slice(0, 1200);
  console.log('--- page text ---'); console.log(txt);
  await page.screenshot({ path: `${SP}/strato-db.png` });
});
