import esbuild from 'esbuild';
import { sassPlugin } from 'esbuild-sass-plugin';
import postcss from 'postcss';
import autoprefixer from 'autoprefixer';
import postcssFlexbugsFixes from 'postcss-flexbugs-fixes';
import postcssUrl from 'postcss-url';
import postcssSortMediaQueries from 'postcss-sort-media-queries';
import postcssPurgeCss from '@fullhuman/postcss-purgecss';
import purgeCssWordpress from 'purgecss-with-wordpress';
import ImageCompress from './resources/lib/ImageCompress.mjs';

const inProd = process.env.NODE_ENV === 'production';
const inDev = process.env.NODE_ENV === 'development';

const purgeCssConfig = {
  safelist: {
    standard: [...purgeCssWordpress.safelist],
    deep: [
      /^(disabled|data-[\w-]+|class|href|target|role|aria-[\w-]+|v-[\w-]+)$/,
      /^(nprogress|splitting|snackbar|wpcf7|swiper-|scroll-hint|wf-|wp-)(.*)?$/,
    ],
    greedy: [/^(js|is|has|wf|wp|u)[A-Z-_]\w+$/],
  },
  content: [`*.+(php|html|twig|ts|tsx|js|jsx|vue)`],
  // variables: true,
};

const postcssPlugins = [
  autoprefixer({ grid: 'autoplace' }),
  postcssFlexbugsFixes(),
  postcssUrl({ filter: '**/_inline/*', url: 'inline' }),
  postcssSortMediaQueries(),
  ...(inProd ? [postcssPurgeCss(purgeCssConfig)] : []),
];

const build = async () => {
  /**
   * compress image & webp generate & copy
   */
  new ImageCompress({
    src: ['./resources/src/**/*.{jpg,jpeg,png,svg}', '!**/_*/**'],
    dest: './dist',
    option: {
      base: './resources/src',
      cacheDir: '../.cache/images',
    },
  });

  /**
   * esbuild
   * @link https://github.com/evanw/esbuild
   * @link https://esbuild.github.io/api/
   */
  esbuild.build({
    entryPoints: ['./resources/src/main.js', './resources/src/editor.js'],
    outdir: './dist',
    bundle: true,
    loader: { '.woff': 'dataurl' },
    minify: inProd,
    sourcemap: inDev,
    target: ['es6'],
    watch: inDev,
    plugins: [
      /**
       * esbuild-sass-plugin
       * @link https://github.com/glromeo/esbuild-sass-plugin
       * use postcss
       * @link https://github.com/glromeo/esbuild-sass-plugin#--postcss
       */
      sassPlugin({
        async transform(source) {
          const { css } = await postcss(postcssPlugins).process(source, {
            from: undefined,
            map: false,
          });
          return css;
        },
      }),
    ],
  });
};

await build();
