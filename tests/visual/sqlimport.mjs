import { chromium } from 'playwright';
import { readFileSync } from 'node:fs';

const FILE = process.argv[2];
const DB = 'dbs15579897';
const buf = readFileSync(FILE);

const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
const page = b.contexts()[0].pages().find(p => p.url().includes('phpmyadmin.strato.de'));
if (!page) throw new Error('no phpMyAdmin tab open');

await page.goto(`https://phpmyadmin.strato.de/db_import.php?db=${DB}`, { waitUntil: 'domcontentloaded' });
await page.waitForTimeout(2000);

await page.setInputFiles('input[type=file][name=import_file]', {
  name: 'fixes.sql', mimeType: 'application/sql', buffer: buf,
});
await page.waitForTimeout(500);

await Promise.all([
  page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 120000 }).catch(() => {}),
  page.click('#buttonGo'),
]);
await page.waitForTimeout(4000);

const out = await page.evaluate(() => {
  const txt = (s) => { const e = document.querySelector(s); return e ? e.innerText.trim().slice(0, 700) : null; };
  const tables = [...document.querySelectorAll('table.table_results')].map(t =>
    [...t.querySelectorAll('tr')].map(tr =>
      [...tr.querySelectorAll('th,td')].map(c => c.innerText.trim()).join(' | ')).join('\n'));
  return { ok: txt('.success') || txt('.alert-success'),
           err: txt('.error') || txt('.alert-danger'),
           tables };
});
console.log('SUCCESS:', out.ok);
if (out.err) console.log('ERROR:', out.err);
out.tables.forEach(t => console.log('\n' + t));
await b.close();
