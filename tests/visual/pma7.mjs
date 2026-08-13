import { withPma } from './pma.mjs';
import { readFileSync } from 'fs';
await withPma(async (page, ctx, SP) => {
  const buf = readFileSync('/home/helge/dev/projects/waldorfkindergarten-wordpress/waldorf-staging.sql');
  console.log('attaching', buf.length, 'bytes');
  await page.locator('input[type=file]').first().setInputFiles({
    name: 'waldorf-staging.sql', mimeType: 'application/sql', buffer: buf,
  });
  await page.waitForTimeout(1500);
  console.log('input now holds:', await page.locator('input[type=file]').first().evaluate(el =>
    el.files.length ? `${el.files[0].name} (${el.files[0].size} bytes)` : 'NO FILE'));
  for (const sel of ['select[name=charset_of_file]','select[name=format]']) {
    const n = await page.locator(sel).count();
    console.log(sel, '=', n ? await page.locator(sel).inputValue() : '(absent)');
  }
  await page.screenshot({ path: `${SP}/pma-attached.png` });
});
