import { chromium } from 'playwright';
const SP = '/tmp/claude-1000/-home-helge-dev-projects-waldorfkindergarten-wordpress/86a468c7-9df7-419b-b5f1-d2519ea6dfbc/scratchpad';
export async function withPma(fn) {
  const b = await chromium.connectOverCDP('http://127.0.0.1:9222');
  const ctx = b.contexts()[0];
  const page = ctx.pages().find(p => p.url().includes('phpmyadmin'));
  if (!page) throw new Error('phpMyAdmin tab not found');
  try { return await fn(page, ctx, SP); } finally { await b.close(); }
}
