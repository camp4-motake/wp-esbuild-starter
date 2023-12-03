const { resolve } = require("path")
const dotenv = require("dotenv")

dotenv.config({ path: resolve(__dirname, "./.env") })

const { PROXY_URL, WP_PORT, WP_THEME_NAME } = process.env
const themePath = `source/wp-content/themes/${WP_THEME_NAME}`

module.exports = {
  files: [`**/*.php`, `dist/**/*`, `theme.json`].map((p) =>
    resolve(themePath, p),
  ),
  proxy: PROXY_URL || `http://localhost:${WP_PORT}`,
  ghostMode: false,
  notify: false,
  open: false,
  ui: false,
}
