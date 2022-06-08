const purgeCssConfig = {
  safelist: {
    deep: [
      /^(disabled|data-[\w-]+|class|href|target|role|aria-[\w-]+|v-[\w-]+)$/,
      /^(nprogress|splitting|snackbar|wpcf7|swiper-|scroll-hint|wf-|wp-)(.*)?$/,
    ],
    greedy: [/^(js|is|has|wf|wp|u)[A-Z-_]\w+$/],
  },
  content: ['./**/*.+(html|php|twig|ts|tsx|js|jsx|vue)'],
  variables: true,
  keyframes: true,
};

module.exports = ({ env }) => {
  const inProduction = env === 'production';
  return {
    plugins: {
      'postcss-preset-env': {
        stage: 2,
        autoprefixer: { grid: 'autoplace' },
        features: { 'custom-properties': false },
      },
      'postcss-url': { filter: '**/_inline/*', url: 'inline' },
      'postcss-sort-media-queries': {},

      // production only
      ...(inProduction
        ? { '@fullhuman/postcss-purgecss': purgeCssConfig }
        : {}),
    },
  };
};
