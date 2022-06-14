import fs from 'fs';
import path from 'path';
import util from 'util';
import * as url from 'url';
import { execFile } from 'node:child_process';
import { globbySync } from 'globby';
import sharp from 'sharp';

const execFilePromise = util.promisify(execFile);
const __dirname = url.fileURLToPath(new URL('.', import.meta.url));

class ImgMin {
  constructor(data = {}) {
    this.data = deepMerge(
      {
        option: {
          base: undefined,
          cacheDir: path.resolve(process.cwd(), './node_modules/.cache/images'),
          isWebp: true,
          webpExt: ['.jpeg', '.jpg', '.png', '.gif'],
          png: { quality: 80 },
          jpg: { quality: 80 },
          webp: { quality: 80, smartSubsample: true },
          svg: ['--config', path.resolve(__dirname, 'svgo.config.js')],
        },
        custom: {},
      },
      data
    );
  }

  async run() {
    const files = globbySync(this.data.src);
    return await Promise.all([files.map((file) => this._optimize(file))]);
  }

  async _optimize(file) {
    const extname = path.extname(file);
    const from = file;
    const cacheTo = path.join(this.data.option.cacheDir, from);
    const copyTo = this._createDestinationFilePath(file);
    const isWebp = this.data.option?.isWebp || this.default.option?.isWebp;

    if (!['.png', '.jpeg', '.jpg', '.svg', '.gif'].includes(extname)) {
      return this._copyFiles(from, copyTo);
    }

    if (!this._isCacheExits(from, cacheTo)) {
      return await fs.promises
        .mkdir(path.dirname(cacheTo), { recursive: true })
        .then(() => {
          console.log('COMPRESS:', copyTo);
          if (['.svg'].includes(extname)) {
            this._optimizeSvg(from, cacheTo).then(() =>
              this._copyFiles(cacheTo, copyTo)
            );
          }
          if (['.jpeg', '.jpg'].includes(extname)) {
            this._optimizeJpg(from, cacheTo).then(() =>
              this._copyFiles(cacheTo, copyTo)
            );
          }
          if (['.png'].includes(extname)) {
            this._optimizePng(from, cacheTo).then(() =>
              this._copyFiles(cacheTo, copyTo)
            );
          }
          // webp
          if (isWebp && this.data.option?.webpExt?.includes(extname)) {
            console.log('WEBP:', this._replaceExt(copyTo));
            this._optimizeWebp(from, cacheTo).then(() =>
              this._copyFiles(
                this._replaceExt(cacheTo),
                this._replaceExt(copyTo)
              )
            );
          }
        });
    }

    // cache copy
    // console.log('COPY:', copyTo);
    this._copyFiles(cacheTo, copyTo);

    // cache webp copy
    if (isWebp && this.data.option?.webpExt?.includes(extname)) {
      // console.log('COPY:', this._replaceExt(copyTo));
      this._copyFiles(this._replaceExt(cacheTo), this._replaceExt(copyTo));
    }
  }

  _copyFiles(from, to) {
    fs.cpSync(from, to, { recursive: true });
  }

  _isCacheExits(file, cache) {
    try {
      const fileStat = fs.statSync(file);
      const cacheStat = fs.statSync(cache);
      return fileStat && cacheStat ? fileStat.mtime <= cacheStat.mtime : false;
    } catch (error) {
      // console.log(error);
      return false;
    }
  }

  async _optimizeJpg(from, to) {
    const option = {
      ...this.data.option.jpg,
      ...(this.data?.custom[from]?.jpg || {}),
    };
    return await sharp(from).jpeg(option).toFile(to);
  }

  async _optimizePng(from, to) {
    const option = {
      ...this.data.option.png,
      ...(this.data?.custom[from]?.png || {}),
    };
    return await sharp(from).png(option).toFile(to);
  }

  async _optimizeWebp(from, to) {
    const extname = path.extname(from);
    const out = this._replaceExt(to, '.webp');
    const option = {
      ...this.data.option.webp,
      ...{ lossless: ['.png'].includes(extname) },
      ...(this.data?.custom[from]?.webp || {}),
    };
    return await sharp(from).webp(option).toFile(out);
  }

  async _optimizeSvg(from, to) {
    const base = ['-i', from, '-o', to];
    const command = this.data.option.svg?.length
      ? this.data.option.svg.concat(base)
      : base;
    return await execFilePromise('svgo', command);
  }

  _createDestinationFilePath(from) {
    let to = '';
    if (path.extname(from) || path.basename(from).startsWith('.')) {
      if (!this.data.dest.endsWith('/') && path.extname(this.data.dest)) {
        to = this.data.dest;
      } else {
        if (this.data.option.base) {
          let popped = from.split(this.data.option.base).pop();
          popped = popped.startsWith('/') ? popped.slice(1) : popped;
          to = path.join(this.data.dest, popped);
        } else {
          to = path.join(this.data.dest, path.basename(from));
        }
      }
    } else {
      to = this.data.dest.endsWith('/')
        ? this.data.dest.slice(0, -1)
        : this.data.dest;
    }
    return to;
  }

  _replaceExt(filePath = '', ext = '.webp') {
    return filePath.replace(/\.[^.]+$/, ext);
  }

  _getPath(path) {
    path = path.match(/(^.*[\\\/]|^[^\\\/].*)/i);
    return path != null ? path[0] : false;
  }
}
export default ImgMin;

/**
 * easy deep merge
 */
function deepMerge(target, source, opts) {
  const isObject = (obj) =>
    obj && typeof obj === 'object' && !Array.isArray(obj);
  const isConcatArray = opts && opts.concatArray;
  let result = Object.assign({}, target);
  if (isObject(target) && isObject(source)) {
    for (const [sourceKey, sourceValue] of Object.entries(source)) {
      const targetValue = target[sourceKey];
      if (
        isConcatArray &&
        Array.isArray(sourceValue) &&
        Array.isArray(targetValue)
      ) {
        result[sourceKey] = targetValue.concat(...sourceValue);
      } else if (isObject(sourceValue) && target.hasOwnProperty(sourceKey)) {
        result[sourceKey] = deepMerge(targetValue, sourceValue, opts);
      } else {
        Object.assign(result, { [sourceKey]: sourceValue });
      }
    }
  }
  return result;
}
