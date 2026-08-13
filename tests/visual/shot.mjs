import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  console.log('url  :', page.url().slice(0, 130));
  console.log('title:', await page.title());
  await page.screenshot({ path: `${SP}/strato.png` });
  console.log('screenshot saved');
});
