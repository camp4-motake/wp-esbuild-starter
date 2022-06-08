import { svgSprite } from './src/_lib/svgSprite.mjs';
import ImgMin from './src/_lib/ImgMin.mjs';

/**
 * svg sprite
 */
svgSprite('./src/images/_sprite/*.svg', './dist/images');

/**
 * compress image & webp generate
 */
new ImgMin({
  src: ['./src/**/*.{jpg,jpeg,png,svg}', '!**/_*/**'],
  dest: './dist',
  option: {
    base: './src',
    cacheDir: '../.cache/images',
  },
}).run();
