/**
 * Browsersync options
 * https://browsersync.io/docs/options
 */
module.exports = {
  ui: false,
  files: ['resources/src', '**/*.{php,twig}'],
  ignore: ['node_modules'],
  proxy: `http://localhost:${process.env.WP_ENV_PORT || 8888}`,
  ghostMode: false,
  open: false,
  notify: false,
};
