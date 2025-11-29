const puppeteer = require('puppeteer');
const fs = require('fs');

// Usage: node pdf.js [url] [output]
// Example: node pdf.js http://localhost:8000/pdf/test-ar ./test-ar.pdf

async function run() {
  const url = process.argv[2] || 'http://localhost:8000/pdf/test-ar';
  const out = process.argv[3] || './test-ar.pdf';

  console.log('Rendering:', url);
  const browser = await puppeteer.launch({ args: ['--no-sandbox', '--disable-setuid-sandbox'] });
  try {
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: 'networkidle0' });

    // Ensure fonts loaded
    await page.evaluateHandle('document.fonts.ready');

    await page.pdf({ path: out, format: 'A4', printBackground: true });
    console.log('Saved PDF to', out);
  } catch (err) {
    console.error('Error rendering PDF:', err);
  } finally {
    await browser.close();
  }
}

run();
