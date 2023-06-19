import fs from "fs";
import path from "path";
import util from "util";
import * as url from "url";
import { execFile } from "node:child_process";
import { globbySync } from "globby";
import sharp from "sharp";

const execFilePromise = util.promisify(execFile);
const __dirname = url.fileURLToPath(new URL(".", import.meta.url));

class ImgMin {
  constructor(data = {}) {
    this.data = deepMerge(
      {
        option: {
          base: undefined,
          cacheDir: path.resolve(process.cwd(), "./node_modules/.cache/images"),
          isWebp: true,
          isAvif: false,
          isModernFormatOnly: false,
          webpExt: [".jpeg", ".jpg", ".png", ".gif"],
          avifExt: [".jpeg", ".jpg", ".png", ".gif"],
          png: { quality: 80 },
          jpg: { quality: 80 },
          webp: { quality: 80, smartSubsample: true },
          avif: { quality: 80 },
          svg: ["--config", path.resolve(__dirname, "svgo.config.cjs")],
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
    const isWebp = this.data.option?.isWebp || this.default?.option?.isWebp;
    const isAvif = this.data.option?.isAvif || this.default?.option?.isAvif;

    if (![".png", ".jpeg", ".jpg", ".svg", ".gif"].includes(extname)) {
      return this._copyFiles(from, copyTo);
    }
    return await fs.promises
      .mkdir(path.dirname(cacheTo), { recursive: true })
      .then(() => {
        if ([".svg"].includes(extname)) {
          if (this._isCacheExits(from, cacheTo)) {
            this._copyFiles(cacheTo, copyTo);
            return;
          }
          console.log("COMPRESS:", copyTo);
          this._optimizeSvg(from, cacheTo).then(() =>
            this._copyFiles(cacheTo, copyTo)
          );
          return;
        }
        if (!this.data.option.isModernFormatOnly) {
          if (this._isCacheExits(from, cacheTo)) {
            this._copyFiles(cacheTo, copyTo);
          } else {
            console.log("COMPRESS:", copyTo);
            if ([".jpeg", ".jpg"].includes(extname)) {
              this._optimizeJpg(from, cacheTo).then(() =>
                this._copyFiles(cacheTo, copyTo)
              );
            }
            if ([".png"].includes(extname)) {
              this._optimizePng(from, cacheTo).then(() =>
                this._copyFiles(cacheTo, copyTo)
              );
            }
          }
        }
        // webp
        if (isWebp && this.data.option?.webpExt?.includes(extname)) {
          const ext = ".webp";
          const webpExit = this._replaceExt(copyTo, ext);
          const webpCache = this._replaceExt(cacheTo, ext);
          if (this._isCacheExits(from, webpCache)) {
            this._copyFiles(webpCache, webpExit);
          } else {
            console.log("WEBP:", webpExit);
            this._optimizeWebp(from, cacheTo).then(() =>
              this._copyFiles(webpCache, webpExit)
            );
          }
        }
        // avif
        if (isAvif && this.data.option?.avifExt?.includes(extname)) {
          const ext = ".avif";
          const avifExit = this._replaceExt(copyTo, ext);
          const avifCache = this._replaceExt(cacheTo, ext);
          if (this._isCacheExits(from, avifCache)) {
            this._copyFiles(avifCache, avifExit);
          } else {
            console.log("AVIF:", avifExit);
            this._optimizeAvif(from, cacheTo).then(() =>
              this._copyFiles(avifCache, avifExit)
            );
          }
        }
      });

    // cache copy
    /*
    if (['.svg'].includes(extname) || !this.data.option.isModernFormatOnly) {
      this._copyFiles(cacheTo, copyTo);
    }
    // cache webp copy
    if (isWebp && this.data.option?.webpExt?.includes(extname)) {
      this._copyFiles(
        this._replaceExt(cacheTo),
        this._replaceExt(copyTo, '.webp')
      );
    }
    if (isAvif && this.data.option?.avifExt?.includes(extname)) {
      console.log(cacheTo);
      this._copyFiles(
        this._replaceExt(cacheTo),
        this._replaceExt(copyTo, '.avif')
      );
    }
    */
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
    const out = this._replaceExt(to, ".webp");
    const option = {
      ...this.data.option.webp,
      ...{ lossless: [".png"].includes(extname) },
      ...(this.data?.custom[from]?.webp || {}),
    };
    return await sharp(from).webp(option).toFile(out);
  }

  async _optimizeAvif(from, to) {
    const extname = path.extname(from);
    const out = this._replaceExt(to, ".avif");
    const option = {
      ...this.data.option.avif,
      ...{ lossless: [".png"].includes(extname) },
      ...(this.data?.custom[from]?.avif || {}),
    };
    return await sharp(from).avif(option).toFile(out);
  }

  async _optimizeSvg(from, to) {
    const base = ["-i", from, "-o", to];
    const command = this.data.option.svg?.length
      ? this.data.option.svg.concat(base)
      : base;
    return await execFilePromise("svgo", command);
  }

  _createDestinationFilePath(from) {
    let to = "";
    if (path.extname(from) || path.basename(from).startsWith(".")) {
      if (!this.data.dest.endsWith("/") && path.extname(this.data.dest)) {
        to = this.data.dest;
      } else {
        if (this.data.option.base) {
          let popped = from.split(this.data.option.base).pop();
          popped = popped.startsWith("/") ? popped.slice(1) : popped;
          to = path.join(this.data.dest, popped);
        } else {
          to = path.join(this.data.dest, path.basename(from));
        }
      }
    } else {
      to = this.data.dest.endsWith("/")
        ? this.data.dest.slice(0, -1)
        : this.data.dest;
    }
    return to;
  }

  _replaceExt(filePath = "", ext = ".webp") {
    return filePath.replace(/\.[^.]+$/, ext);
  }

  _getPath(path) {
    // eslint-disable-next-line no-useless-escape
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
    obj && typeof obj === "object" && !Array.isArray(obj);
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
      } else if (
        isObject(sourceValue) &&
        Object.prototype.hasOwnProperty.call(target, sourceKey)
      ) {
        result[sourceKey] = deepMerge(targetValue, sourceValue, opts);
      } else {
        Object.assign(result, { [sourceKey]: sourceValue });
      }
    }
  }
  return result;
}
