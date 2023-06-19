const { resolve } = require("path");
const dotenv = require("dotenv");
dotenv.config({ path: resolve(process.cwd(), "./.env") });

const { PROXY_URL, WP_PORT, WP_THEME_NAME } = process.env;
const themePath = `source/wp-content/themes/${WP_THEME_NAME}/`;

module.exports = {
  ui: false,
  files: [
    resolve(themePath, `**/*.{php,twig,scss,css,js,ts,jsx,tsx}`),
    resolve(themePath, `theme.json`),
  ],
  proxy: PROXY_URL || `http://localhost:${WP_PORT}`,
  ghostMode: false,
  open: false,
  notify: false,
};
