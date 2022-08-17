/**
 * compress image & generate webp
 */

import { existsSync } from 'fs';
import ImgMin from './src/_lib/ImgMin.mjs';

const root = existsSync('../../package.json') ? '../../' : './';

new ImgMin({
  src: ['./src/**/*.{jpg,jpeg,png,svg}', '!./src/**/_*/**'],
  dest: './dist',
  option: { base: './src', cacheDir: `${root}.cache/images` },
}).run();
