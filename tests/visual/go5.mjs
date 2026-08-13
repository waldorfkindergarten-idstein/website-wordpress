import { withPage } from './cdp.mjs';
await withPage(async (page, ctx, SP) => {
  await page.goBack(); await page.waitForTimeout(2500);
  const before = ctx.pages().length;
  await page.getByRole('link', { name: /phpMyAdmin starten/ }).first().click();
  await page.waitForTimeout(7000);
  const pages = ctx.pages();
  console.log('pages open:', pages.length, '(was', before + ')');
  for (const p of pages) console.log('  -', (await p.title()).slice(0,55), '|', p.url().slice(0,110));
});
