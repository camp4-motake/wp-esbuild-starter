/**
 *
 * vite plugin: simple svg sprite generate
 *
 * require: svg-sprite cli
 * https://github.com/svg-sprite/svg-sprite#configuration-basics
 *
 */

import childProcess from 'child_process';
import chokidar from 'chokidar';
import util from 'util';

const exec = util.promisify(childProcess.exec);

export const svgSprite = (
  srcPath = '',
  outPath = '',
  configPath = '',
  isWatch = false
) => {
  const config = configPath ? ` -c ${configPath}` : '';
  const command = [
    'svg-sprite',
    '-s',
    `--symbol-dest ${outPath}`,
    '--symbol-sprite svg-sprite.svg',
    '--svg-xmldecl false',
    `${srcPath}`,
    `${config}`,
    '--shape-transform svgo',
  ].join(' ');

  execCommand(command);

  if (isWatch) {
    watch(srcPath, command);
  }
};

/**
 * Watch task
 *
 * @param {string} srcPath
 * @param {string} command
 */
function watch(srcPath, command) {
  const watchOption = {
    usePolling: false,
    persistent: true,
    ignoreInitial: true,
  };
  chokidar
    .watch(srcPath, watchOption)
    .on('change', () => execCommand(command))
    .on('add', () => execCommand(command))
    .on('unlink', () => execCommand(command));
}

/**
 * exec cli command
 *
 * @param {string} command
 */
async function execCommand(command = '') {
  if (!command) return;
  await exec(command, (err, stdout, stderr) => {
    if (err) {
      console.log(stderr);
      return;
    }
    console.log(stdout);
  });
}
