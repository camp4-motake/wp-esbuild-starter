import { globbySync } from 'globby';
import path from 'path';
import fs from 'fs-extra';
import chokidar from 'chokidar';

const Log = {
  colors: { default: '\x1b[0m', green: '\x1b[32m', red: '\x1b[31m' },
  feedback(message, color = 'green') {
    // console.log(Log.colors[color], message);
  },
};

export const copy = async (from, to, options = {}) => {
  const task = new CopyFilesTask({ from, to, options });
  await task.run();
  if (options.isWatch === true) {
    task.watch();
  }
};
/**
 * copy watch class
 */
class CopyFilesTask {
  constructor(data) {
    this.data = data;
    this.assets = [];
    this.isBeingWatched = false;
  }

  run() {
    this.data.options = Object.assign(
      {
        base: '',
        dot: false,
      },
      this.data.options
    );
    this.data.options.base = this.data.options.base.endsWith('/')
      ? this.data.options.base.slice(0, -1)
      : this.data.options.base;
    this.data.options.dot = !!this.data.options.dot;

    // Avoid duplicated execution on watching
    if (this.isBeingWatched) return;

    const options = { onlyFiles: false, dot: this.data.options.dot };

    for (let fromRelative of globbySync(this.data.from, options)) {
      const fromAbsolute = path.resolve(fromRelative);
      const stats = fs.statSync(fromAbsolute);
      this[stats.isFile() ? '_copyFile' : '_copyDir'](fromRelative);
    }
  }

  watch(usePolling = false) {
    if (this.isBeingWatched) return;

    const options = { usePolling, persistent: true, ignoreInitial: true };
    if (!this.data.options.dot) options.ignored = /(^|[\/\\])\../;
    chokidar
      .watch(this.data.from, options)
      .on('change', this._copyFile.bind(this))
      .on('add', this._copyFile.bind(this))
      .on('addDir', this._copyDir.bind(this))
      .on('unlink', this._removeFile.bind(this))
      .on('unlinkDir', this._removeDir.bind(this));
    this.isBeingWatched = true;
  }

  _copyFile(fromRelative) {
    const toRelative = this._createDestinationFilePath(fromRelative);
    Log.feedback(`Copying ${fromRelative} to ${toRelative}`);
    const fromAbsolute = path.resolve(fromRelative);
    const toAbsolute = path.resolve(toRelative);
    fs.copySync(fromAbsolute, toAbsolute);
  }
  _removeFile(fromRelative) {
    const toRelative = this._createDestinationFilePath(fromRelative);
    Log.feedback(`Removing ${toRelative}`);
    const toAbsolute = path.resolve(toRelative);
    fs.removeSync(toAbsolute);
  }

  _copyDir(fromDirRelative) {
    const toDirRelative = this._createDestinationDirPath(fromDirRelative);
    Log.feedback(`Copying ${fromDirRelative} to ${toDirRelative}`);
    const toDirAbsolute = path.resolve(toDirRelative);
    fs.mkdirpSync(toDirAbsolute);
    const options = { onlyFiles: false, dot: this.data.options.dot };
    const fromRelativeList = globbySync(fromDirRelative, options);
    for (let fromRelative of fromRelativeList) {
      const toRelative = this._createDestinationFilePath(fromRelative);
      const fromAbsolute = path.resolve(fromRelative);
      const toAbsolute = path.resolve(toRelative);
      if (fs.statSync(fromAbsolute).isDirectory()) {
        fs.mkdirpSync(toAbsolute);
      } else {
        fs.copySync(fromAbsolute, toAbsolute);
      }
    }
  }

  _removeDir(fromDirRelative) {
    const toDirRelative = this._createDestinationDirPath(fromDirRelative);
    Log.feedback(`Removing ${toDirRelative}`);
    const options = { onlyFiles: false, dot: this.data.options.dot };
    const fromRelativeList = globbySync(fromDirRelative, options);
    for (let fromRelative of fromRelativeList) {
      const fromAbsolute = path.resolve(fromRelative);
      if (fs.statSync(fromAbsolute).isDirectory()) continue;
      const toRelative = this._createDestinationFilePath(fromRelative);
    }
    const toDirAbsolute = path.resolve(toDirRelative);
    fs.removeSync(toDirAbsolute);
  }

  _createDestinationFilePath(from) {
    let to = '';
    if (path.extname(from) || path.basename(from).startsWith('.')) {
      if (!this.data.to.endsWith('/') && path.extname(this.data.to)) {
        to = this.data.to;
      } else {
        if (this.data.options.base) {
          let popped = from.split(this.data.options.base).pop();
          popped = popped.startsWith('/') ? popped.slice(1) : popped;
          to = path.join(this.data.to, popped);
        } else {
          to = path.join(this.data.to, path.basename(from));
        }
      }
    } else {
      to = this.data.to.endsWith('/')
        ? this.data.to.slice(0, -1)
        : this.data.to;
    }
    return to;
  }

  _createDestinationDirPath(from) {
    let to = '';
    const fromSlashless = from.endsWith('/') ? from.slice(0, -1) : from;
    const toSlashless = this.data.to.endsWith('/')
      ? this.data.to.slice(0, -1)
      : this.data.to;
    if (this.data.options.base) {
      let popped = from.split(this.data.options.base).pop();
      popped = popped.startsWith('/') ? popped.slice(1) : popped;
      to = path.join(this.data.to, popped);
    } else {
      const f = fromSlashless;
      if (
        (path.extname(f) || path.basename(f).startsWith('.')) &&
        !path.extname(toSlashless)
      ) {
        to = path.join(this.data.to, path.basename(from));
      } else {
        to = this.data.to;
      }
    }
    return to;
  }
}
