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
    const defaultData = {
      option: {
        base: undefined,
        cacheDir: path.resolve(process.cwd(), "./node_modules/.cache/images"),
        isOriginOutput: true,
        formats: ["webp"],
        png: { quality: 80 },
        jpg: { quality: 80 },
        webp: { quality: 80, smartSubsample: true },
        avif: { quality: 80 },
        svg: ["--config", path.resolve(__dirname, "svgo.config.cjs")],
      },
      custom: {},
    };
    this.data = deepMerge(defaultData, data);
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
    const formats = this.data.option.formats;
    const isOrigin = this.data.option.isOriginOutput;

    if (![".png", ".jpeg", ".jpg", ".svg", ".gif"].includes(extname)) {
      return this._copyFiles(from, copyTo);
    }

    return await fs.promises
      .mkdir(path.dirname(cacheTo), { recursive: true })
      .then(() => {
        if ([".svg"].includes(extname)) {
          this._optimizeCopy(extname, from, cacheTo, copyTo);
          return;
        }
        if ([".jpeg", ".jpg", ".png"].includes(extname)) {
          if (isOrigin) {
            this._optimizeCopy(extname, from, cacheTo, copyTo);
          }
          formats.forEach(async (e) => {
            const ext = `.${e}`;
            await this._optimizeCopy(
              ext,
              from,
              this._replaceExt(cacheTo, ext),
              this._replaceExt(copyTo, ext)
            );
          });
          return;
        }
        this._copyFiles(from, copyTo);
      });
  }

  async _optimizeCopy(ext, from, cacheTo, copyTo) {
    if (this._isCacheExits(from, cacheTo)) {
      return this._copyFiles(cacheTo, copyTo);
    }
    console.log(`COMPRESS:`, copyTo);
    return await this._optimizeSharp(ext, from, cacheTo).then(() =>
      this._copyFiles(cacheTo, copyTo)
    );
  }

  async _optimizeSharp(ext, from, to) {
    const option = {
      ...this.data.option[ext],
      ...(this.data?.custom[from]?.[ext] || {}),
    };
    if (ext === ".svg") {
      const base = ["-i", from, "-o", to];
      const command = this.data.option.svg?.length
        ? this.data.option.svg.concat(base)
        : base;
      return await execFilePromise("svgo", command);
    }
    if ([".jpg", ".jpeg"].includes(ext)) {
      return await sharp(from).jpeg(option).toFile(to);
    }
    if (ext === ".png") {
      return await sharp(from).png(option).toFile(to);
    }
    if (ext === ".webp") {
      const out = this._replaceExt(to, ".webp");
      return await sharp(from).webp(option).toFile(out);
    }
    if (ext === ".avif") {
      const out = this._replaceExt(to, ".avif");
      return await sharp(from).avif(option).toFile(out);
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
      // console.error(error);
      return false;
    }
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
