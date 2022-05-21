const purgeCssConfig = {
  safelist: {
    deep: [
      /^(disabled|data-[\w-]+|class|href|target|role|aria-[\w-]+|v-[\w-]+)$/,
      /^(nprogress|splitting|snackbar|wpcf7|swiper-|scroll-hint|wf-|wp-)(.*)?$/,
    ],
    greedy: [/^(js|is|has|wf|wp|u)[A-Z-_]\w+$/],
  },
  content: ['./src/**/*.+(html|php|twig|ts|tsx|js|jsx|vue)'],
  variables: true,
  keyframes: true,
};

module.exports = (ctx) => {
  const inProduction = ctx.env === 'production';
  return {
    plugins: {
      'postcss-import': {},
      'postcss-preset-env': { stage: 1, autoprefixer: { grid: 'autoplace' } },
      'postcss-url': { filter: '**/_inline/*', url: 'inline' },
      'postcss-rem': {},
      'postcss-sort-media-queries': {},
      ...(inProduction
        ? { '@fullhuman/postcss-purgecss': purgeCssConfig }
        : {}),
    },
  };
};
