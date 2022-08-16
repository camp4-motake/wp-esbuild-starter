import ImgMin from './src/_lib/ImgMin.mjs';

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
