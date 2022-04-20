import { svgSprite } from './src/_lib/svgSprite.mjs';
import ImageCompress from './src/_lib/ImageCompress.mjs';

/**
 * svg sprite
 */
svgSprite('./src/images/_sprite/*.svg', './dist/images');

/**
 * compress image & webp generate
 */
new ImageCompress({
  src: ['./src/**/*.{jpg,jpeg,png,svg}', '!**/_*/**'],
  dest: './dist',
  option: {
    base: './src',
    cacheDir: '../.cache/images',
  },
});
