import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  await page.getByRole('link', { name: 'dbs15579897' }).first().click();
  await page.waitForLoadState('networkidle', { timeout: 30000 }).catch(()=>{});
  await page.waitForTimeout(2000);
  console.log('url:', page.url().slice(0,150));
  const txt = (await page.locator('body').innerText()).replace(/\n{2,}/g,'\n').slice(0,1500);
  console.log('--- text ---'); console.log(txt);
  const links = await page.locator('a, button').evaluateAll(els =>
    els.map(e => (e.innerText||'').trim()).filter(t => t && t.length < 45));
  console.log('--- controls ---', JSON.stringify([...new Set(links)].slice(0,30)));
  await page.screenshot({ path: `${SP}/strato-db2.png` });
});
