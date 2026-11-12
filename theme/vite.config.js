import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';
import * as sass from 'sass';
import { defineConfig } from 'vite';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const scssEntry = path.resolve(__dirname, 'assets/scss/styles.scss');
const cssOutDir = path.resolve(__dirname, 'assets/css');
const viteTmpDir = path.resolve(__dirname, 'assets/.vite-tmp');

function collectScssFiles(dir, files = []) {
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const full = path.join(dir, entry.name);
    if (entry.isDirectory()) {
      collectScssFiles(full, files);
    } else if (entry.name.endsWith('.scss')) {
      files.push(full);
    }
  }
  return files;
}

function expandGlobUses(source, baseDir) {
  return source.replace(/@use\s+["']([^"']+)["']\s*;/g, (full, spec) => {
    if (!spec.includes('*')) {
      return full;
    }

    const star = spec.indexOf('*');
    const dirPart = spec.slice(0, star).replace(/\/$/, '');
    const absDir = path.resolve(baseDir, dirPart);
    const files = [];

    const walk = (dir, rel) => {
      for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const relPath = rel ? `${rel}/${entry.name}` : entry.name;
        if (entry.isDirectory()) {
          walk(path.join(dir, entry.name), relPath);
        } else if (entry.name.endsWith('.scss')) {
          files.push(relPath);
        }
      }
    };

    walk(absDir, '');
    files.sort((a, b) => a.localeCompare(b));

    const prefix = dirPart ? `${dirPart}/` : '';
    return files
      .map((rel) => {
        const modulePath = rel.replace(/\.scss$/, '').replace(/(^|\/)_/g, '$1');
        return `@use "${prefix}${modulePath}";`;
      })
      .join('\n');
  });
}

function writeStyles(isDev) {
  const expanded = expandGlobUses(
    fs.readFileSync(scssEntry, 'utf8'),
    path.dirname(scssEntry)
  );
  const result = sass.compileString(expanded, {
    url: pathToFileURL(scssEntry),
    loadPaths: [path.dirname(scssEntry)],
    style: isDev ? 'expanded' : 'compressed',
    sourceMap: isDev,
    sourceMapIncludeSources: isDev,
    silenceDeprecations: [
      'import',
      'global-builtin',
      'color-functions',
      'slash-div',
      'if-function',
      'legacy-js-api',
    ],
  });

  fs.mkdirSync(cssOutDir, { recursive: true });

  let css = result.css;
  const mapPath = path.join(cssOutDir, 'styles.css.map');

  if (isDev && result.sourceMap) {
    css += '\n/*# sourceMappingURL=styles.css.map */\n';
    const map = {
      ...result.sourceMap,
      file: 'styles.css',
      sources: (result.sourceMap.sources || []).map((source) => {
        const abs = source.startsWith('file://')
          ? fileURLToPath(source)
          : path.resolve(source);
        return path.relative(cssOutDir, abs).split(path.sep).join('/');
      }),
    };
    fs.writeFileSync(mapPath, `${JSON.stringify(map)}\n`, 'utf8');
  } else if (fs.existsSync(mapPath)) {
    fs.unlinkSync(mapPath);
  }

  fs.writeFileSync(path.join(cssOutDir, 'styles.css'), css, 'utf8');
  console.log(
    isDev
      ? '[styles] assets/css/styles.css (+ sourcemap)'
      : '[styles] assets/css/styles.css'
  );
}

function compileStylesPlugin(isDev) {
  return {
    name: 'theme-compile-styles',
    buildStart() {
      for (const file of collectScssFiles(path.resolve(__dirname, 'assets/scss'))) {
        this.addWatchFile(file);
      }
      writeStyles(isDev);
    },
    closeBundle() {
      fs.rmSync(viteTmpDir, { recursive: true, force: true });
    },
  };
}

export default defineConfig(({ mode }) => {
  const isDev = mode === 'development';

  return {
    root: __dirname,
    publicDir: false,
    plugins: [compileStylesPlugin(isDev)],
    build: {
      outDir: viteTmpDir,
      emptyOutDir: true,
      sourcemap: false,
      rollupOptions: {
        input: path.resolve(__dirname, 'assets/scss/styles-entry.js'),
        output: {
          entryFileNames: '_empty.js',
        },
      },
    },
  };
});
