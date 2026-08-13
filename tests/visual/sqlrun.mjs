import { chromium } from 'playwright';
const SQL = process.argv[2];
const DB = 'dbs15579897';
const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('phpmyadmin.strato.de'));
if (!page) throw new Error('no phpMyAdmin tab');

await page.goto(`https://phpmyadmin.strato.de/db_sql.php?db=${DB}`, { waitUntil: 'domcontentloaded' });
await page.waitForTimeout(2000);

const how = await page.evaluate((sql) => {
  const ta = document.querySelector('#sqlquery');
  if (!ta) return 'NO TEXTAREA';
  const cmEl = document.querySelector('.CodeMirror');
  const cm = ta.CodeMirror || (cmEl && cmEl.CodeMirror);
  if (cm) { cm.setValue(sql); cm.save(); }
  ta.value = sql;
  ta.dispatchEvent(new Event('input', { bubbles: true }));
  ta.dispatchEvent(new Event('change', { bubbles: true }));
  return `cm=${!!cm} taLen=${ta.value.length}`;
}, SQL);
console.log('prepared:', how);

await Promise.all([
  page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 60000 }).catch(() => {}),
  page.click('#button_submit_query'),
]);
await page.waitForTimeout(2500);

const out = await page.evaluate(() => {
  const grab = (sel) => { const e = document.querySelector(sel); return e ? e.innerText.trim().slice(0,600) : null; };
  const res = document.querySelector('table.table_results');
  const rows = res ? [...res.querySelectorAll('tbody tr')].map(tr =>
    [...tr.querySelectorAll('td')].map(td => td.innerText.trim()).filter(Boolean).join(' | ')) : [];
  return { error: grab('.error') || grab('.alert-danger'),
           notice: grab('.success') || grab('.alert-success'),
           rowCount: rows.length, rows: rows.slice(0, 25) };
});
console.log(JSON.stringify(out, null, 2));
await b.close();
