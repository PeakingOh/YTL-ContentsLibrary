#!/usr/bin/env node
/**
 * テーマアセットの内容ハッシュを asset-manifest.json に書き出す（CI 用）
 *
 * Usage: node generate-asset-manifest.js <theme-dir>
 */
const crypto = require('crypto');
const fs = require('fs');
const path = require('path');

const themeDir = path.resolve(process.argv[2] || 'theme');
const assets = ['assets/css/styles.css', 'assets/js/scripts.js'];
const outFile = path.join(themeDir, 'assets/manifest/asset-manifest.json');

const manifest = {};

for (const relativePath of assets) {
  const fullPath = path.join(themeDir, relativePath);
  if (!fs.existsSync(fullPath)) {
    console.warn(`Skip missing asset: ${relativePath}`);
    continue;
  }
  const content = fs.readFileSync(fullPath);
  manifest[relativePath] = {
    hash: crypto.createHash('sha256').update(content).digest('hex').slice(0, 12),
    size: content.length,
  };
}

fs.mkdirSync(path.dirname(outFile), { recursive: true });
fs.writeFileSync(outFile, `${JSON.stringify(manifest, null, 2)}\n`);

console.log(`Wrote ${path.relative(process.cwd(), outFile)}`);
console.log(JSON.stringify(manifest, null, 2));
