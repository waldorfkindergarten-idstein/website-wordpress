import { chromium } from 'playwright';
const b = await chromium.launch();
const page = await b.newPage({ viewport: { width: 393, height: 852 }, deviceScaleFactor: 3 });
await page.goto((process.argv[2] || 'http://localhost:8080') + '/', { waitUntil: 'networkidle' });
const r = await page.evaluate(() => {
  const c = document.querySelector('.pb-credo');
  if (!c) return { error: 'no .pb-credo' };
  const box = c.getBoundingClientRect();
  const parent = c.parentElement.getBoundingClientRect();
  const cs = getComputedStyle(c);
  // a sibling inside the same constrained container, for comparison
  const sib = c.parentElement.querySelector(':scope > *:not(.pb-credo)');
  return {
    credo: { left: Math.round(box.left), right: Math.round(box.right), width: Math.round(box.width) },
    parent: { left: Math.round(parent.left), right: Math.round(parent.right), width: Math.round(parent.width) },
    sibling: sib ? { tag: sib.tagName + '.' + (sib.className||'').split(' ')[0],
                     left: Math.round(sib.getBoundingClientRect().left),
                     right: Math.round(sib.getBoundingClientRect().right) } : null,
    padding: cs.padding, borderTop: cs.borderTopWidth, borderLeft: cs.borderLeftWidth,
    viewport: window.innerWidth,
  };
});
console.log(JSON.stringify(r, null, 2));
await page.screenshot({ path: '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/bfc0a772-e372-4cf1-b05b-cc958384b014/scratchpad/credo.png', clip: r.credo ? { x: 0, y: 0, width: 393, height: 400 } : undefined });
await b.close();
