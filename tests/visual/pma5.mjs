import { withPma } from './pma.mjs';
await withPma(async (page, ctx, SP) => {
  const tabs = await page.locator('#topmenu a, .nav a').evaluateAll(as =>
    as.map(a => ({ text: (a.innerText||'').trim(), href: (a.getAttribute('href')||'').slice(0,120) }))
      .filter(x => x.text));
  console.log('top menu links:');
  tabs.slice(0,15).forEach(t => console.log(`  "${t.text}" -> ${t.href}`));
});
