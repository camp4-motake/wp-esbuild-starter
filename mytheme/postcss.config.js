const purgeCssConfig = {
  safelist: {
    deep: [
      /^(disabled|data-[\w-]+|class|href|target|role|aria-[\w-]+|v-[\w-]+)$/,
      /^(nprogress|splitting|snackbar|wpcf7|swiper-|scroll-hint|wf-|wp-)(.*)?$/,
    ],
    greedy: [/^(js|is|has|wf|wp|u)[A-Z-_]\w+$/],
  },
  content: ['./**/*.+(html|php|twig|ts|tsx|js|jsx|vue)'],
};

module.exports = {
  plugins: [
    require('autoprefixer'),
    require('postcss-url')({ filter: '**/_inline/*', url: 'inline' }),
    require('postcss-sort-media-queries'),
    require('@fullhuman/postcss-purgecss')(purgeCssConfig),
  ],
};
