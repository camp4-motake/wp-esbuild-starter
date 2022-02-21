import fs from 'fs';
import path from 'path';
import util from 'util';
import { execFile } from 'node:child_process';
import { globbySync } from 'globby';
import cwebp from 'cwebp-bin';
import mozjpeg from 'mozjpeg';
import pngquant from 'pngquant-bin';

const execFilePromise = util.promisify(execFile);
// const cwd = process.cwd();

class ImageCompress {
  constructor(data) {
    this.data = data;
    this.data.option = Object.assign(
      {
        base: undefined,
        cacheDir: './node_modules/.cache/images',
        isWebp: true,
      },
      this.data.option
    );
    this.data.command = Object.assign(
      {
        png: ['--ordered', '--quality=50-100'],
        jpg: ['-quality', '80'],
        lossy: ['-q', '75', '-metadata', 'icc', '-sharp_yuv'],
        lossless: ['-q', '75', '-lossless', '-exact', '-metadata', 'icc'],
        svg: [],
      },
      this.data.command
    );
    this.run(this.data.src);
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
          if (['.jpeg', '.jpg', '.png'].includes(extname)) {
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
    console.log('COPY:', copyTo);
    this._copyFiles(cacheTo, copyTo);

    // cache webp copy
    if (['.jpeg', '.jpg', '.png'].includes(extname)) {
      console.log('COPY:', this._replaceExt(copyTo));
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

  _optimizeJpg(from, to) {
    const base = ['-outfile', to, from];
    const command = this.data.command?.jpg?.length
      ? this.data.command.jpg.concat(base)
      : base;
    return execFilePromise(mozjpeg, command);
  }

  _optimizePng(from, to) {
    const base = ['--force', '-o', to, from];
    const command = this.data.command?.png?.length
      ? this.data.command.png.concat(base)
      : base;
    return execFilePromise(pngquant, command);
  }

  _optimizeSvg(from, to) {
    const base = ['--config', './lib/svgo.config.js', '-i', from, '-o', to];
    const command = this.data.command?.svg?.length
      ? this.data.command.svg.concat(base)
      : base;
    return execFilePromise('svgo', command);
  }

  _optimizeWebp(from, to) {
    const extname = path.extname(from);
    const mode = ['.png'].includes(extname) ? 'lossless' : 'lossy';
    const base = [from, '-o', this._replaceExt(to, '.webp')];
    const command = {
      lossy: this.data.command?.lossy?.length
        ? this.data.command.lossy.concat(base)
        : base,
      lossless: this.data.command?.lossless?.length
        ? this.data.command.lossless.concat(base)
        : base,
    };
    return execFilePromise(cwebp, command[mode]);
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

export default ImageCompress;
