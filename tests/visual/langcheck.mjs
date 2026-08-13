import { chromium } from 'playwright';
const b = await chromium.launch();
const base = 'http://neu.waldorfkindergarten-idstein.de';
const page = await b.newPage({ viewport: { width: 390, height: 844 } });
await page.goto(base + '/', { waitUntil: 'networkidle' });
const nav = await page.evaluate(() => {
  const btns = [...document.querySelectorAll('.wp-block-navigation button, .wp-block-navigation__responsive-container-open, .wp-block-navigation__responsive-container-close')];
  return btns.map(b => (b.textContent || b.getAttribute('aria-label') || '').trim()).filter(Boolean);
});
const skip = await page.evaluate(() => (document.querySelector('.skip-link, a[href="#wp--skip-link--target"]')?.textContent || '').trim());
console.log('nav toggle labels:', JSON.stringify(nav));
console.log('skip link       :', JSON.stringify(skip));

// open the overlay and read the close label
await page.click('.wp-block-navigation__responsive-container-open').catch(()=>{});
await page.waitForTimeout(600);
const open = await page.evaluate(() => {
  const c = document.querySelector('.wp-block-navigation__responsive-container.is-menu-open');
  const close = document.querySelector('.wp-block-navigation__responsive-container-close');
  return { isOpen: !!c, closeLabel: (close?.textContent || '').trim() };
});
console.log('overlay         :', JSON.stringify(open));

// hyphenation now that lang is German
await page.goto(base + '/datenschutz/', { waitUntil: 'networkidle' });
const hy = await page.evaluate(() => {
  const de = document.documentElement;
  const h = document.querySelector('main h1');
  return { lang: de.lang, hyphens: getComputedStyle(h).hyphens, overflow: de.scrollWidth - de.clientWidth };
});
console.log('datenschutz     :', JSON.stringify(hy));
await b.close();
