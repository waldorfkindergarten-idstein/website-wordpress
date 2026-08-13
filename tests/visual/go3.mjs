import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  await page.getByRole('link', { name: /Backups anzeigen/ }).first().click();
  await page.waitForLoadState('networkidle', { timeout: 30000 }).catch(()=>{});
  await page.waitForTimeout(2000);
  const txt = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n');
  const i = txt.indexOf('Backup');
  console.log(txt.slice(Math.max(0,i-100), i+900));
  await page.screenshot({ path: `${SP}/strato-backups.png` });
});
