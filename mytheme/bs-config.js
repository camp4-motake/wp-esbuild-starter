const path = require('path');
const envFile = path.resolve(process.cwd(), '../.env');
require('dotenv').config({ path: envFile || null });
const wpPort = process.env.LOCAL_SERVER_PORT || 8888;

/**
 * Browsersync options
 * https://browsersync.io/docs/options
 */
module.exports = {
  ui: false,
  files: ['**/*.{php,twig}', 'theme.json', 'dist'],
  ignore: ['node_modules'],
  proxy: `http://localhost:${wpPort}`,
  ghostMode: false,
  open: false,
  notify: false,
};
